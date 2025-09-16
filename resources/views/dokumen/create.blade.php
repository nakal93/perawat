@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-6">Upload Dokumen</h1>

    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg border">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Kategori Dokumen</label>
            <select name="kategori_dokumen_id" class="w-full border rounded-lg p-2" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_dokumen_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">File</label>
            <input type="file" name="file" class="w-full border rounded-lg p-2" required>
            @error('file')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="w-full border rounded-lg p-2">
                @error('tanggal_mulai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" class="w-full border rounded-lg p-2">
                @error('tanggal_berakhir')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <label class="inline-flex items-center">
            <input type="checkbox" name="berlaku_seumur_hidup" value="1" class="mr-2">
            <span>Berlaku seumur hidup</span>
        </label>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('dokumen.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection
