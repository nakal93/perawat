<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;
        $kategori = KategoriDokumen::orderBy('nama_kategori')->get();
        
        if (!$karyawan) {
            $dokumen = collect();
        } else {
            $query = $karyawan->dokumen()->with('kategoriDokumen');
            
            // Filter berdasarkan status
            $statusFilter = $request->get('status');
            if ($statusFilter) {
                $today = now()->startOfDay();
                $soon = now()->addDays(30)->endOfDay();
                
                switch ($statusFilter) {
                    case 'aktif':
                        $query->where(function($q) use ($today) {
                            $q->where('berlaku_seumur_hidup', true)
                              ->orWhere(function($q2) use ($today) {
                                  $q2->whereNotNull('tanggal_berakhir')
                                     ->where('tanggal_berakhir', '>=', $today);
                              });
                        });
                        break;
                    case 'akan_expire':
                        $query->where('berlaku_seumur_hidup', false)
                              ->whereNotNull('tanggal_berakhir')
                              ->whereBetween('tanggal_berakhir', [$today, $soon]);
                        break;
                    case 'expired':
                        $query->where('berlaku_seumur_hidup', false)
                              ->whereNotNull('tanggal_berakhir')
                              ->where('tanggal_berakhir', '<', $today);
                        break;
                }
            }
            
            // Paginate to improve initial load performance
            $dokumen = $query->latest()->paginate(12);
        }

        return view('dokumen.index', compact('kategori', 'dokumen', 'karyawan'));
    }

    public function create()
    {
        $kategori = KategoriDokumen::orderBy('nama_kategori')->get();
        return view('dokumen.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;

        $validated = $request->validate([
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'file' => 'required|file|max:5120|mimetypes:application/pdf,image/jpeg,image/png,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword|mimes:pdf,jpg,jpeg,png,doc,docx',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'berlaku_seumur_hidup' => 'nullable|boolean',
        ]);

        // Build deterministic filename: NamaUser-Kategori.ext with collision-safe suffix
        $file = $request->file('file');
        $kategori = KategoriDokumen::findOrFail($validated['kategori_dokumen_id']);
        // Name part: title-case per kata, lalu jadikan slug dengan '-'
        $namePart = Str::of($user->name ?? 'User')
            ->replace(['/', '\\', '_', '-'], ' ')
            ->squish()
            ->lower()
            ->title()
            ->replaceMatches('/[^A-Za-z0-9\s]+/', '')
            ->replaceMatches('/\s+/', '-')
            ->trim('-');
        $katPart = Str::of($kategori->nama_kategori ?? 'Dokumen')
            ->replace(['/', '\\'], '-')
            ->replaceMatches('/[^A-Za-z0-9\-\s_]+/', '')
            ->trim()
            ->replaceMatches('/[\s_]+/', '-')
            ->trim('-');
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $base = $namePart.'-'.$katPart;
        $candidate = $base.'.'.$ext;
        $i = 2;
        while (Storage::disk('local')->exists('dokumen/'.$candidate) || Storage::disk('public')->exists('dokumen/'.$candidate)) {
            $candidate = $base.'-'.$i.'.'.$ext;
            $i++;
        }
        $path = $file->storeAs('dokumen', $candidate, 'local');

        DokumenKaryawan::create([
            'karyawan_id' => $karyawan->id,
            'kategori_dokumen_id' => $validated['kategori_dokumen_id'],
            'file_path' => $path,
            'file_name' => $candidate,
            'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
            'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
            'berlaku_seumur_hidup' => (bool)($validated['berlaku_seumur_hidup'] ?? false),
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupload.');
    }

    public function destroy(DokumenKaryawan $dokumen)
    {
        $user = auth()->user();
        if (!$user->karyawan || $dokumen->karyawan_id !== $user->karyawan->id) {
            abort(403);
        }
        if ($dokumen->file_path) {
            // Attempt delete from both disks to cover legacy public files
            Storage::disk('local')->delete($dokumen->file_path);
            Storage::disk('public')->delete($dokumen->file_path);
        }
        $dokumen->delete();
        return back()->with('success', 'Dokumen dihapus.');
    }

    public function download(DokumenKaryawan $dokumen)
    {
        $user = auth()->user();
        if (!$user->karyawan || $dokumen->karyawan_id !== $user->karyawan->id) {
            abort(403);
        }
        if (!$dokumen->file_path) {
            abort(404);
        }
        // Prefer private disk; fallback to public for legacy files
        if (Storage::disk('local')->exists($dokumen->file_path)) {
            return Storage::disk('local')->download($dokumen->file_path, $dokumen->file_name);
        }
        if (Storage::disk('public')->exists($dokumen->file_path)) {
            return Storage::disk('public')->download($dokumen->file_path, $dokumen->file_name);
        }
        abort(404);
    }

    /**
     * Stream file inline for preview (images/PDF) with auth check.
     */
    public function preview(DokumenKaryawan $dokumen)
    {
        $user = auth()->user();
        if (!$user->karyawan || $dokumen->karyawan_id !== $user->karyawan->id) {
            abort(403);
        }
        if (!$dokumen->file_path) {
            abort(404);
        }

        $disk = Storage::disk('local')->exists($dokumen->file_path) ? 'local' : (Storage::disk('public')->exists($dokumen->file_path) ? 'public' : null);
        if (!$disk) {
            abort(404);
        }

        $mime = null;
        try {
            $mime = Storage::disk($disk)->mimeType($dokumen->file_path);
        } catch (\Throwable $e) {
            // fallback below
        }
        if (!$mime) {
            $ext = strtolower(pathinfo($dokumen->file_name ?: $dokumen->file_path, PATHINFO_EXTENSION));
            $map = [
                'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp',
                'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $mime = $map[$ext] ?? 'application/octet-stream';
        }

        $stream = Storage::disk($disk)->readStream($dokumen->file_path);
        if (!$stream) {
            abort(404);
        }

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            // Inline so <img> and <iframe> can render
            'Content-Disposition' => 'inline; filename="'.addslashes($dokumen->file_name ?: basename($dokumen->file_path)).'"',
            // Allow short-lived private caching to speed up repeated previews
            'Cache-Control' => 'private, max-age=300, must-revalidate',
            'Pragma' => 'private',
        ]);
    }
}
