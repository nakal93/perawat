<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use Illuminate\Support\Facades\Storage;

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
            
            $dokumen = $query->latest()->get();
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
            'file' => 'required|file|max:5120',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'berlaku_seumur_hidup' => 'nullable|boolean',
        ]);

        $path = $request->file('file')->store('dokumen', 'public');

        DokumenKaryawan::create([
            'karyawan_id' => $karyawan->id,
            'kategori_dokumen_id' => $validated['kategori_dokumen_id'],
            'file_path' => $path,
            'file_name' => $request->file('file')->getClientOriginalName(),
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
        if (!$dokumen->file_path || !Storage::disk('public')->exists($dokumen->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($dokumen->file_path, $dokumen->file_name);
    }
}
