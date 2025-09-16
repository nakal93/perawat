@extends('layouts.app')

@section('title', 'Edit Kategori Dokumen')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Kategori Dokumen</h1>
            <p class="text-gray-600">Perbarui informasi kategori dokumen</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.kategori-dokumen.show', $kategoriDokumen) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
            <h4 class="font-medium">Terjadi kesalahan:</h4>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('admin.kategori-dokumen.update', $kategoriDokumen) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nama Kategori -->
                <div class="mb-6">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_kategori" 
                           name="nama_kategori" 
                           value="{{ old('nama_kategori', $kategoriDokumen->nama_kategori) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_kategori') border-red-500 @enderror"
                           placeholder="Contoh: KTP, SIM, Sertifikat"
                           required>
                    @error('nama_kategori')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan kategori dokumen ini...">{{ old('deskripsi', $kategoriDokumen->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                </div>

                <!-- Status Wajib -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Status Dokumen</label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="wajib" 
                                   value="1" 
                                   {{ old('wajib', $kategoriDokumen->wajib) == '1' ? 'checked' : '' }}
                                   class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Wajib</span>
                                <span class="block text-sm text-gray-500">Dokumen ini wajib dimiliki oleh semua karyawan</span>
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="wajib" 
                                   value="0" 
                                   {{ old('wajib', $kategoriDokumen->wajib) == '0' ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Opsional</span>
                                <span class="block text-sm text-gray-500">Dokumen ini bersifat pilihan/tidak wajib</span>
                            </span>
                        </label>
                    </div>
                    @error('wajib')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="inline-flex justify-center items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.kategori-dokumen.show', $kategoriDokumen) }}" 
                   class="inline-flex justify-center items-center px-6 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Warning Box -->
    @if($kategoriDokumen->dokumenKaryawan->count() > 0)
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Kategori ini memiliki {{ $kategoriDokumen->dokumenKaryawan->count() }} dokumen yang sudah diupload. Perubahan pada kategori ini akan mempengaruhi semua dokumen yang ada.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
