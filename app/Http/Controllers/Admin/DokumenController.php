<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenKaryawan::with(['karyawan.user', 'kategoriDokumen']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('kategoriDokumen', function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%");
            })->orWhere('file_name', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori_dokumen_id', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'expired') {
                $query->where('tanggal_berakhir', '<', now())
                     ->where('berlaku_seumur_hidup', false);
            } elseif ($request->status === 'expiring') {
                $query->where('tanggal_berakhir', '<=', now()->addDays(30))
                     ->where('tanggal_berakhir', '>=', now())
                     ->where('berlaku_seumur_hidup', false);
            } elseif ($request->status === 'active') {
                $query->where(function($q) {
                    $q->where('berlaku_seumur_hidup', true)
                      ->orWhere('tanggal_berakhir', '>', now());
                });
            }
        }

        $dokumen = $query->latest()->paginate(20);
        $kategori = KategoriDokumen::orderBy('nama_kategori')->get();
        
        return view('admin.dokumen.index', compact('dokumen', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriDokumen::orderBy('nama_kategori')->get();
        $karyawan = Karyawan::with('user')->orderBy('id')->get();
        
        return view('admin.dokumen.create', compact('kategori', 'karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after:tanggal_mulai',
            'berlaku_seumur_hidup' => 'boolean',
        ]);

        // Handle file upload to private storage (local) with deterministic naming
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $karyawan = Karyawan::with('user')->findOrFail($validated['karyawan_id']);
            $kategori = KategoriDokumen::findOrFail($validated['kategori_dokumen_id']);
            // Title-case untuk nama karyawan, lalu jadikan slug '-'
            $namePart = Str::of(optional($karyawan->user)->name ?? 'User')
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
            $filepath = $file->storeAs('dokumen', $candidate, 'local');

            $validated['file_path'] = $filepath;
            $validated['file_name'] = $candidate;
        }

        $validated['berlaku_seumur_hidup'] = $request->boolean('berlaku_seumur_hidup');
        $validated['status'] = 'aktif';

        DokumenKaryawan::create($validated);

        return redirect()->route('admin.dokumen.index')
                        ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(DokumenKaryawan $dokumen)
    {
        $dokumen->load(['karyawan.user', 'kategoriDokumen']);
        return view('admin.dokumen.show', compact('dokumen'));
    }

    public function edit(DokumenKaryawan $dokumen)
    {
        $dokumen->load(['karyawan.user', 'kategoriDokumen']);
        $kategori = KategoriDokumen::orderBy('nama_kategori')->get();
        $karyawan = Karyawan::with('user')->orderBy('id')->get();
        
        return view('admin.dokumen.edit', compact('dokumen', 'kategori', 'karyawan'));
    }

    public function update(Request $request, DokumenKaryawan $dokumen)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after:tanggal_mulai',
            'berlaku_seumur_hidup' => 'boolean',
        ]);

        // Handle file upload if new file provided (with deterministic naming)
        if ($request->hasFile('file')) {
            // Delete old file from both disks (legacy/public and new/local)
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
                Storage::disk('local')->delete($dokumen->file_path);
            }

            $file = $request->file('file');
            $karyawan = Karyawan::with('user')->findOrFail($validated['karyawan_id']);
            $kategori = KategoriDokumen::findOrFail($validated['kategori_dokumen_id']);
            $namePart = Str::of(optional($karyawan->user)->name ?? 'User')
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
            $filepath = $file->storeAs('dokumen', $candidate, 'local');

            $validated['file_path'] = $filepath;
            $validated['file_name'] = $candidate;
        }

        $validated['berlaku_seumur_hidup'] = $request->boolean('berlaku_seumur_hidup');

        $dokumen->update($validated);

        return redirect()->route('admin.dokumen.show', $dokumen)
                        ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(DokumenKaryawan $dokumen)
    {
        // Delete file from storage (both disks)
        if ($dokumen->file_path) {
            Storage::disk('local')->delete($dokumen->file_path);
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')
                        ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(DokumenKaryawan $dokumen)
    {
        if (!$dokumen->file_path) {
            abort(404, 'File tidak ditemukan.');
        }
        if (Storage::disk('local')->exists($dokumen->file_path)) {
            return Storage::disk('local')->download($dokumen->file_path, $dokumen->file_name);
        }
        if (Storage::disk('public')->exists($dokumen->file_path)) {
            return Storage::disk('public')->download($dokumen->file_path, $dokumen->file_name);
        }
        abort(404, 'File tidak ditemukan.');
    }

    /**
     * Stream file inline for preview in admin.
     */
    public function preview(DokumenKaryawan $dokumen)
    {
        if (!$dokumen->file_path) {
            abort(404);
        }
        $disk = Storage::disk('local')->exists($dokumen->file_path) ? 'local' : (Storage::disk('public')->exists($dokumen->file_path) ? 'public' : null);
        if (!$disk) abort(404);

        $mime = null;
        try { $mime = Storage::disk($disk)->mimeType($dokumen->file_path); } catch (\Throwable $e) {}
        if (!$mime) {
            $ext = strtolower(pathinfo($dokumen->file_name ?: $dokumen->file_path, PATHINFO_EXTENSION));
            $map = [
                'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp',
                'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $mime = $map[$ext] ?? 'application/octet-stream';
        }

        $stream = Storage::disk($disk)->readStream($dokumen->file_path);
        if (!$stream) abort(404);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.addslashes($dokumen->file_name ?: basename($dokumen->file_path)).'"',
            'Cache-Control' => 'private, max-age=0, no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }
}
