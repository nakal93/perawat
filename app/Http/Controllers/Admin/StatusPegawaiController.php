<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusPegawai;
use Illuminate\Http\Request;

class StatusPegawaiController extends Controller
{
    public function index()
    {
        $items = StatusPegawai::orderBy('nama')->get();
        return view('admin.status-pegawai.index', compact('items'));
    }

    // Halaman gabungan manage (reuse index view untuk sekarang)
    public function manage()
    {
        $items = StatusPegawai::orderBy('nama')->get();
        return view('admin.status-pegawai.manage', compact('items'));
    }

    public function create()
    {
        return view('admin.status-pegawai.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50|unique:status_pegawai,nama'
        ]);
        StatusPegawai::create($data);
        return redirect()->route('admin.status-pegawai.index')->with('success', 'Status pegawai ditambahkan');
    }

    public function edit(StatusPegawai $statusPegawai)
    {
        return view('admin.status-pegawai.edit', compact('statusPegawai'));
    }

    public function show(StatusPegawai $statusPegawai)
    {
        // Tidak butuh halaman detail, arahkan ke edit untuk penyuntingan cepat
        return redirect()->route('admin.status-pegawai.edit', $statusPegawai);
    }

    public function update(Request $request, StatusPegawai $statusPegawai)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50|unique:status_pegawai,nama,' . $statusPegawai->id,
        ]);
        $statusPegawai->update($data);
        return redirect()->route('admin.status-pegawai.index')->with('success', 'Status pegawai diperbarui');
    }

    public function destroy(StatusPegawai $statusPegawai)
    {
        // Optional: cegah hapus jika dipakai karyawan
        if ($statusPegawai->karyawan()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus: masih dipakai karyawan');
        }
        $statusPegawai->delete();
        return redirect()->route('admin.status-pegawai.index')->with('success', 'Status pegawai dihapus');
    }
}
