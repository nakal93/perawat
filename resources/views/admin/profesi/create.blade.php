@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="w-full max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.profesi.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Profesi Baru</h1>
                <p class="text-gray-600 mt-1">Tambahkan profesi/jabatan baru untuk karyawan</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.profesi.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="nama_profesi" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Profesi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_profesi" 
                           name="nama_profesi" 
                           value="{{ old('nama_profesi') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_profesi') border-red-500 @enderror"
                           placeholder="Contoh: Dokter Spesialis, Perawat, Administrasi"
                           required>
                    @error('nama_profesi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kode_profesi" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Profesi
                    </label>
                    <input type="text" 
                           id="kode_profesi" 
                           name="kode_profesi" 
                           value="{{ old('kode_profesi') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('kode_profesi') border-red-500 @enderror"
                           placeholder="Contoh: DOK, PRW, ADM">
                    @error('kode_profesi')
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
                              placeholder="Deskripsi tugas dan tanggung jawab profesi ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Profesi
                    </button>
                    <a href="{{ route('admin.profesi.index') }}" 
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
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2h-4a2 2 0 00-2-2V6m8 0h.01M16 20h.01M16 16h.01M12 20h.01M12 16h.01M8 20h.01M8 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900" id="preview-nama">Nama profesi akan muncul di sini</div>
                        <div class="text-sm text-gray-500" id="preview-deskripsi">Deskripsi profesi akan muncul di sini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama_profesi');
    const deskripsiInput = document.getElementById('deskripsi');
    const previewNama = document.getElementById('preview-nama');
    const previewDeskripsi = document.getElementById('preview-deskripsi');

    function updatePreview() {
        previewNama.textContent = namaInput.value || 'Nama profesi akan muncul di sini';
        previewDeskripsi.textContent = deskripsiInput.value || 'Deskripsi profesi akan muncul di sini';
    }

    namaInput.addEventListener('input', updatePreview);
    deskripsiInput.addEventListener('input', updatePreview);
});
</script>
@endsection
