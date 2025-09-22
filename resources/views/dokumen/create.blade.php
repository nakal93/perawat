@extends('layouts.app')

@section('content')
<!-- Mobile Layout - Edge to Edge -->
<div class="w-full block lg:hidden">
    <!-- Mobile Header dengan spacing yang lebih baik -->
    <div class="bg-white border-b border-gray-200 px-4 py-6">
        <h1 class="text-xl font-semibold text-gray-900">Upload Dokumen</h1>
        <p class="text-sm text-gray-600 mt-1">Tambahkan dokumen baru untuk karyawan</p>
    </div>

    <!-- Mobile Form -->
    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-0">
        @csrf

        <div class="bg-white border-b border-gray-200 px-4 py-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Kategori Dokumen</label>
            <select name="kategori_dokumen_id" class="w-full border border-gray-300 rounded-lg px-3 py-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_dokumen_id')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="bg-white border-b border-gray-200 px-4 py-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">File Dokumen</label>
            <input type="file" name="file" class="w-full border border-gray-300 rounded-lg px-3 py-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            <p class="text-sm text-gray-500 mt-2">Format yang didukung: PDF, JPG, PNG (Max: 10MB)</p>
            @error('file')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="bg-white border-b border-gray-200 px-4 py-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="w-full border border-gray-300 rounded-lg px-3 py-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_mulai')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" class="w-full border border-gray-300 rounded-lg px-3 py-3 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_berakhir')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="bg-white border-b border-gray-200 px-4 py-6">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="berlaku_seumur_hidup" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 mr-3">
                <span class="text-sm font-medium text-gray-700">Berlaku seumur hidup</span>
            </label>
            <p class="text-sm text-gray-500 mt-2 ml-8">Centang jika dokumen tidak memiliki tanggal kedaluwarsa</p>
        </div>

        <div class="bg-white px-4 py-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dokumen.index') }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg text-center font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Simpan Dokumen
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Desktop Layout - With Padding -->
<div class="max-w-xl mx-auto py-6 hidden lg:block">
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
