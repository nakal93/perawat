@extends('layouts.app')

@section('breadcrumb', 'Dokumen')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Dokumen</h1>
            <p class="text-gray-600 mt-1">Manajemen dokumen karyawan dan masa berlaku</p>
        </div>
            <a href="{{ route('admin.dokumen.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center mt-4 sm:mt-0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Dokumen
            </a>
        </div>

        <!-- Stats Cards -->
        @php
            $totalDokumen = \App\Models\DokumenKaryawan::count();
            $dokumenAktif = \App\Models\DokumenKaryawan::where(function($q) {
                $q->where('berlaku_seumur_hidup', true)->orWhere('tanggal_berakhir', '>', now());
            })->count();
            $dokumenExpired = \App\Models\DokumenKaryawan::where('tanggal_berakhir', '<', now())
                                ->where('berlaku_seumur_hidup', false)->count();
            $dokumenExpiring = \App\Models\DokumenKaryawan::where('tanggal_berakhir', '<=', now()->addDays(30))
                                 ->where('tanggal_berakhir', '>=', now())
                                 ->where('berlaku_seumur_hidup', false)->count();
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <a href="{{ route('admin.dokumen.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200 block">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalDokumen }}</div>
                        <div class="text-gray-600">Total Dokumen</div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('admin.dokumen.index', ['status' => 'active']) }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200 block">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $dokumenAktif }}</div>
                        <div class="text-gray-600">Dokumen Aktif</div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('admin.dokumen.index', ['status' => 'expiring']) }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200 block">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $dokumenExpiring }}</div>
                        <div class="text-gray-600">Akan Berakhir</div>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('admin.dokumen.index', ['status' => 'expired']) }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200 block">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $dokumenExpired }}</div>
                        <div class="text-gray-600">Sudah Berakhir</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.dokumen.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokumen</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nama karyawan, kategori dokumen, atau nama file..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="sm:w-48">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="kategori" 
                            name="kategori"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:w-40">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" 
                            name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>Akan Berakhir</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Sudah Berakhir</option>
                    </select>
                </div>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </form>
        </div>

        <!-- Document List -->
        <div class="bg-white rounded-lg shadow">
            @if($dokumen->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($dokumen as $doc)
                @php
                    $isExpired = !$doc->berlaku_seumur_hidup && $doc->tanggal_berakhir && $doc->tanggal_berakhir->isPast();
                    $isExpiring = !$doc->berlaku_seumur_hidup && $doc->tanggal_berakhir && $doc->tanggal_berakhir->isFuture() && $doc->tanggal_berakhir->diffInDays(now()) <= 30;
                @endphp
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- Document Info -->
                        <div class="flex-1">
                            <div class="flex items-start mb-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $doc->file_name }}</h3>
                                        @if($isExpired)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Berakhir
                                            </span>
                                        @elseif($isExpiring)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Akan Berakhir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-2">
                                        <strong>{{ $doc->karyawan->user->name ?? 'N/A' }}</strong> - 
                                        {{ $doc->kategoriDokumen->nama_kategori ?? 'N/A' }}
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-500">
                                        <div>
                                            <span class="font-medium">Mulai:</span> 
                                            {{ $doc->tanggal_mulai ? $doc->tanggal_mulai->format('d/m/Y') : 'N/A' }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Berakhir:</span> 
                                            @if($doc->berlaku_seumur_hidup)
                                                <span class="text-green-600 font-medium">Seumur Hidup</span>
                                            @else
                                                {{ $doc->tanggal_berakhir ? $doc->tanggal_berakhir->format('d/m/Y') : 'N/A' }}
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-medium">Diunggah:</span> 
                                            {{ $doc->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 mt-4 lg:mt-0 lg:ml-4">
                            <a href="{{ route('admin.dokumen.download', $doc) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg flex items-center text-sm"
                               target="_blank">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                            <a href="{{ route('admin.dokumen.show', $doc) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                            <a href="{{ route('admin.dokumen.edit', $doc) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $dokumen->withQueryString()->links() }}
            </div>
            @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Dokumen</h3>
                <p class="text-gray-500">Belum ada dokumen yang tersimpan dalam sistem.</p>
                <a href="{{ route('admin.dokumen.create') }}" 
                   class="inline-flex items-center mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Dokumen Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
