@extends('layouts.app')

@section('breadcrumb', 'Dashboard')

@push('styles')
<style>
    /* Custom styles untuk mobile responsiveness */
    .touch-target {
        min-height: 44px; /* iOS minimum touch target */
        display: flex;
        align-items: center;
    }
    
    @media (max-width: 640px) {
        .touch-target {
            min-height: 48px; /* Android minimum touch target */
        }
    }
    
    /* Chart responsiveness */
    .chart-container {
        position: relative;
        width: 100%;
        max-width: 100%;
    }
    
    /* Mobile scroll indicators */
    .mobile-scroll {
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    
    .mobile-scroll::-webkit-scrollbar {
        height: 4px;
    }
    
    .mobile-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }
    
    .mobile-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    
    .mobile-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Chart legend styles */
    .chart-legend {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1rem;
        gap: 1rem;
    }
    
    .chart-legend-item {
        display: flex;
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
<!-- Main Dashboard Content -->
        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
            <!-- Enhanced Statistics Cards dengan responsive design -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Total Karyawan -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer group">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-slate-600 truncate">Total Karyawan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $totalKaryawan ?? 0 }}</p>
                                <p class="text-xs text-green-600 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="hidden sm:inline">+12% dari bulan lalu</span>
                                    <span class="sm:hidden">+12%</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Karyawan Aktif -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-green-300 transition-all duration-300 cursor-pointer group">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-slate-600 truncate">Karyawan Aktif</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $karyawanAktif ?? 0 }}</p>
                                <p class="text-xs text-slate-500 mt-1 truncate">Sudah disetujui dan aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-amber-300 transition-all duration-300 cursor-pointer group">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 relative">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @if(($pendingApproval ?? 0) > 0)
                                        <span class="absolute -top-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                            {{ $pendingApproval > 9 ? '9+' : $pendingApproval }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-slate-600 truncate">Menunggu Persetujuan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $pendingApproval ?? 0 }}</p>
                                @if(($pendingApproval ?? 0) > 0)
                                    <a href="{{ route('admin.approval.index') }}" class="text-xs text-amber-600 hover:text-amber-800 mt-1 inline-flex items-center font-medium">
                                        <span class="truncate">Perlu ditinjau</span>
                                        <svg class="w-3 h-3 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @else
                                    <p class="text-xs text-slate-500 mt-1">Semua sudah ditinjau</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Dokumen -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-purple-300 transition-all duration-300 cursor-pointer group">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-slate-600 truncate">Total Dokumen</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ \App\Models\DokumenKaryawan::count() ?? 0 }}</p>
                                <p class="text-xs text-slate-500 mt-1">Dokumen tersimpan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Quick Actions dengan responsive design -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6 sm:mb-8">
                <div class="p-4 sm:p-6 border-b border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base sm:text-lg font-semibold text-slate-900">Quick Actions</h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-1">Akses cepat ke fitur yang sering digunakan</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-xs text-slate-500">Sistem Online</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <!-- Data Karyawan -->
                        <a href="{{ route('admin.karyawan.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 via-blue-50 to-indigo-100 hover:from-blue-100 hover:to-indigo-200 border border-blue-200 hover:border-blue-300 rounded-xl p-4 sm:p-5 transition-all duration-300 hover:shadow-lg touch-target">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 9a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-900 group-hover:text-blue-900 truncate">Data Karyawan</p>
                                    <p class="text-xs text-slate-600 truncate">Lihat semua karyawan</p>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-400/20 to-transparent rounded-full -mr-6 sm:-mr-8 -mt-6 sm:-mt-8"></div>
                        </a>

                        <!-- Approval dengan notifikasi -->
                        <a href="{{ route('admin.approval.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-amber-50 via-amber-50 to-orange-100 hover:from-amber-100 hover:to-orange-200 border border-amber-200 hover:border-amber-300 rounded-xl p-4 sm:p-5 transition-all duration-300 hover:shadow-lg touch-target">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-500 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:scale-110 transition-all duration-300 relative">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @if(($pendingApproval ?? 0) > 0)
                                            <span class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-5 h-5 sm:w-6 sm:h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-bounce">
                                                {{ $pendingApproval > 9 ? '9+' : $pendingApproval }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-900 group-hover:text-amber-900 truncate">Approval</p>
                                    <p class="text-xs text-slate-600 truncate">
                                        @if(($pendingApproval ?? 0) > 0)
                                            {{ $pendingApproval }} menunggu persetujuan
                                        @else
                                            Semua sudah disetujui
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-amber-400/20 to-transparent rounded-full -mr-6 sm:-mr-8 -mt-6 sm:-mt-8"></div>
                        </a>

                        <!-- Kelola Dokumen -->
                        <a href="{{ route('admin.dokumen.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-50 via-green-50 to-emerald-100 hover:from-green-100 hover:to-emerald-200 border border-green-200 hover:border-green-300 rounded-xl p-4 sm:p-5 transition-all duration-300 hover:shadow-lg touch-target">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center group-hover:bg-green-600 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-900 group-hover:text-green-900 truncate">Kelola Dokumen</p>
                                    <p class="text-xs text-slate-600 truncate">Manajemen dokumen</p>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-green-400/20 to-transparent rounded-full -mr-6 sm:-mr-8 -mt-6 sm:-mt-8"></div>
                        </a>

                        <!-- Laporan -->
                        <a href="{{ route('admin.laporan') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-50 via-purple-50 to-violet-100 hover:from-purple-100 hover:to-violet-200 border border-purple-200 hover:border-purple-300 rounded-xl p-4 sm:p-5 transition-all duration-300 hover:shadow-lg touch-target">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center group-hover:bg-purple-600 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-900 group-hover:text-purple-900 truncate">Laporan</p>
                                    <p class="text-xs text-slate-600 truncate">Analisis dan laporan</p>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-400/20 to-transparent rounded-full -mr-6 sm:-mr-8 -mt-6 sm:-mt-8"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Charts Section dengan responsive design -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Ruangan Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="p-4 sm:p-6 border-b border-slate-200">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900">Distribusi Karyawan per Ruangan</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Sebaran karyawan berdasarkan ruangan kerja</p>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="h-48 sm:h-64">
                            <canvas id="ruanganChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Profesi Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="p-4 sm:p-6 border-b border-slate-200">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900">Distribusi Karyawan per Profesi</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Sebaran karyawan berdasarkan profesi</p>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="h-48 sm:h-64">
                            <canvas id="profesiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & System Status dengan responsive design -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="p-4 sm:p-6 border-b border-slate-200">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900">Aktivitas Terbaru</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Log aktivitas sistem</p>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">Karyawan baru didaftarkan</p>
                                    <p class="text-xs text-slate-500">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">Dokumen disetujui</p>
                                    <p class="text-xs text-slate-500">3 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">Dokumen akan expired</p>
                                    <p class="text-xs text-slate-500">1 hari yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="p-4 sm:p-6 border-b border-slate-200">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900">Status Sistem</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Monitoring sistem real-time</p>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-slate-900">Database</span>
                                </div>
                                <span class="text-sm text-green-600 font-medium">Online</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-slate-900">Server</span>
                                </div>
                                <span class="text-sm text-green-600 font-medium">Normal</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-slate-900">Storage</span>
                                </div>
                                <span class="text-sm text-yellow-600 font-medium">75%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-slate-900">Backup</span>
                                </div>
                                <span class="text-sm text-green-600 font-medium">Latest</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js tidak tersedia');
            return;
        }
        
        // Konfigurasi global Chart.js untuk responsive
        Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
        Chart.defaults.font.size = window.innerWidth < 640 ? 10 : 12;
        Chart.defaults.color = '#6b7280';
        
        // Konfigurasi tooltip
        const tooltipConfig = {
            backgroundColor: 'rgba(255, 255, 255, 0.95)',
            titleColor: '#1f2937',
            bodyColor: '#4b5563',
            borderColor: '#e5e7eb',
            borderWidth: 1,
            padding: window.innerWidth < 640 ? 8 : 10,
            cornerRadius: 6,
            displayColors: true,
            usePointStyle: true,
            titleFont: {
                size: window.innerWidth < 640 ? 12 : 14
            },
            bodyFont: {
                size: window.innerWidth < 640 ? 11 : 13
            }
        };
        
        // Data dari backend
        const ruanganData = @json(($ruanganStats ?? collect())->pluck('jumlah')->toArray());
        const ruanganLabels = @json(($ruanganStats ?? collect())->pluck('nama')->toArray());
        const profesiData = @json(($profesiStats ?? collect())->pluck('jumlah')->toArray());
        const profesiLabels = @json(($profesiStats ?? collect())->pluck('nama')->toArray());
        
        // Data default jika kosong
        const finalRuanganData = ruanganData.length > 0 ? ruanganData : [12, 18, 8, 15, 10, 9];
        const finalRuanganLabels = ruanganLabels.length > 0 ? ruanganLabels : 
            window.innerWidth < 640 ? ['ICU', 'Radio', 'Poli', 'Anak', 'Bedah', 'Lab'] : 
            ['ICU', 'Radiologi', 'Poli Umum', 'Poli Anak', 'Bedah', 'Lab'];
        const finalProfesiData = profesiData.length > 0 ? profesiData : [25, 20, 15, 12, 8];
        const finalProfesiLabels = profesiLabels.length > 0 ? profesiLabels : ['Dokter', 'Perawat', 'Bidan', 'Farmasis', 'Admin'];
        
        // Warna chart
        const colors = [
            '#3b82f6', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b',
            '#ef4444', '#14b8a6', '#d946ef', '#84cc16', '#f97316'
        ];
        
        // Chart Ruangan
        const ruanganChart = document.getElementById('ruanganChart');
        if (ruanganChart) {
            try {
                new Chart(ruanganChart.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: finalRuanganLabels,
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: finalRuanganData,
                            backgroundColor: colors.slice(0, finalRuanganData.length).map(c => c + '80'),
                            borderColor: colors.slice(0, finalRuanganData.length),
                            borderWidth: 1,
                            borderRadius: window.innerWidth < 640 ? 2 : 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: tooltipConfig
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f3f4f6' },
                                ticks: { 
                                    stepSize: 5,
                                    font: {
                                        size: window.innerWidth < 640 ? 10 : 12
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: {
                                        size: window.innerWidth < 640 ? 10 : 12
                                    },
                                    maxRotation: window.innerWidth < 640 ? 45 : 0
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error chart ruangan:', error);
            }
        }
        
        // Chart Profesi
        const profesiChart = document.getElementById('profesiChart');
        if (profesiChart) {
            try {
                new Chart(profesiChart.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: finalProfesiLabels,
                        datasets: [{
                            data: finalProfesiData,
                            backgroundColor: colors.slice(0, finalProfesiData.length).map(c => c + '80'),
                            borderColor: colors.slice(0, finalProfesiData.length),
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: window.innerWidth < 640 ? '50%' : '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: window.innerWidth < 640 ? 10 : 15,
                                    font: { 
                                        size: window.innerWidth < 640 ? 10 : 11 
                                    }
                                }
                            },
                            tooltip: tooltipConfig
                        }
                    }
                });
            } catch (error) {
                console.error('Error chart profesi:', error);
            }
        }
        
        // Responsive resize handler
        window.addEventListener('resize', function() {
            // Chart.js akan otomatis handle resize
        });
    });
    </script>
@endsection
