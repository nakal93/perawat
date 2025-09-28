@extends('layouts.app')

@section('title', 'Detail Dokumen')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Header dengan breadcrumb -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <nav class="flex mb-3" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('admin.dokumen.index') }}" class="ml-1 text-gray-500 hover:text-gray-700 md:ml-2">Dokumen</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-700 md:ml-2">Detail</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Detail Dokumen</h2>
                    <p class="text-sm text-gray-600">Informasi lengkap dokumen karyawan</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    @if($dokumen->file_path)
                        <a href="{{ route('admin.dokumen.download', $dokumen) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                    @endif
                    <a href="{{ route('admin.dokumen.edit', $dokumen) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h6m2-13v4m4-4v8a2 2 0 01-2 2H9m10-2v-4a2 2 0 00-2-2h-4m6 4v2"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Informasi Dokumen -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Dokumen</h3>
                    </div>

                    @php
                        // Hitung ukuran file dari storage privat; fallback ke public
                        $sizeBytes = null;
                        try {
                            if ($dokumen->file_path) {
                                if (Storage::disk('local')->exists($dokumen->file_path)) {
                                    $sizeBytes = Storage::disk('local')->size($dokumen->file_path);
                                } elseif (Storage::disk('public')->exists($dokumen->file_path)) {
                                    $sizeBytes = Storage::disk('public')->size($dokumen->file_path);
                                }
                            }
                        } catch (\Throwable $e) { $sizeBytes = null; }
                        $sizeHuman = '-';
                        if (is_int($sizeBytes)) {
                            $units = ['B','KB','MB','GB','TB'];
                            $pow = $sizeBytes > 0 ? floor(log($sizeBytes, 1024)) : 0;
                            $pow = min($pow, count($units)-1);
                            $sizeHuman = number_format($sizeBytes / pow(1024, $pow), $pow >= 2 ? 2 : 0).' '.$units[$pow];
                        }
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kategori Dokumen</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $dokumen->kategoriDokumen->nama_kategori ?? 'Tidak ada kategori' }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Nama File</dt>
                                <dd class="text-sm font-semibold text-gray-900 break-all">{{ $dokumen->file_name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</dt>
                                <dd>
                                    @php
                                        $now = now();
                                        $isActive = $dokumen->berlaku_seumur_hidup || ($dokumen->tanggal_berakhir && $dokumen->tanggal_berakhir >= $now);
                                        $isExpiringSoon = !$dokumen->berlaku_seumur_hidup && $dokumen->tanggal_berakhir && $dokumen->tanggal_berakhir <= $now->copy()->addDays(30) && $dokumen->tanggal_berakhir >= $now;
                                        $isExpired = !$dokumen->berlaku_seumur_hidup && $dokumen->tanggal_berakhir && $dokumen->tanggal_berakhir < $now;
                                    @endphp
                                    
                                    @if($isExpired)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                    @elseif($isExpiringSoon)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Akan Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Mulai</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    {{ $dokumen->tanggal_mulai ? $dokumen->tanggal_mulai->format('d M Y') : '-' }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Berakhir</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    @if($dokumen->berlaku_seumur_hidup)
                                        <span class="text-green-600">Seumur Hidup</span>
                                    @else
                                        {{ $dokumen->tanggal_berakhir ? $dokumen->tanggal_berakhir->format('d M Y') : '-' }}
                                    @endif
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Diunggah</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    {{ $dokumen->created_at->format('d M Y H:i') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Ukuran File</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $sizeHuman }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Dokumen (menggunakan route preview privat) -->
                @if($dokumen->file_path)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Preview Dokumen</h3>
                    </div>

                    @php
                        $fileExtension = pathinfo($dokumen->file_name, PATHINFO_EXTENSION);
                        $fileRel = route('admin.dokumen.preview', $dokumen);
                    @endphp

                    @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <!-- Preview untuk gambar -->
                        <div class="border rounded-lg overflow-hidden">
                            <img src="{{ $fileRel }}" 
                                 alt="{{ $dokumen->file_name }}" 
                                 class="w-full h-auto max-h-96 object-contain bg-gray-50"
                                 onclick="openImageModal('{{ $fileRel }}', '{{ $dokumen->file_name }}')">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                    @elseif(strtolower($fileExtension) === 'pdf')
                        <!-- Preview untuk PDF -->
                        <div class="border rounded-lg overflow-hidden">
                            <iframe src="{{ $fileRel }}" 
                                    class="w-full h-96" 
                                    frameborder="0">
                            </iframe>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Preview PDF - <a href="{{ $fileRel }}" target="_blank" class="text-blue-600 hover:underline">Buka di tab baru</a></p>
                    @else
                        <!-- File lainnya -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600 mb-2">File: {{ $dokumen->file_name }}</p>
                            <p class="text-sm text-gray-500">Preview tidak tersedia untuk tipe file ini</p>
                            <a href="{{ route('admin.dokumen.download', $dokumen) }}" class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Unduh File
                            </a>
                        </div>
                    @endif
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                
                <!-- Informasi Karyawan -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Pemilik Dokumen</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                @if($dokumen->karyawan && $dokumen->karyawan->foto_profil)
                                    <img src="{{ asset('storage/' . $dokumen->karyawan->foto_profil) }}" 
                                         alt="{{ $dokumen->karyawan->user->name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $dokumen->karyawan->user->name ?? 'Tidak diketahui' }}</p>
                                <p class="text-sm text-gray-500">{{ $dokumen->karyawan->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        @if($dokumen->karyawan)
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="text-gray-500 mb-1">NIK</dt>
                                <dd class="font-medium text-gray-900">{{ $dokumen->karyawan->nik ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 mb-1">NIP</dt>
                                <dd class="font-medium text-gray-900">{{ $dokumen->karyawan->nip ?? '-' }}</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-gray-500 mb-1">Ruangan</dt>
                                <dd class="font-medium text-gray-900">{{ $dokumen->karyawan->ruangan->nama_ruangan ?? '-' }}</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-gray-500 mb-1">Profesi</dt>
                                <dd class="font-medium text-gray-900">{{ $dokumen->karyawan->profesi->nama_profesi ?? '-' }}</dd>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            @if($dokumen->karyawan)
                            <a href="{{ route('admin.karyawan.show', $dokumen->karyawan) }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Lihat Profil Lengkap →
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.dokumen.edit', $dokumen) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium rounded-lg text-sm transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h6m2-13v4m4-4v8a2 2 0 01-2 2H9m10-2v-4a2 2 0 00-2-2h-4m6 4v2"></path>
                            </svg>
                            Edit Dokumen
                        </a>
                        
                        @if($dokumen->file_path)
                        <a href="{{ route('admin.dokumen.download', $dokumen) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download File
                        </a>
                        @endif
                        
                        <form action="{{ route('admin.dokumen.destroy', $dokumen) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin menghapus dokumen ini?')"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Dokumen
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal untuk preview gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="max-w-4xl max-h-full p-4">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openImageModal(src, alt) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalImage').alt = alt;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush