@extends('layouts.app')

@section('breadcrumb', 'Laporan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
        <!-- Header -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-800 mb-10 shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="max-w-full mx-auto px-6 lg:px-12 py-12 relative z-10">
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                    <div class="mb-4 xl:mb-0">
                        <h1 class="text-4xl font-bold text-white tracking-tight">
                            Laporan & Analitik
                        </h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Laporan komprehensif sistem karyawan RSUD Dolopo
                        </p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-white bg-white/20 rounded-lg px-4 py-2 backdrop-blur-sm hover:bg-white/30 transition-colors duration-300">
                            <span class="font-medium">← Kembali ke Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-full mx-auto px-6 lg:px-12 pb-12">
            <!-- Report Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                <!-- Laporan Karyawan -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-blue-900/5 border border-slate-200 hover:shadow-xl hover:shadow-blue-900/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Laporan Karyawan</h3>
                    <p class="text-slate-600 mb-6">Data lengkap karyawan, status, dan distribusi</p>
                    <div class="space-y-3">
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            📊 Laporan Data Karyawan
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            📈 Distribusi per Ruangan
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            👥 Distribusi per Profesi
                        </button>
                    </div>
                </div>

                <!-- Laporan Dokumen -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-emerald-900/5 border border-slate-200 hover:shadow-xl hover:shadow-emerald-900/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg shadow-emerald-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Laporan Dokumen</h3>
                    <p class="text-slate-600 mb-6">Status dokumen dan masa berlaku</p>
                    <div class="space-y-3">
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            📋 Status Dokumen
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            ⚠️ Dokumen Akan Expired
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            📊 Statistik Upload
                        </button>
                    </div>
                </div>

                <!-- Laporan Approval -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-amber-900/5 border border-slate-200 hover:shadow-xl hover:shadow-amber-900/10 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg shadow-amber-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Laporan Approval</h3>
                    <p class="text-slate-600 mb-6">Proses persetujuan dan tracking</p>
                    <div class="space-y-3">
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            ⏳ Pending Approval
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            ✅ History Approval
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors duration-300 text-slate-700 font-medium">
                            📈 Waktu Pemrosesan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div class="bg-white rounded-2xl shadow-lg shadow-blue-900/5 border border-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Export Laporan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <button class="flex items-center justify-center p-6 bg-gradient-to-r from-red-500 to-red-600 rounded-xl text-white font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export ke PDF
                    </button>
                    <button class="flex items-center justify-center p-6 bg-gradient-to-r from-green-500 to-green-600 rounded-xl text-white font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export ke Excel
                    </button>
                    <button class="flex items-center justify-center p-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export ke CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
