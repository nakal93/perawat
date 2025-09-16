@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.dokumen.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Dokumen Baru</h1>
                <p class="text-gray-600 mt-1">Upload dokumen karyawan dengan informasi masa berlaku</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Karyawan Selection -->
                <div class="mb-6">
                    <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Karyawan <span class="text-red-500">*</span>
                    </label>
                    <select id="karyawan_id" 
                            name="karyawan_id" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('karyawan_id') border-red-500 @enderror">
                        <option value="">Pilih Karyawan</option>
                        @foreach($karyawan as $kar)
                            <option value="{{ $kar->id }}" {{ old('karyawan_id') == $kar->id ? 'selected' : '' }}>
                                {{ $kar->user->name ?? 'N/A' }} - {{ $kar->profesi->nama ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori Dokumen -->
                <div class="mb-6">
                    <label for="kategori_dokumen_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Dokumen <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori_dokumen_id" 
                            name="kategori_dokumen_id" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('kategori_dokumen_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori Dokumen</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_dokumen_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_dokumen_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        File Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                        <input type="file" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               required
                               class="hidden"
                               onchange="displayFileName(this)">
                        <label for="file" class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium text-blue-600 hover:text-blue-500">Klik untuk upload</span>
                                atau drag and drop
                            </div>
                            <p class="text-xs text-gray-500 mt-2">PDF, JPG, JPEG, PNG (max. 2MB)</p>
                        </label>
                        <div id="file-name" class="mt-2 text-sm text-gray-700 hidden"></div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-6">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="tanggal_mulai" 
                           name="tanggal_mulai" 
                           value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Berlaku Seumur Hidup Checkbox -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="berlaku_seumur_hidup" 
                               name="berlaku_seumur_hidup" 
                               value="1"
                               {{ old('berlaku_seumur_hidup') ? 'checked' : '' }}
                               onchange="toggleTanggalBerakhir()"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="berlaku_seumur_hidup" class="ml-2 block text-sm text-gray-700">
                            Berlaku seumur hidup (tidak ada tanggal berakhir)
                        </label>
                    </div>
                </div>

                <!-- Tanggal Berakhir -->
                <div class="mb-6" id="tanggal-berakhir-container">
                    <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Berakhir
                    </label>
                    <input type="date" 
                           id="tanggal_berakhir" 
                           name="tanggal_berakhir" 
                           value="{{ old('tanggal_berakhir') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('tanggal_berakhir') border-red-500 @enderror">
                    @error('tanggal_berakhir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Dokumen
                    </button>
                    <a href="{{ route('admin.dokumen.index') }}" 
                       class="flex-1 sm:flex-none bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-700">
                    <h4 class="font-medium mb-1">Tips Upload Dokumen:</h4>
                    <ul class="list-disc list-inside space-y-1 text-blue-600">
                        <li>Format yang didukung: PDF, JPG, JPEG, PNG</li>
                        <li>Ukuran maksimal file: 2MB</li>
                        <li>Pastikan dokumen dapat dibaca dengan jelas</li>
                        <li>Centang "Berlaku seumur hidup" untuk dokumen yang tidak ada masa berlaku</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function displayFileName(input) {
    const fileNameDiv = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
        fileNameDiv.innerHTML = `
            <div class="flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">${fileName}</span>
                <span class="text-gray-500 ml-2">(${fileSize} MB)</span>
            </div>
        `;
        fileNameDiv.classList.remove('hidden');
    } else {
        fileNameDiv.classList.add('hidden');
    }
}

function toggleTanggalBerakhir() {
    const checkbox = document.getElementById('berlaku_seumur_hidup');
    const container = document.getElementById('tanggal-berakhir-container');
    const input = document.getElementById('tanggal_berakhir');
    
    if (checkbox.checked) {
        container.style.display = 'none';
        input.value = '';
        input.removeAttribute('required');
    } else {
        container.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTanggalBerakhir();
});
</script>
@endsection
