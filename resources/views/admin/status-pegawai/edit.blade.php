@extends('layouts.app')
@section('breadcrumb','Edit Status Pegawai')
@section('content')
<div class="max-w-md mx-auto bg-white border rounded-xl p-6">
    <h1 class="text-lg font-semibold mb-4">Edit Status Pegawai</h1>
    <form method="POST" action="{{ route('admin.status-pegawai.update',$statusPegawai) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm text-slate-700">Nama Status</label>
            <input type="text" name="nama" value="{{ old('nama',$statusPegawai->nama) }}" required class="mt-1 w-full border rounded-lg px-3 py-2" />
            <x-input-error :messages="$errors->get('nama')" class="mt-1" />
        </div>
        <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
            <a href="{{ route('admin.status-pegawai.index') }}" class="px-4 py-2 bg-slate-100 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
