<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('dokumen', $filename, 'public');
            
            $validated['file_path'] = $filepath;
            $validated['file_name'] = $file->getClientOriginalName();
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

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('dokumen', $filename, 'public');
            
            $validated['file_path'] = $filepath;
            $validated['file_name'] = $file->getClientOriginalName();
        }

        $validated['berlaku_seumur_hidup'] = $request->boolean('berlaku_seumur_hidup');

        $dokumen->update($validated);

        return redirect()->route('admin.dokumen.show', $dokumen)
                        ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(DokumenKaryawan $dokumen)
    {
        // Delete file from storage
        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')
                        ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(DokumenKaryawan $dokumen)
    {
        if (!$dokumen->file_path || !Storage::disk('public')->exists($dokumen->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($dokumen->file_path, $dokumen->file_name);
    }
}
