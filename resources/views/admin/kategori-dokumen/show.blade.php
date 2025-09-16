@extends('layouts.app')

@section('title', 'Detail Kategori Dokumen')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Detail Kategori Dokumen</h1>
            <p class="text-gray-600">Informasi lengkap kategori dokumen {{ $kategoriDokumen->nama_kategori }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.kategori-dokumen.edit', $kategoriDokumen) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.kategori-dokumen.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <!-- Informasi Kategori -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kategori</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <p class="text-gray-900 text-lg font-medium">{{ $kategoriDokumen->nama_kategori }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kategoriDokumen->wajib ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $kategoriDokumen->wajib ? 'Wajib' : 'Opsional' }}
                    </span>
                </div>
                
                @if($kategoriDokumen->deskripsi)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <p class="text-gray-900">{{ $kategoriDokumen->deskripsi }}</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat Pada</label>
                    <p class="text-gray-900">{{ $kategoriDokumen->created_at->format('d M Y H:i') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diperbarui</label>
                    <p class="text-gray-900">{{ $kategoriDokumen->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistik Dokumen</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $kategoriDokumen->dokumen_karyawan_count ?? 0 }}</div>
                    <div class="text-sm text-blue-800">Total Dokumen</div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $kategoriDokumen->dokumenKaryawan->where('status', 'disetujui')->count() }}
                    </div>
                    <div class="text-sm text-green-800">Dokumen Disetujui</div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $kategoriDokumen->dokumenKaryawan->where('status', 'pending')->count() }}
                    </div>
                    <div class="text-sm text-yellow-800">Menunggu Review</div>
                </div>
            </div>
        </div>

        <!-- Daftar Dokumen -->
        @if($kategoriDokumen->dokumenKaryawan->count() > 0)
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Karyawan ({{ $kategoriDokumen->dokumenKaryawan->count() }} dokumen)</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kategoriDokumen->dokumenKaryawan->take(10) as $dokumen)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $dokumen->karyawan->user->name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $dokumen->karyawan->nomor_induk ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dokumen->nama_file }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($dokumen->status === 'disetujui') bg-green-100 text-green-800
                                    @elseif($dokumen->status === 'ditolak') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($dokumen->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $dokumen->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($kategoriDokumen->dokumenKaryawan->count() > 10)
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-500">Menampilkan 10 dari {{ $kategoriDokumen->dokumenKaryawan->count() }} dokumen</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="p-6">
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada dokumen</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada karyawan yang mengupload dokumen untuk kategori ini.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
