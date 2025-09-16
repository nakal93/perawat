@extends('layouts.app')
@section('breadcrumb','Kelola Status Pegawai')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">Daftar Status Pegawai</h1>
                <a href="{{ route('admin.status-pegawai.index') }}" class="text-xs text-blue-600 hover:underline">Mode Tabel Penuh</a>
            </div>
            <div class="bg-white border rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->nama }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('admin.status-pegawai.edit',$item) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.status-pegawai.destroy',$item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus status ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-4 text-center text-slate-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white border rounded-xl p-5">
                <h2 class="text-sm font-semibold text-slate-700 mb-3">Tambah Status Baru</h2>
                <form method="POST" action="{{ route('admin.status-pegawai.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-slate-600">Nama Status</label>
                        <input type="text" name="nama" class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" required />
                        <x-input-error :messages="$errors->get('nama')" class="mt-1" />
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">Simpan</button>
                </form>
            </div>
            <div class="text-xs text-slate-500 leading-relaxed">
                <p><strong>Catatan:</strong> Status ini dipakai untuk menentukan apakah NIP wajib diisi pada profil karyawan. Hanya status PNS & PPPK yang mewajibkan NIP.</p>
            </div>
        </div>
    </div>
</div>
@endsection
