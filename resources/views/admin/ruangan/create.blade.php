@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.ruangan.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Ruangan Baru</h1>
                <p class="text-gray-600 mt-1">Tambahkan ruangan/departemen baru untuk karyawan</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.ruangan.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="nama_ruangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_ruangan" 
                           name="nama_ruangan" 
                           value="{{ old('nama_ruangan') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_ruangan') border-red-500 @enderror"
                           placeholder="Contoh: Ruang IGD, ICU, Administrasi"
                           required>
                    @error('nama_ruangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kode_ruangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Ruangan
                    </label>
                    <input type="text" 
                           id="kode_ruangan" 
                           name="kode_ruangan" 
                           value="{{ old('kode_ruangan') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('kode_ruangan') border-red-500 @enderror"
                           placeholder="Contoh: IGD, ICU, ADM">
                    @error('kode_ruangan')
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
                              placeholder="Deskripsi fungsi dan layanan ruangan ini...">{{ old('deskripsi') }}</textarea>
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
                        Simpan Ruangan
                    </button>
                    <a href="{{ route('admin.ruangan.index') }}" 
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900" id="preview-nama">Nama ruangan akan muncul di sini</div>
                        <div class="text-xs text-gray-500" id="preview-kode"></div>
                        <div class="text-sm text-gray-500" id="preview-deskripsi">Deskripsi ruangan akan muncul di sini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama_ruangan');
    const deskripsiInput = document.getElementById('deskripsi');
    const kodeInput = document.getElementById('kode_ruangan');
    const previewNama = document.getElementById('preview-nama');
    const previewDeskripsi = document.getElementById('preview-deskripsi');
    const previewKode = document.getElementById('preview-kode');

    function updatePreview() {
        previewNama.textContent = namaInput.value || 'Nama ruangan akan muncul di sini';
        previewDeskripsi.textContent = deskripsiInput.value || 'Deskripsi ruangan akan muncul di sini';
        previewKode.textContent = kodeInput.value ? `Kode: ${kodeInput.value}` : '';
    }

    namaInput.addEventListener('input', updatePreview);
    deskripsiInput.addEventListener('input', updatePreview);
    kodeInput.addEventListener('input', updatePreview);
});
</script>
@endsection
