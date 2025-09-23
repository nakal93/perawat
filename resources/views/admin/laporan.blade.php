@extends('layouts.app')

@section('breadcrumb', 'Laporan')

@push('styles')
<style>
    .chart-container {
        position: relative;
        width: 100%;
        max-width: 100%;
    }
    
    .chart-legend {
            </div>
        </div>

            
            <form method="GET" action="{{ route('admin.laporan') }}" class="bg-white rounded border border-slate-200 p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Unit (Ruangan)</label>
                        <select name="ruangan_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Ruangan</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" {{ (string)request('ruangan_id') === (string)$r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Profesi</label>
                        <select name="profesi_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Profesi</option>
                            @foreach($profesi as $p)
                                <option value="{{ $p->id }}" {{ (string)request('profesi_id') === (string)$p->id ? 'selected' : '' }}>{{ $p->nama_profesi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Pegawai</label>
                        <select name="status_pegawai_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            @foreach($statusPegawai as $s)
                                <option value="{{ $s->id }}" {{ (string)request('status_pegawai_id') === (string)$s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Kelengkapan</label>
                        <select name="status_kelengkapan" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            <option value="lengkap" {{ request('status_kelengkapan')==='lengkap' ? 'selected' : '' }}>Data Diri Lengkap</option>
                            <option value="belum_lengkap" {{ request('status_kelengkapan')==='belum_lengkap' ? 'selected' : '' }}>Data Diri Belum Lengkap</option>
                            <option value="dokumen_lengkap" {{ request('status_kelengkapan')==='dokumen_lengkap' ? 'selected' : '' }}>Dokumen Wajib Lengkap</option>
                            <option value="dokumen_belum_lengkap" {{ request('status_kelengkapan')==='dokumen_belum_lengkap' ? 'selected' : '' }}>Dokumen Wajib Belum Lengkap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            <option value="Laki-laki" {{ request('jenis_kelamin')==='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ request('jenis_kelamin')==='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Masuk (Dari - Sampai)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="date" name="tanggal_masuk_from" value="{{ request('tanggal_masuk_from') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <input type="date" name="tanggal_masuk_to" value="{{ request('tanggal_masuk_to') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pencarian</label>
    
    .chart-legend-item {
        display: flex;
                    </div>
        align-items: center;
        font-size: 0.875rem;
    }
    
    .chart-legend-color {
        width: 12px;
        height: 12px;
        border-radius: 2px;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-br from-slate-50 to-gray-100 pt-8">
    <div class="container-fluid w-full px-5 pb-12">
        <!-- Dashboard Statistics Cards -->
    <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-6 gap-2 mb-4">
            <!-- Total Karyawan -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Total</h3>
                        <p class="text-lg font-bold text-blue-600">{{ $karyawan->total() }}</p>
                        <p class="text-xs text-slate-500">Karyawan</p>
                    </div>
                </div>
            </div>

            <!-- Data Diri Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-green-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Diri ✓</h3>
                        <p class="text-lg font-bold text-green-600">{{ $karyawan->where('status_kelengkapan', 'lengkap')->count() }}</p>
                        <p class="text-xs text-slate-500">Lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Data Diri Belum Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-yellow-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Diri ⚠</h3>
                        <p class="text-lg font-bold text-yellow-600">{{ $karyawan->where('status_kelengkapan', '!=', 'lengkap')->count() }}</p>
                        <p class="text-xs text-slate-500">Kurang</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen Belum Lengkap -->
            @php
                $kategoriWajib = \App\Models\KategoriDokumen::where('wajib', true)->get();
                $dokumenLengkap = 0;
                $dokumenBelumLengkap = 0;
                
                foreach($karyawan as $k) {
                    $uploadedKategori = $k->dokumen->pluck('kategori_dokumen_id')->unique();
                    $missingKategori = $kategoriWajib->filter(function($kat) use ($uploadedKategori) {
                        return !$uploadedKategori->contains($kat->id);
                    });
                    if($missingKategori->count() == 0) {
                        $dokumenLengkap++;
                    } else {
                        $dokumenBelumLengkap++;
                    }
                }
            @endphp
            
            <!-- Dokumen Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Dok ✓</h3>
                        <p class="text-lg font-bold text-blue-600">{{ $dokumenLengkap }}</p>
                        <p class="text-xs text-slate-500">Lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen Belum Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-orange-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Dok ⚠</h3>
                        <p class="text-lg font-bold text-orange-600">{{ $dokumenBelumLengkap }}</p>
                        <p class="text-xs text-slate-500">Kurang</p>
                    </div>
                </div>
            </div>

            <!-- Total Ruangan -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-purple-600 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-slate-900">Ruangan</h3>
                        <p class="text-lg font-bold text-purple-600">{{ $ruangan->count() }}</p>
                        <p class="text-xs text-slate-500">Unit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts simplified: one horizontal row aligned to the right -->
        <div class="overflow-x-auto mb-4">
            <div class="flex flex-row flex-nowrap items-stretch gap-2 md:justify-end lg:justify-end">
                <!-- Data Diri -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[220px] sm:min-w-[240px] md:min-w-[260px] lg:min-w-[280px] xl:min-w-[300px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Data Diri</h3>
                        <div class="text-xs text-slate-500">{{ $karyawan->total() }}</div>
                    </div>
                    <div class="chart-container h-40 sm:h-44 md:h-48">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="chart-legend text-xs hidden sm:flex" id="statusLegend"></div>
                </div>

                <!-- Dokumen -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[220px] sm:min-w-[240px] md:min-w-[260px] lg:min-w-[280px] xl:min-w-[300px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Dokumen</h3>
                        <div class="text-xs text-slate-500">{{ $karyawan->total() }}</div>
                    </div>
                    <div class="chart-container h-40 sm:h-44 md:h-48">
                        <canvas id="dokumenChart"></canvas>
                    </div>
                    <div class="chart-legend text-xs hidden sm:flex" id="dokumenLegend"></div>
                </div>

                <!-- Profesi (Top 8) -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[260px] sm:min-w-[300px] md:min-w-[320px] lg:min-w-[340px] xl:min-w-[360px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Profesi (Top 8)</h3>
                        <div class="text-xs text-slate-500">Bar</div>
                    </div>
                    <div class="chart-container h-48 sm:h-52 md:h-56">
                        <canvas id="profesiChart"></canvas>
                    </div>
                </div>

                <!-- Ruangan (Top 8) -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[220px] sm:min-w-[240px] md:min-w-[260px] lg:min-w-[280px] xl:min-w-[300px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Ruangan (Top 8)</h3>
                        <div class="text-xs text-slate-500">Donat</div>
                    </div>
                    <div class="chart-container h-40 sm:h-44 md:h-48">
                        <canvas id="ruanganChart"></canvas>
                    </div>
                    <div class="chart-legend text-xs hidden sm:flex" id="ruanganLegend"></div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[220px] sm:min-w-[240px] md:min-w-[260px] lg:min-w-[280px] xl:min-w-[300px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Jenis Kelamin</h3>
                        <div class="text-xs text-slate-500">Donat</div>
                    </div>
                    <div class="chart-container h-40 sm:h-44 md:h-48">
                        <canvas id="genderChart"></canvas>
                    </div>
                    <div class="chart-legend text-xs hidden sm:flex" id="genderLegend"></div>
                </div>

                <!-- Tren Bergabung (12 Bulan) -->
                <div class="bg-white rounded border border-slate-200 p-2 min-w-[260px] sm:min-w-[300px] md:min-w-[320px] lg:min-w-[340px] xl:min-w-[360px] flex-shrink-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-xs font-semibold text-slate-900">Tren Bergabung</h3>
                        <div class="text-xs text-slate-500">12 bln</div>
                    </div>
                    <div class="chart-container h-48 sm:h-52 md:h-56">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

            
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="NIK, NIP, atau Nama..." 
                                   class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filter
                        </button>
                        
                        <a href="{{ route('admin.laporan') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                            Reset
                        </a>
                        
                        <!-- Tombol Export -->
                        <div class="ml-auto flex items-center gap-3">
                            <a href="{{ route('admin.laporan.export-csv', request()->query()) }}" 
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Unduh CSV
                            </a>
                            <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" 
                               class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12" />
                                </svg>
                                Unduh Excel
                            </a>
                            <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" 
                               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                                </svg>
                                Unduh PDF
                            </a>
                            
                            <a href="{{ route('admin.laporan.print', request()->query()) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Cetak F4
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Data List -->
            <div class="bg-white rounded border border-slate-200 overflow-hidden">
                <div class="px-3 py-2 border-b border-slate-200 bg-indigo-600">
                    <h3 class="text-sm font-semibold text-white">
                        Data Karyawan 
                        <span class="text-sm font-normal text-indigo-100">({{ $karyawan->total() }} total)</span>
                    </h3>
                </div>

                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Identitas</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kontak & Alamat</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Unit & Profesi</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($karyawan as $k)
                                <tr class="hover:bg-slate-50 align-top">
                                    <td class="px-3 py-2 text-sm text-slate-900">
                                        {{ ($karyawan->currentPage() - 1) * $karyawan->perPage() + $loop->iteration }}
                                    </td>
                                                                        <td class="px-3 py-2 text-sm">
                                        <div class="text-slate-900 font-medium">{{ $k->user->name ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">NIK: {{ $k->nik ?: '-' }}</div>
                                        <div class="text-slate-500 text-xs">NIP: {{ $k->nip ?: '-' }}</div>
                                        <div class="text-slate-500 text-xs">JK: {{ $k->jenis_kelamin ?: '-' }}</div>
                                        <div class="text-slate-500 text-xs">Tgl Lahir: {{ $k->tanggal_lahir ? (method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : $k->tanggal_lahir) : '-' }}</div>
                                    </td>
                                    <td class="px-3 py-2 text-sm">
                                        <div class="text-slate-900">Email: {{ $k->user->email ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">HP: {{ $k->no_hp ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Provinsi: {{ $k->provinsi->name ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Kab/Kota: {{ $k->kabupaten->name ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Kec: {{ $k->kecamatan->name ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Kel: {{ $k->kelurahan->name ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Alamat: {{ $k->alamat_detail ?? '-' }}</div>
                                    </td>
                                    <td class="px-3 py-2 text-sm">
                                        <div class="text-slate-900">Ruangan: {{ $k->ruangan->nama_ruangan ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Profesi: {{ $k->profesi->nama_profesi ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Agama: {{ $k->agama ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Pendidikan: {{ $k->pendidikan_terakhir ?? '-' }}</div>
                                        <div class="text-slate-500 text-xs">Tgl Masuk: {{ $k->tanggal_masuk_kerja ? (method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : $k->tanggal_masuk_kerja) : '-' }}</div>
                                        <div class="text-slate-500 text-xs">Dokumen: {{ $k->dokumen_count ?? 0 }}</div>
                                        <div class="text-slate-500 text-xs">Status Pegawai: {{ $k->statusPegawai->nama ?? '-' }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ ($k->status_kelengkapan === 'lengkap') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $k->status_kelengkapan === 'lengkap' ? 'Lengkap' : 'Belum Lengkap' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('qr.show', $k->id) }}" class="px-3 py-1 rounded-md bg-slate-100 text-slate-700 hover:bg-slate-200">QR</a>
                                            <a href="{{ route('admin.laporan.print', array_merge(request()->query(), ['search' => $k->user->name ?? $k->nik])) }}" target="_blank" class="px-3 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700">Cetak</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada data</h3>
                                        <p class="mt-1 text-sm text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden divide-y divide-slate-100">
                    @forelse($karyawan as $k)
                        <details class="group">
                            <summary class="px-4 py-3 flex items-center justify-between gap-2 cursor-pointer hover:bg-slate-50">
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $k->user->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">{{ $k->ruangan->nama_ruangan ?? '-' }} • {{ $k->profesi->nama_profesi ?? '-' }}</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold rounded-full {{ ($k->status_kelengkapan === 'lengkap') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $k->status_kelengkapan === 'lengkap' ? 'Lengkap' : 'Belum Lengkap' }}
                                    </span>
                                    <svg class="w-4 h-4 text-slate-500 group-open:rotate-180 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.188l3.71-3.958a.75.75 0 011.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                                </div>
                            </summary>
                            <div class="px-4 pb-4 text-sm text-slate-700">
                                <div class="grid grid-cols-1 gap-2">
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-slate-900 font-medium mb-1">Identitas</div>
                                        <div>NIK: {{ $k->nik ?: '-' }}</div>
                                        <div>NIP: {{ $k->nip ?: '-' }}</div>
                                        <div>JK: {{ $k->jenis_kelamin ?: '-' }}</div>
                                        <div>Tgl Lahir: {{ $k->tanggal_lahir ? (method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : $k->tanggal_lahir) : '-' }}</div>
                                    </div>
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-slate-900 font-medium mb-1">Kontak & Alamat</div>
                                        <div>Email: {{ $k->user->email ?? '-' }}</div>
                                        <div>HP: {{ $k->no_hp ?? '-' }}</div>
                                        <div>Provinsi: {{ $k->provinsi->name ?? '-' }}</div>
                                        <div>Kab/Kota: {{ $k->kabupaten->name ?? '-' }}</div>
                                        <div>Kec: {{ $k->kecamatan->name ?? '-' }}</div>
                                        <div>Kel: {{ $k->kelurahan->name ?? '-' }}</div>
                                        <div>Alamat: {{ $k->alamat_detail ?? '-' }}</div>
                                    </div>
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-slate-900 font-medium mb-1">Unit & Profesi</div>
                                        <div>Ruangan: {{ $k->ruangan->nama_ruangan ?? '-' }}</div>
                                        <div>Profesi: {{ $k->profesi->nama_profesi ?? '-' }}</div>
                                        <div>Agama: {{ $k->agama ?? '-' }}</div>
                                        <div>Pendidikan: {{ $k->pendidikan_terakhir ?? '-' }}</div>
                                        <div>Tgl Masuk: {{ $k->tanggal_masuk_kerja ? (method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : $k->tanggal_masuk_kerja) : '-' }}</div>
                                        <div>Dokumen: {{ $k->dokumen_count ?? 0 }}</div>
                                        <div>Status Pegawai: {{ $k->statusPegawai->nama ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('qr.show', $k->id) }}" class="px-3 py-1 rounded-md bg-slate-100 text-slate-700">QR</a>
                                    <a href="{{ route('admin.laporan.print', array_merge(request()->query(), ['search' => $k->user->name ?? $k->nik])) }}" target="_blank" class="px-3 py-1 rounded-md bg-blue-600 text-white">Cetak</a>
                                </div>
                            </div>
                        </details>
                    @empty
                        <div class="px-6 py-12 text-center text-slate-500">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada data</h3>
                            <p class="mt-1 text-sm text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</p>
                        </div>
                    @endforelse
                </div>

                @if($karyawan->hasPages())
                    <div class="px-4 py-3 border-t border-slate-200">
                        {{ $karyawan->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded');
        return;
    }

    // Data untuk charts - simplified
    @php
        // Ruangan data
        $ruanganStats = $ruangan->map(function($r) use ($karyawan) {
            return [
                'nama' => $r->nama_ruangan,
                'jumlah' => $karyawan->where('ruangan_id', $r->id)->count()
            ];
        })->sortByDesc('jumlah')->take(8)->values();

        // Profesi data  
        $profesiStats = $profesi->map(function($p) use ($karyawan) {
            return [
                'nama' => $p->nama_profesi,
                'jumlah' => $karyawan->where('profesi_id', $p->id)->count()
            ];
        })->sortByDesc('jumlah')->take(8)->values();

    // Status data diri
        $lengkapCount = $karyawan->where('status_kelengkapan', 'lengkap')->count();
        $belumLengkapCount = $karyawan->where('status_kelengkapan', '!=', 'lengkap')->count();
        
        // Status dokumen - using same calculation as above
        $dokumenLengkapStatus = 0;
        $dokumenBelumLengkapStatus = 0;
        
        foreach($karyawan as $k) {
            $uploadedKategori = $k->dokumen->pluck('kategori_dokumen_id')->unique();
            $missingKategori = \App\Models\KategoriDokumen::where('wajib', true)->get()->filter(function($kat) use ($uploadedKategori) {
                return !$uploadedKategori->contains($kat->id);
            });
            if($missingKategori->count() == 0) {
                $dokumenLengkapStatus++;
            } else {
                $dokumenBelumLengkapStatus++;
            }
        }

        // Gender counts (robust mapping)
        $jkCounts = ['Laki-laki' => 0, 'Perempuan' => 0];
        foreach($karyawan as $k) {
            $jk = strtolower(trim($k->jenis_kelamin ?? ''));
            if (in_array($jk, ['l', 'laki-laki', 'laki laki', 'pria'])) {
                $jkCounts['Laki-laki']++;
            } elseif (in_array($jk, ['p', 'perempuan', 'wanita'])) {
                $jkCounts['Perempuan']++;
            }
        }
    @endphp

    const ruanganData = {!! json_encode($ruanganStats) !!} || [];
    const profesiData = {!! json_encode($profesiStats) !!} || [];
    const genderData = [
        { label: 'Laki-Laki', value: {{ $jkCounts['Laki-laki'] }}, color: '#60a5fa' },
        { label: 'Perempuan', value: {{ $jkCounts['Perempuan'] }}, color: '#f472b6' },
    ];
    
    const statusDataDiri = [
        { label: 'Lengkap', value: {{ $lengkapCount }}, color: '#10b981' },
        { label: 'Belum Lengkap', value: {{ $belumLengkapCount }}, color: '#f59e0b' }
    ];
    
    const statusDataDokumen = [
        { label: 'Lengkap', value: {{ $dokumenLengkapStatus }}, color: '#3b82f6' },
        { label: 'Belum Lengkap', value: {{ $dokumenBelumLengkapStatus }}, color: '#f97316' }
    ];

    // Trend data simplified
    const trendData = [
        { tahun: 2020, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2020; })->count() }} },
        { tahun: 2021, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2021; })->count() }} },
        { tahun: 2022, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2022; })->count() }} },
        { tahun: 2023, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2023; })->count() }} },
        { tahun: 2024, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2024; })->count() }} },
        { tahun: 2025, jumlah: {{ $karyawan->filter(function($k) { return $k->tanggal_masuk_kerja && date('Y', strtotime($k->tanggal_masuk_kerja)) == 2025; })->count() }} }
    ];

    // Colors untuk charts
    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#84cc16', '#f97316'];

    // Chart 1: Distribusi Karyawan per Ruangan (Doughnut Chart)
    const ruanganCanvas = document.getElementById('ruanganChart');
    if (ruanganCanvas) {
        const ruanganCtx = ruanganCanvas.getContext('2d');
        const ruanganLabels = ruanganData.map(item => item.nama);
        const ruanganValues = ruanganData.map(item => item.jumlah);
        const ruanganHasData = ruanganValues.some(v => v > 0);
        const ruanganChart = new Chart(ruanganCtx, {
            type: 'doughnut',
            data: {
                labels: ruanganLabels.length ? ruanganLabels : ['Tidak ada data'],
                datasets: [{
                    data: ruanganHasData ? ruanganValues : [1],
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Click to filter ruangan
        ruanganCanvas.onclick = (evt) => {
            const points = ruanganChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const label = ruanganLabels[idx];
            // Find ruangan id from label by matching in embedded data
            const match = (window.ruanganLookup || []).find(r => r.nama === label);
            if (match && match.id) {
                const url = new URL(window.location.href);
                url.searchParams.set('ruangan_id', match.id);
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            }
        };

        // Legend untuk ruangan chart
        const ruanganLegend = document.getElementById('ruanganLegend');
        if (ruanganLegend) {
            ruanganLegend.innerHTML = '';
            if (ruanganHasData) {
                ruanganData.forEach((item, index) => {
                    if (item.jumlah > 0) {
                        const legendItem = document.createElement('div');
                        legendItem.className = 'chart-legend-item';
                        legendItem.innerHTML = `
                            <div class="chart-legend-color" style="background-color: ${colors[index]}"></div>
                            <span>${item.nama} (${item.jumlah})</span>
                        `;
                        ruanganLegend.appendChild(legendItem);
                    }
                });
            } else {
                const legendItem = document.createElement('div');
                legendItem.className = 'chart-legend-item';
                legendItem.innerHTML = '<span>Tidak ada data</span>';
                ruanganLegend.appendChild(legendItem);
            }
        }
    }

    // Chart 2: Status Kelengkapan Data Diri (Doughnut Chart)
    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        const statusCtx = statusCanvas.getContext('2d');
        const diriValues = statusDataDiri.map(item => item.value);
        const diriHasData = diriValues.some(v => v > 0);
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusDataDiri.map(item => item.label),
                datasets: [{
                    data: diriHasData ? diriValues : [1, 1],
                    backgroundColor: statusDataDiri.map(item => item.color),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Legend untuk status data diri chart
        const statusLegend = document.getElementById('statusLegend');
        statusLegend.innerHTML = '';
        if (diriHasData) {
            statusDataDiri.forEach((item) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'chart-legend-item';
                legendItem.innerHTML = `
                    <div class="chart-legend-color" style="background-color: ${item.color}"></div>
                    <span>${item.label} (${item.value})</span>
                `;
                statusLegend.appendChild(legendItem);
            });
        } else {
            const legendItem = document.createElement('div');
            legendItem.className = 'chart-legend-item';
            legendItem.innerHTML = '<span>Tidak ada data</span>';
            statusLegend.appendChild(legendItem);
        }

        // Click to filter status_kelengkapan
        statusCanvas.onclick = (evt) => {
            const points = statusChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const label = statusDataDiri[idx].label || '';
            const map = { 'Lengkap': 'lengkap', 'Belum Lengkap': 'belum_lengkap' };
            const value = map[label];
            if (!value) return;
            const url = new URL(window.location.href);
            url.searchParams.set('status_kelengkapan', value);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        };
    }

    // Chart 3: Status Kelengkapan Dokumen (Doughnut Chart)
    const dokumenCanvas = document.getElementById('dokumenChart');
    if (dokumenCanvas) {
        const dokumenCtx = dokumenCanvas.getContext('2d');
        const dokValues = statusDataDokumen.map(item => item.value);
        const dokHasData = dokValues.some(v => v > 0);
        const dokumenChart = new Chart(dokumenCtx, {
            type: 'doughnut',
            data: {
                labels: statusDataDokumen.map(item => item.label),
                datasets: [{
                    data: dokHasData ? dokValues : [1, 1],
                    backgroundColor: statusDataDokumen.map(item => item.color),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Legend untuk status dokumen chart
        const dokumenLegend = document.getElementById('dokumenLegend');
        dokumenLegend.innerHTML = '';
        if (dokHasData) {
            statusDataDokumen.forEach((item) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'chart-legend-item';
                legendItem.innerHTML = `
                    <div class="chart-legend-color" style="background-color: ${item.color}"></div>
                    <span>${item.label} (${item.value})</span>
                `;
                dokumenLegend.appendChild(legendItem);
            });
        } else {
            const legendItem = document.createElement('div');
            legendItem.className = 'chart-legend-item';
            legendItem.innerHTML = '<span>Tidak ada data</span>';
            dokumenLegend.appendChild(legendItem);
        }

        // Click to filter dokumen wajib
        dokumenCanvas.onclick = (evt) => {
            const points = dokumenChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const label = statusDataDokumen[idx].label || '';
            const map = { 'Lengkap': 'dokumen_lengkap', 'Belum Lengkap': 'dokumen_belum_lengkap' };
            const value = map[label];
            if (!value) return;
            const url = new URL(window.location.href);
            url.searchParams.set('status_kelengkapan', value);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        };
    }

    // Chart 4: Distribusi Profesi (Horizontal Bar Chart)
    const profesiCanvas = document.getElementById('profesiChart');
    if (profesiCanvas) {
        const profesiCtx = profesiCanvas.getContext('2d');
    const profesiValues = profesiData.map(item => item.jumlah);
    const profesiLabels = profesiData.map(item => (item.nama || '').length > 18 ? (item.nama.substring(0, 17) + '…') : item.nama);
        const profesiChart = new Chart(profesiCtx, {
            type: 'bar',
            data: {
                labels: profesiLabels.length ? profesiLabels : ['Tidak ada data'],
                datasets: [{
                    label: 'Jumlah Karyawan',
                    data: profesiValues.length ? profesiValues : [0],
                    backgroundColor: '#3b82f6',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Click to filter profesi
        profesiCanvas.onclick = (evt) => {
            const points = profesiChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const label = (profesiData[idx] || {}).nama;
            const match = (window.profesiLookup || []).find(p => p.nama === label);
            if (match && match.id) {
                const url = new URL(window.location.href);
                url.searchParams.set('profesi_id', match.id);
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            }
        };
    }

    // Chart 5: Trend Karyawan Bergabung (Line Chart)
    const trendCanvas = document.getElementById('trendChart');
    if (trendCanvas) {
        const trendCtx = trendCanvas.getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.map(item => item.tahun),
                datasets: [{
                    label: 'Karyawan Bergabung',
                    data: trendData.map(item => item.jumlah),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: '#f1f5f9' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });

        // Click to filter by year (set date range of that year)
        trendCanvas.onclick = (evt) => {
            const points = trendChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const year = trendData[idx]?.tahun;
            if (!year) return;
            const url = new URL(window.location.href);
            url.searchParams.set('tanggal_masuk_from', `${year}-01-01`);
            url.searchParams.set('tanggal_masuk_to', `${year}-12-31`);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        };
    }

    // Chart 6: Distribusi Jenis Kelamin (Doughnut)
    const genderCanvas = document.getElementById('genderChart');
    if (genderCanvas) {
        const genderCtx = genderCanvas.getContext('2d');
        const genderValues = genderData.map(item => item.value);
        const genderHasData = genderValues.some(v => v > 0);
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderData.map(item => item.label),
                datasets: [{
                    data: genderHasData ? genderValues : [1, 1],
                    backgroundColor: genderData.map(item => item.color),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Legend
        const genderLegend = document.getElementById('genderLegend');
        genderLegend.innerHTML = '';
        if (genderHasData) {
            genderData.forEach((item) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'chart-legend-item';
                legendItem.innerHTML = `
                    <div class="chart-legend-color" style="background-color: ${item.color}"></div>
                    <span>${item.label} (${item.value})</span>
                `;
                genderLegend.appendChild(legendItem);
            });
        } else {
            const legendItem = document.createElement('div');
            legendItem.className = 'chart-legend-item';
            legendItem.innerHTML = '<span>Tidak ada data</span>';
            genderLegend.appendChild(legendItem);
        }

        // Click to filter jenis_kelamin
        genderCanvas.onclick = (evt) => {
            const points = genderChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (!points.length) return;
            const idx = points[0].index;
            const label = genderData[idx].label;
            const map = { 'Laki-Laki': 'Laki-laki', 'Perempuan': 'Perempuan' };
            const value = map[label] || label;
            const url = new URL(window.location.href);
            url.searchParams.set('jenis_kelamin', value);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        };
    }

    // Provide id lookups for ruangan/profesi to enable click->filter
    window.ruanganLookup = @json($ruangan->map(fn($r) => ['id' => $r->id, 'nama' => $r->nama_ruangan])->values());
    window.profesiLookup = @json($profesi->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_profesi])->values());

    console.log('Charts initialized successfully');
});
</script>
@endpush
