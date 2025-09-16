<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriDokumen;

class KategoriDokumenController extends Controller
{
    public function index()
    {
        $kategoris = KategoriDokumen::withCount('dokumenKaryawan')
                                  ->orderBy('nama_kategori')
                                  ->paginate(20);
        
        return view('admin.kategori-dokumen.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_dokumen,nama_kategori',
            'deskripsi' => 'nullable|string|max:1000',
            'wajib' => 'boolean',
        ]);

        $validated['wajib'] = $request->boolean('wajib');

        KategoriDokumen::create($validated);

        return redirect()->route('admin.kategori-dokumen.index')
                        ->with('success', 'Kategori dokumen berhasil ditambahkan.');
    }

    public function show(KategoriDokumen $kategoriDokumen)
    {
        $kategoriDokumen->load(['dokumenKaryawan.karyawan.user']);
        return view('admin.kategori-dokumen.show', compact('kategoriDokumen'));
    }

    public function edit(KategoriDokumen $kategoriDokumen)
    {
        return view('admin.kategori-dokumen.edit', compact('kategoriDokumen'));
    }

    public function update(Request $request, KategoriDokumen $kategoriDokumen)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_dokumen,nama_kategori,' . $kategoriDokumen->id,
            'deskripsi' => 'nullable|string|max:1000',
            'wajib' => 'boolean',
        ]);

        $validated['wajib'] = $request->boolean('wajib');

        $kategoriDokumen->update($validated);

        return redirect()->route('admin.kategori-dokumen.show', $kategoriDokumen)
                        ->with('success', 'Kategori dokumen berhasil diperbarui.');
    }

    public function destroy(KategoriDokumen $kategoriDokumen)
    {
        // Check if kategori has documents
        if ($kategoriDokumen->dokumenKaryawan()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Kategori dokumen tidak dapat dihapus karena masih digunakan.');
        }

        $kategoriDokumen->delete();

        return redirect()->route('admin.kategori-dokumen.index')
                        ->with('success', 'Kategori dokumen berhasil dihapus.');
    }
}
