@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.kategori-dokumen.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Kategori Dokumen</h1>
                <p class="text-gray-600 mt-1">Buat kategori baru untuk klasifikasi dokumen karyawan</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.kategori-dokumen.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_kategori" 
                           name="nama_kategori" 
                           value="{{ old('nama_kategori') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_kategori') border-red-500 @enderror"
                           placeholder="Contoh: KTP, SIM, Sertifikat"
                           required>
                    @error('nama_kategori')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan jenis dokumen yang termasuk dalam kategori ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="wajib" 
                               name="wajib" 
                               value="1"
                               {{ old('wajib') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                        <div class="ml-3">
                            <label for="wajib" class="block text-sm font-medium text-gray-700">
                                Kategori Wajib
                            </label>
                            <p class="text-sm text-gray-500">
                                Dokumen dalam kategori ini wajib dimiliki oleh setiap karyawan
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Kategori
                    </button>
                    <a href="{{ route('admin.kategori-dokumen.index') }}" 
                       class="flex-1 sm:flex-none bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
            <div class="bg-white rounded border p-3">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="font-medium text-gray-900" id="preview-nama">Nama kategori akan muncul di sini</div>
                            <span id="preview-badge" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Opsional
                            </span>
                        </div>
                        <div class="text-sm text-gray-500" id="preview-deskripsi">Deskripsi kategori akan muncul di sini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Examples Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-700">
                    <h4 class="font-medium mb-2">Contoh Kategori Dokumen:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <h5 class="font-medium text-blue-800">Dokumen Wajib:</h5>
                            <ul class="list-disc list-inside text-blue-600 mt-1">
                                <li>KTP (Kartu Tanda Penduduk)</li>
                                <li>CV (Curriculum Vitae)</li>
                                <li>Ijazah Pendidikan</li>
                                <li>Surat Keterangan Sehat</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-blue-800">Dokumen Opsional:</h5>
                            <ul class="list-disc list-inside text-blue-600 mt-1">
                                <li>SIM (Surat Izin Mengemudi)</li>
                                <li>Sertifikat Keahlian</li>
                                <li>NPWP</li>
                                <li>Dokumen Pendukung Lainnya</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama');
    const deskripsiInput = document.getElementById('deskripsi');
    const wajibCheckbox = document.getElementById('wajib');
    const previewNama = document.getElementById('preview-nama');
    const previewDeskripsi = document.getElementById('preview-deskripsi');
    const previewBadge = document.getElementById('preview-badge');

    function updatePreview() {
        previewNama.textContent = namaInput.value || 'Nama kategori akan muncul di sini';
        previewDeskripsi.textContent = deskripsiInput.value || 'Deskripsi kategori akan muncul di sini';
        
        if (wajibCheckbox.checked) {
            previewBadge.textContent = 'Wajib';
            previewBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
        } else {
            previewBadge.textContent = 'Opsional';
            previewBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
        }
    }

    namaInput.addEventListener('input', updatePreview);
    deskripsiInput.addEventListener('input', updatePreview);
    wajibCheckbox.addEventListener('change', updatePreview);
});
</script>
@endsection
