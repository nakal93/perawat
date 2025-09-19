<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RSUD Dolopo') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-inter antialiased bg-slate-50">
        <div class="min-h-screen">
            <!-- Mobile menu button (hidden on lg+ screens) for Admin only -->
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superuser')
            <div class="lg:hidden">
                <div class="bg-white border-b border-slate-200 px-4 py-2 flex items-center justify-between">
                    <div class="flex items-center">
                        <button type="button" id="mobile-menu-button" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="ml-3 text-lg font-semibold text-slate-900">RSUD Dolopo</h1>
                    </div>
                    <!-- User info on mobile -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Sidebar for Admin -->
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superuser')
                <!-- Mobile sidebar overlay -->
                <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden">
                    <div class="sr-only">Sidebar</div>
                </div>
                
                <!-- Sidebar -->
                <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white shadow-2xl border-r border-slate-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:w-64">
                    <!-- Enhanced Header dengan logo dan nama RSUD -->
                    <div class="flex items-center h-16 px-6 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
                        <!-- Decorative background elements -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-indigo-600/20"></div>
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                        
                        <div class="relative flex items-center justify-between w-full">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm ring-1 ring-white/20">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-white font-bold text-lg tracking-tight">RSUD Dolopo</h1>
                                    <p class="text-blue-100 text-xs font-medium">Sistem Pendataan Karyawan</p>
                                </div>
                            </div>
                            
                            <!-- Close button for mobile -->
                            <button type="button" id="mobile-close-button" class="lg:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Enhanced Navigation Menu -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto">
                        <!-- User Profile Section -->
                        <div class="mb-6 px-3 py-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-blue-100 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    @php($foto = optional(auth()->user()->karyawan)->foto_profil)
                                    @if($foto)
                                        <img src="{{ '/storage/'.ltrim($foto,'/') }}" alt="avatar" class="w-10 h-10 object-cover">
                                    @else
                                        <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                                </div>
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <!-- Dashboard -->
                            <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 border-r-4 border-blue-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.dashboard'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.dashboard')) bg-blue-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Dashboard</span>
                                    @if(request()->routeIs('admin.dashboard'))
                                        <div class="ml-auto">
                                            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            
                            <!-- Approval dengan enhanced notification -->
                            <a href="{{ route('admin.approval.index') }}" class="@if(request()->routeIs('admin.approval.*')) bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 border-r-4 border-amber-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.approval.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.approval.*')) bg-amber-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors relative">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @if(isset($pendingApproval) && $pendingApproval > 0)
                                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-bounce text-[10px]">
                                                {{ $pendingApproval > 9 ? '9+' : $pendingApproval }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="font-medium">Approval</span>
                                    @if(isset($pendingApproval) && $pendingApproval > 0)
                                        <span class="ml-auto inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 ring-1 ring-red-200">
                                            {{ $pendingApproval }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            
                            <!-- Karyawan -->
                            <a href="{{ route('admin.karyawan.index') }}" class="@if(request()->routeIs('admin.karyawan.*')) bg-gradient-to-r from-green-50 to-green-100 text-green-700 border-r-4 border-green-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.karyawan.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-green-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.karyawan.*')) bg-green-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 9a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Data Karyawan</span>
                                </div>
                            </a>
                            
                            <!-- Dokumen -->
                            <a href="{{ route('admin.dokumen.index') }}" class="@if(request()->routeIs('admin.dokumen.*')) bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-r-4 border-purple-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.dokumen.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.dokumen.*')) bg-purple-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Dokumen</span>
                                </div>
                            </a>
                            
                            <!-- Laporan -->
                            <a href="{{ route('admin.laporan') }}" class="@if(request()->routeIs('admin.laporan')) bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 border-r-4 border-indigo-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.laporan'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.laporan')) bg-indigo-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Laporan</span>
                                </div>
                            </a>
                            
                            <!-- Enhanced Master Data Section -->
                            <div class="pt-6 mt-6">
                                <div class="px-3 mb-4">
                                    <div class="flex items-center">
                                        <div class="w-6 h-px bg-gradient-to-r from-slate-300 to-transparent flex-1"></div>
                                        <h3 class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Master Data</h3>
                                        <div class="w-6 h-px bg-gradient-to-l from-slate-300 to-transparent flex-1"></div>
                                    </div>
                                </div>
                                
                                <!-- Ruangan -->
                                <a href="{{ route('admin.ruangan.index') }}" class="@if(request()->routeIs('admin.ruangan.*')) bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 border-r-4 border-teal-600 shadow-sm @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                    @if(request()->routeIs('admin.ruangan.*'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-teal-50/50 to-transparent"></div>
                                    @endif
                                    <div class="relative flex items-center w-full">
                                        <div class="@if(request()->routeIs('admin.ruangan.*')) bg-teal-600 text-white @else bg-slate-100 text-slate-500 group-hover:bg-slate-200 @endif w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-sm">Ruangan</span>
                                    </div>
                                </a>
                                
                                <!-- Profesi -->
                                <a href="{{ route('admin.profesi.index') }}" class="@if(request()->routeIs('admin.profesi.*')) bg-gradient-to-r from-cyan-50 to-cyan-100 text-cyan-700 border-r-4 border-cyan-600 shadow-sm @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                    @if(request()->routeIs('admin.profesi.*'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-50/50 to-transparent"></div>
                                    @endif
                                    <div class="relative flex items-center w-full">
                                        <div class="@if(request()->routeIs('admin.profesi.*')) bg-cyan-600 text-white @else bg-slate-100 text-slate-500 group-hover:bg-slate-200 @endif w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H10a2 2 0 00-2-2V6m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h2"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-sm">Profesi</span>
                                    </div>
                                </a>
                                
                                <!-- Kategori Dokumen -->
                                <a href="{{ route('admin.kategori-dokumen.index') }}" class="@if(request()->routeIs('admin.kategori-dokumen.*')) bg-gradient-to-r from-rose-50 to-rose-100 text-rose-700 border-r-4 border-rose-600 shadow-sm @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                    @if(request()->routeIs('admin.kategori-dokumen.*'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-rose-50/50 to-transparent"></div>
                                    @endif
                                    <div class="relative flex items-center w-full">
                                        <div class="@if(request()->routeIs('admin.kategori-dokumen.*')) bg-rose-600 text-white @else bg-slate-100 text-slate-500 group-hover:bg-slate-200 @endif w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-sm">Kategori Dokumen</span>
                                    </div>
                                </a>

                                <!-- Status Pegawai -->
                                <a href="{{ route('admin.status-pegawai.manage') }}" class="@if(request()->routeIs('admin.status-pegawai.*')) bg-gradient-to-r from-orange-50 to-orange-100 text-orange-700 border-r-4 border-orange-600 shadow-sm @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                    @if(request()->routeIs('admin.status-pegawai.*'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-orange-50/50 to-transparent"></div>
                                    @endif
                                    <div class="relative flex items-center w-full">
                                        <div class="@if(request()->routeIs('admin.status-pegawai.*')) bg-orange-600 text-white @else bg-slate-100 text-slate-500 group-hover:bg-slate-200 @endif w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-sm">Status Pegawai</span>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Enhanced Settings & System Section -->
                            <div class="pt-6 mt-6">
                                <div class="px-3 mb-4">
                                    <div class="flex items-center">
                                        <div class="w-6 h-px bg-gradient-to-r from-slate-300 to-transparent flex-1"></div>
                                        <h3 class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">System</h3>
                                        <div class="w-6 h-px bg-gradient-to-l from-slate-300 to-transparent flex-1"></div>
                                    </div>
                                </div>
                                
                                <!-- Settings -->
                                <a href="{{ route('admin.settings') }}" class="@if(request()->routeIs('admin.settings')) bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border-r-4 border-slate-600 shadow-sm @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                    @if(request()->routeIs('admin.settings'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-slate-100/50 to-transparent"></div>
                                    @endif
                                    <div class="relative flex items-center w-full">
                                        <div class="@if(request()->routeIs('admin.settings')) bg-slate-600 text-white @else bg-slate-100 text-slate-500 group-hover:bg-slate-200 @endif w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-sm">Settings</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Enhanced Footer with System Info -->
                        <x-footer />
                    </nav>
                </div>
                
                <!-- Enhanced Main content with responsive sidebar offset -->
                <div class="lg:pl-64">
                    @hasSection('breadcrumb')
                    <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                            <div class="flex flex-1 items-center">
                                <nav class="flex" aria-label="Breadcrumb">
                                    <ol class="flex items-center space-x-2">
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="ml-2 text-sm font-medium text-gray-900">@yield('breadcrumb')</span>
                                            </div>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="flex items-center gap-x-4 lg:gap-x-6">
                                @auth
                                    <!-- Profile dropdown with enhanced design -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button" class="flex items-center p-1.5 text-sm hover:bg-slate-50 rounded-lg transition-colors" @click="open = !open">
                                            <span class="sr-only">Open user menu</span>
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center ring-2 ring-blue-100">
                                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                            </div>
                                            <span class="hidden lg:flex lg:items-center">
                                                <span class="ml-3 text-sm font-semibold leading-6 text-slate-900">{{ auth()->user()->name }}</span>
                                                <svg class="ml-2 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>

                                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-2 shadow-xl ring-1 ring-slate-900/5 focus:outline-none">
                                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                                        </div>
                                        <button type="button" class="p-1 text-slate-400 hover:text-slate-600" @click="open=false">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                            <a href="{{ route('karyawan.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Profil Saya
                                                </div>
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                        </svg>
                                                        Keluar
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Main content area -->
                    <main class="@hasSection('breadcrumb') pt-0 @else pt-6 @endif w-full px-6 pb-6">
                        @yield('content')
                    </main>
                </div>
            @else
                <!-- Modern layout for non-admin users (karyawan) with responsive sidebar -->
                <!-- Mobile sidebar overlay -->
                <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden"></div>

                <!-- Sidebar -->
                <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white shadow-2xl border-r border-slate-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:w-64">
                    <!-- Header -->
                    <div class="flex items-center h-16 px-6 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-indigo-600/20"></div>
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>

                        <div class="relative flex items-center justify-between w-full">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm ring-1 ring-white/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-white font-bold text-lg tracking-tight">RSUD Dolopo</h1>
                                    <p class="text-blue-100 text-xs font-medium">Area Karyawan</p>
                                </div>
                            </div>
                            <button type="button" id="mobile-close-button" class="lg:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto">
                        <!-- User Profile -->
                        <div class="mb-6 px-3 py-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center ring-2 ring-blue-100">
                                    <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">Karyawan</p>
                                </div>
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <!-- Beranda -->
                            <a href="{{ route('karyawan.dashboard') }}" class="@if(request()->routeIs('karyawan.dashboard')) bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 border-r-4 border-teal-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('karyawan.dashboard'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-teal-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('karyawan.dashboard')) bg-teal-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0v8m0-8H7m6 0h6" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Beranda</span>
                                </div>
                            </a>

                            <!-- Profil -->
                            <a href="{{ route('karyawan.profile') }}" class="@if(request()->routeIs('karyawan.profile')) bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 border-r-4 border-blue-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('karyawan.profile'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('karyawan.profile')) bg-blue-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Profil</span>
                                </div>
                            </a>

                            <!-- Dokumen Saya -->
                            <a href="{{ route('dokumen.index') }}" class="@if(request()->routeIs('dokumen.*')) bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-r-4 border-purple-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('dokumen.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('dokumen.*')) bg-purple-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Dokumen</span>
                                </div>
                            </a>

                            <!-- Pengaturan -->
                            <a href="{{ route('karyawan.settings') }}" class="@if(request()->routeIs('karyawan.settings')) bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border-r-4 border-slate-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('karyawan.settings'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-slate-100/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('karyawan.settings')) bg-slate-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Pengaturan</span>
                                </div>
                            </a>
                        </div>

                        <!-- Footer -->
                        <x-footer />
                    </nav>
                </div>

                <!-- Main content with responsive sidebar offset -->
                <div class="lg:pl-64">
                    <!-- Top bar for karyawan -->
                    <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                        <div class="flex items-center">
                            <button type="button" id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <span class="ml-2 text-base font-semibold text-slate-900">Area Karyawan</span>
                        </div>
                        <div class="ml-auto flex items-center gap-x-4 lg:gap-x-6">
                            <!-- Profile dropdown (fixed structure) -->
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" class="flex items-center p-1.5 text-sm hover:bg-slate-50 rounded-lg transition-colors" @click="open = !open">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center ring-2 ring-blue-100">
                                        @php($fotoTop = optional(auth()->user()->karyawan)->foto_profil)
                                        @if($fotoTop)
                                            <img src="{{ '/storage/'.ltrim($fotoTop,'/') }}" class="w-8 h-8 object-cover" alt="avatar">
                                        @else
                                            <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <span class="hidden lg:flex lg:items-center">
                                        <span class="ml-3 text-sm font-semibold leading-6 text-slate-900">{{ auth()->user()->name }}</span>
                                        <svg class="ml-2 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2.5 w-56 origin-top-right rounded-xl bg-white py-2 shadow-xl ring-1 ring-slate-900/5 focus:outline-none">
                                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-slate-500">Karyawan</p>
                                        </div>
                                        <button type="button" class="p-1 text-slate-400 hover:text-slate-600" @click="open=false">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <a href="{{ route('karyawan.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Profil Saya
                                        </div>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Keluar
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main content area -->
                    <main class="pt-6 w-full px-6 pb-6">
                        @yield('content')
                    </main>
                </div>
            @endif
        </div>

        <!-- Enhanced Mobile Menu JavaScript -->
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileCloseButton = document.getElementById('mobile-close-button');
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
                
                function openMobileSidebar() {
                    if (mobileSidebar && mobileSidebarOverlay) {
                        mobileSidebar.classList.remove('-translate-x-full');
                        mobileSidebar.classList.add('translate-x-0');
                        mobileSidebarOverlay.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
                    }
                }
                
                function closeMobileSidebar() {
                    if (mobileSidebar && mobileSidebarOverlay) {
                        mobileSidebar.classList.add('-translate-x-full');
                        mobileSidebar.classList.remove('translate-x-0');
                        mobileSidebarOverlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                }
                
                // Event listeners
                if (mobileMenuButton) {
                    mobileMenuButton.addEventListener('click', openMobileSidebar);
                }
                
                if (mobileCloseButton) {
                    mobileCloseButton.addEventListener('click', closeMobileSidebar);
                }
                
                if (mobileSidebarOverlay) {
                    mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);
                }
                
                // Close sidebar when clicking a menu item on mobile
                const mobileMenuItems = mobileSidebar?.querySelectorAll('a[href]');
                mobileMenuItems?.forEach(item => {
                    item.addEventListener('click', closeMobileSidebar);
                });
                
                // Handle escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeMobileSidebar();
                    }
                });
                
                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 1024) { // lg breakpoint
                        closeMobileSidebar();
                    }
                });
            });
        </script>

        @stack('scripts')
        
        <!-- Global Image Lightbox Modal -->
        <div id="globalImageModal" class="fixed inset-0 bg-black/80 z-[10000] hidden items-center justify-center p-2 sm:p-4" role="dialog" aria-modal="true" aria-labelledby="globalModalCaption">
            <div class="relative w-full h-full sm:w-auto sm:h-auto max-w-[95vw] max-h-[90vh] sm:max-w-5xl sm:max-h-full flex items-center justify-center" onclick="event.stopPropagation();">
                <button onclick="window.__closeImageModal()" class="absolute top-3 right-3 sm:-top-4 sm:-right-4 text-white hover:text-gray-300 bg-red-600 hover:bg-red-700 rounded-full w-10 h-10 flex items-center justify-center text-xl font-bold z-10 transition-colors">
                    ×
                </button>
                <img id="globalModalImage" src="" alt="" class="w-auto h-auto max-w-[95vw] max-h-[80vh] sm:max-w-full sm:max-h-[85vh] object-contain rounded-lg shadow-2xl bg-white touch-pan-y">
                <div id="globalModalCaption" class="absolute left-0 right-0 bottom-2 sm:-bottom-12 text-white bg-black/70 p-2 sm:p-3 rounded text-center text-xs sm:text-sm"></div>
            </div>
        </div>
        <script>
            (function(){
                const modal = document.getElementById('globalImageModal');
                const img = document.getElementById('globalModalImage');
                const cap = document.getElementById('globalModalCaption');
                window.__openImageModal = function(src, caption){
                    if(!modal||!img||!cap) return;
                    img.src = src;
                    img.alt = caption || 'Image preview';
                    cap.textContent = caption || '';
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                };
                window.__closeImageModal = function(){
                    if(!modal) return;
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';
                };
                modal?.addEventListener('click', function(e){ if(e.target===modal){ window.__closeImageModal(); }});
                document.addEventListener('keydown', function(e){ if(e.key==='Escape'||e.keyCode===27){ window.__closeImageModal(); }});
                // Backward compatibility: map old function names if used by pages
                window.openImageModal = window.__openImageModal;
                window.closeImageModal = window.__closeImageModal;

                // Mobile swipe-down to close
                let touchStartY = null;
                modal.addEventListener('touchstart', (e)=>{
                    if (e.touches && e.touches.length === 1) {
                        touchStartY = e.touches[0].clientY;
                    }
                }, { passive: true });
                modal.addEventListener('touchmove', (e)=>{
                    // Prevent background scroll while modal open
                    if (!modal.classList.contains('hidden')) e.preventDefault();
                }, { passive: false });
                modal.addEventListener('touchend', (e)=>{
                    if (touchStartY !== null) {
                        const endY = (e.changedTouches && e.changedTouches[0]?.clientY) || touchStartY;
                        if (endY - touchStartY > 80) { // swipe down
                            window.__closeImageModal();
                        }
                        touchStartY = null;
                    }
                });
            })();
        </script>

        <!-- Global PDF Viewer (pdf.js) - Professional Style -->
    <div id="globalPdfModal" class="fixed inset-0 bg-gray-900 z-[11000] hidden" role="dialog" aria-modal="true" aria-label="Pratinjau Dokumen PDF">
            <div class="absolute inset-0 flex flex-col">
                <!-- Enhanced Toolbar -->
                <div class="bg-gray-800 text-white px-4 py-2 flex items-center justify-between border-b border-gray-700">
                    <div class="flex items-center gap-3">
                        <button id="pdfCloseBtn" class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button id="pdfToggleSidebar" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <span id="pdfFileName" class="text-sm text-gray-300 truncate max-w-xs"></span>
                    </div>
                    
                    <!-- Central Navigation & Zoom Controls -->
                    <div class="flex items-center gap-2">
                        <button id="pdfPrevBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Previous Page">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div class="bg-gray-700 px-3 py-1 rounded text-sm">
                            <span id="pdfPageNum">1</span> / <span id="pdfPageCount">1</span>
                        </div>
                        <button id="pdfNextBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Next Page">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        
                        <div class="w-px h-6 bg-gray-600 mx-2"></div>
                        
                        <button id="pdfZoomOutBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Zoom Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
                            </svg>
                        </button>
                        <div class="bg-gray-700 px-2 py-1 rounded text-sm min-w-[60px] text-center">
                            <span id="pdfZoomLabel">100%</span>
                        </div>
                        <button id="pdfZoomInBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Zoom In">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center gap-2">
                        <button id="pdfRotateLeftBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Rotate Left">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7.11 8.53L5.7 7.11C4.8 8.27 4.24 9.61 4.07 11h2.02c.14-.87.49-1.72 1.02-2.47zM6.09 13H4.07c.17 1.39.72 2.73 1.62 3.89l1.41-1.42c-.52-.75-.87-1.59-1.01-2.47zm1.01 5.32c1.16.9 2.51 1.44 3.9 1.61V17.9c-.87-.15-1.71-.49-2.46-1.03L7.1 18.32zM13 4.07V1L8.45 5.55 13 10V6.09c2.84.48 5 2.94 5 5.91s-2.16 5.43-5 5.91v2.02c3.95-.49 7-3.85 7-7.93s-3.05-7.44-7-7.93z"/>
                            </svg>
                        </button>
                        <button id="pdfRotateRightBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Rotate Right">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.55 5.55L11 1v3.07C7.06 4.56 4 7.92 4 12s3.05 7.44 7 7.93v-2.02c-2.84-.48-5-2.94-5-5.91s2.16-5.43 5-5.91V10l4.55-4.45zM19.93 11c-.17-1.39-.72-2.73-1.62-3.89l-1.42 1.42c.54.75.88 1.6 1.02 2.47h2.02zM13 17.9v2.02c1.39-.17 2.74-.71 3.9-1.61l-1.44-1.44c-.75.54-1.59.89-2.46 1.03zm3.89-2.42l1.42 1.41c.9-1.16 1.45-2.5 1.62-3.89h-2.02c-.14.87-.48 1.72-1.02 2.48z"/>
                            </svg>
                        </button>
                        
                        <div class="w-px h-6 bg-gray-600 mx-1"></div>
                        
                        <button id="pdfFitWidthBtn" class="px-3 py-1 rounded hover:bg-gray-700 text-sm" title="Fit Width">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V3a1 1 0 011 1v10a1 1 0 01-1 1H8a1 1 0 01-1-1V4z"/>
                            </svg>
                            Width
                        </button>
                        <button id="pdfFitPageBtn" class="px-3 py-1 rounded hover:bg-gray-700 text-sm" title="Fit Page">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Page
                        </button>
                        
                        <div class="w-px h-6 bg-gray-600 mx-1"></div>
                        
                        <button id="pdfFullscreenBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Fullscreen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </button>
                        <a id="pdfDownloadBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Download" target="_blank">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </a>
                        <button id="pdfPrintBtn" class="w-8 h-8 rounded hover:bg-gray-700 flex items-center justify-center" title="Print">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-1 overflow-hidden">
                    <!-- Enhanced Sidebar with Thumbnails -->
                    <aside id="pdfSidebar" class="w-64 bg-gray-100 border-r border-gray-300 flex flex-col hidden md:flex">
                        <div class="bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border-b border-gray-300">
                            Document Outline
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <div id="pdfThumbnails" class="p-3 space-y-3"></div>
                        </div>
                    </aside>

                    <!-- Main PDF Canvas Area -->
                    <main class="flex-1 bg-gray-400 overflow-auto">
                        <div class="min-h-full flex items-center justify-center p-4">
                            <canvas id="pdfCanvas" class="bg-white shadow-2xl rounded-sm max-w-full"></canvas>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
        <script>
            (function(){
                const modal = document.getElementById('globalPdfModal');
                const canvas = document.getElementById('pdfCanvas');
                const ctx = canvas.getContext('2d');
                const sidebar = document.getElementById('pdfSidebar');
                const thumbnailsContainer = document.getElementById('pdfThumbnails');
                const pageNumEl = document.getElementById('pdfPageNum');
                const pageCountEl = document.getElementById('pdfPageCount');
                const zoomLabel = document.getElementById('pdfZoomLabel');
                const fileNameEl = document.getElementById('pdfFileName');
                const downloadBtn = document.getElementById('pdfDownloadBtn');

                // Control buttons
                const closeBtn = document.getElementById('pdfCloseBtn');
                const sidebarBtn = document.getElementById('pdfToggleSidebar');
                const prevBtn = document.getElementById('pdfPrevBtn');
                const nextBtn = document.getElementById('pdfNextBtn');
                const zoomInBtn = document.getElementById('pdfZoomInBtn');
                const zoomOutBtn = document.getElementById('pdfZoomOutBtn');
                const rotateLeftBtn = document.getElementById('pdfRotateLeftBtn');
                const rotateRightBtn = document.getElementById('pdfRotateRightBtn');
                const fitWidthBtn = document.getElementById('pdfFitWidthBtn');
                const fitPageBtn = document.getElementById('pdfFitPageBtn');
                const fullscreenBtn = document.getElementById('pdfFullscreenBtn');
                const printBtn = document.getElementById('pdfPrintBtn');

                let pdfDoc = null, pageNum = 1, pageRendering = false, pageNumPending = null, scale = 1.2, rotation = 0;
                let fitMode = 'width'; // 'none', 'width', 'page'
                let currentFileUrl = '';

                // Configure PDF.js worker
                if (window['pdfjsLib']) {
                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/build/pdf.worker.min.js';
                }

                function updateZoomLabel() {
                    zoomLabel.textContent = Math.round(scale * 100) + '%';
                }

        function getViewport(page) {
                    let viewport = page.getViewport({scale: 1, rotation: rotation});
                    
                    if (fitMode === 'width') {
            const containerWidth = canvas.parentElement.clientWidth - 32;
                        scale = Math.max(0.3, containerWidth / viewport.width);
                    } else if (fitMode === 'page') {
            const containerWidth = canvas.parentElement.clientWidth - 32;
            const containerHeight = canvas.parentElement.clientHeight - 32;
                        const scaleX = containerWidth / viewport.width;
                        const scaleY = containerHeight / viewport.height;
                        scale = Math.max(0.3, Math.min(scaleX, scaleY));
                    }
                    
                    return page.getViewport({scale: scale, rotation: rotation});
                }

        function renderPage(num) {
                    pageRendering = true;
                    pdfDoc.getPage(num).then(function(page) {
                        const viewport = getViewport(page);
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        
            // Ensure white background to avoid black/transparent pages on some PDFs
            ctx.save();
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.restore();

            const renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };
                        
                        const renderTask = page.render(renderContext);
                        renderTask.promise.then(function() {
                            pageRendering = false;
                            updateZoomLabel();
                            if (pageNumPending !== null) {
                                renderPage(pageNumPending);
                                pageNumPending = null;
                            }
                            
                            // Update page number display
                            pageNumEl.textContent = num;
                            
                            // Update thumbnail highlight
                            document.querySelectorAll('.pdf-thumbnail').forEach(t => {
                                t.classList.remove('ring-2', 'ring-blue-500');
                                t.classList.add('border-gray-300');
                            });
                            const currentThumb = document.querySelector(`[data-page="${num}"]`);
                            if (currentThumb) {
                                currentThumb.classList.add('ring-2', 'ring-blue-500');
                                currentThumb.classList.remove('border-gray-300');
                                currentThumb.scrollIntoView({behavior: 'smooth', block: 'center'});
                            }
                        });
                    });
                }

                function queueRenderPage(num) {
                    if (pageRendering) {
                        pageNumPending = num;
                    } else {
                        renderPage(num);
                    }
                }

                function showPage(num) {
                    if (num < 1 || num > pdfDoc.numPages) return;
                    pageNum = num;
                    queueRenderPage(pageNum);
                }

                function buildThumbnails() {
                    thumbnailsContainer.innerHTML = '';
                    for (let i = 1; i <= pdfDoc.numPages; i++) {
                        const thumbContainer = document.createElement('button');
                        thumbContainer.type = 'button';
                        thumbContainer.className = 'pdf-thumbnail w-full text-left cursor-pointer p-2 border border-gray-300 rounded hover:bg-gray-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all';
                        thumbContainer.setAttribute('data-page', i);
                        
                        const thumbCanvas = document.createElement('canvas');
                        thumbCanvas.className = 'w-full h-auto rounded';
                        
                        const thumbCtx = thumbCanvas.getContext('2d');
                        const pageLabel = document.createElement('div');
                        pageLabel.className = 'text-xs text-center mt-2 text-gray-600 font-medium';
                        pageLabel.textContent = `${i}`;
                        
                        thumbContainer.appendChild(thumbCanvas);
                        thumbContainer.appendChild(pageLabel);
                        thumbnailsContainer.appendChild(thumbContainer);
                        
                        // Render thumbnail
                        pdfDoc.getPage(i).then(function(page) {
                            const viewport = page.getViewport({scale: 0.25, rotation: rotation});
                            thumbCanvas.height = viewport.height;
                            thumbCanvas.width = viewport.width;

                            // Fill white background before rendering thumbnail
                            thumbCtx.save();
                            thumbCtx.fillStyle = '#ffffff';
                            thumbCtx.fillRect(0, 0, thumbCanvas.width, thumbCanvas.height);
                            thumbCtx.restore();
                            
                            page.render({
                                canvasContext: thumbCtx,
                                viewport: viewport
                            });
                        });
                        
                        // Click handler
                        thumbContainer.addEventListener('click', () => showPage(i));
                    }
                }

                function openModal() {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeModal() {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    // Reset state
                    pdfDoc = null;
                    currentFileUrl = '';
                    thumbnailsContainer.innerHTML = '';
                    pageNum = 1;
                    scale = 1.2;
                    rotation = 0;
                    fitMode = 'width';
                }

                // Event listeners
                closeBtn.addEventListener('click', closeModal);
                modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
                // Mobile swipe-down to close
                let pdfTouchStartY = null;
                modal.addEventListener('touchstart', (e)=>{
                    if (e.touches && e.touches.length === 1) pdfTouchStartY = e.touches[0].clientY;
                }, { passive: true });
                modal.addEventListener('touchmove', (e)=>{
                    if (!modal.classList.contains('hidden')) e.preventDefault();
                }, { passive: false });
                modal.addEventListener('touchend', (e)=>{
                    if (pdfTouchStartY !== null) {
                        const endY = (e.changedTouches && e.changedTouches[0]?.clientY) || pdfTouchStartY;
                        if (endY - pdfTouchStartY > 80) closeModal();
                        pdfTouchStartY = null;
                    }
                });
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

                sidebarBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('hidden');
                });

                prevBtn.addEventListener('click', () => showPage(pageNum - 1));
                nextBtn.addEventListener('click', () => showPage(pageNum + 1));
                
                zoomInBtn.addEventListener('click', () => {
                    fitMode = 'none';
                    scale = Math.min(scale + 0.2, 4);
                    queueRenderPage(pageNum);
                });
                
                zoomOutBtn.addEventListener('click', () => {
                    fitMode = 'none';
                    scale = Math.max(scale - 0.2, 0.3);
                    queueRenderPage(pageNum);
                });
                
                rotateLeftBtn.addEventListener('click', () => {
                    rotation = (rotation + 270) % 360;
                    queueRenderPage(pageNum);
                    buildThumbnails(); // Rebuild thumbnails with new rotation
                });
                
                rotateRightBtn.addEventListener('click', () => {
                    rotation = (rotation + 90) % 360;
                    queueRenderPage(pageNum);
                    buildThumbnails(); // Rebuild thumbnails with new rotation
                });
                
                fitWidthBtn.addEventListener('click', () => {
                    fitMode = 'width';
                    queueRenderPage(pageNum);
                });
                
                fitPageBtn.addEventListener('click', () => {
                    fitMode = 'page';
                    queueRenderPage(pageNum);
                });
                
                fullscreenBtn.addEventListener('click', () => {
                    if (modal.requestFullscreen) {
                        modal.requestFullscreen();
                    }
                });
                
                printBtn.addEventListener('click', () => {
                    if (!currentFileUrl) return;
                    const printWindow = window.open(currentFileUrl, '_blank');
                    if (printWindow) {
                        printWindow.addEventListener('load', () => {
                            printWindow.print();
                        });
                    }
                });

                // Global function to open PDF
                window.openPdfViewer = function(fileUrl, title) {
                    if (!window['pdfjsLib']) {
                        alert('PDF viewer tidak tersedia. Silakan reload halaman.');
                        return;
                    }
                    
                    openModal();
                    pageNum = 1;
                    scale = 1.2;
                    rotation = 0;
                    fitMode = 'width';
                    pageRendering = false;
                    pageNumPending = null;
                    currentFileUrl = fileUrl;
                    
                    fileNameEl.textContent = title || 'Document.pdf';
                    downloadBtn.href = fileUrl;
                    downloadBtn.setAttribute('download', title || 'document.pdf');
                    
                    // Show sidebar by default
                    sidebar.classList.remove('hidden');
                    
                    pdfjsLib.getDocument(fileUrl).promise.then(function(doc) {
                        pdfDoc = doc;
                        pageCountEl.textContent = doc.numPages;
                        renderPage(pageNum);
                        buildThumbnails();
                    }).catch(function(err) {
                        console.error('PDF load error:', err);
                        alert('Gagal memuat PDF. Pastikan file dapat diakses.');
                    });
                };

                // Responsive: re-fit on resize when fit mode active
                window.addEventListener('resize', () => { 
                    if (pdfDoc && fitMode !== 'none') {
                        queueRenderPage(pageNum);
                    }
                });

                // Enhanced keyboard shortcuts
                document.addEventListener('keydown', (e) => {
                    if (modal.classList.contains('hidden')) return;
                    
                    switch(e.key) {
                        case 'ArrowRight':
                        case 'PageDown':
                            e.preventDefault();
                            showPage(pageNum + 1);
                            break;
                        case 'ArrowLeft':
                        case 'PageUp':
                            e.preventDefault();
                            showPage(pageNum - 1);
                            break;
                        case 'Home':
                            e.preventDefault();
                            showPage(1);
                            break;
                        case 'End':
                            e.preventDefault();
                            showPage(pdfDoc ? pdfDoc.numPages : 1);
                            break;
                        case '+':
                        case '=':
                            e.preventDefault();
                            fitMode = 'none';
                            scale = Math.min(scale + 0.2, 4);
                            queueRenderPage(pageNum);
                            break;
                        case '-':
                            e.preventDefault();
                            fitMode = 'none';
                            scale = Math.max(scale - 0.2, 0.3);
                            queueRenderPage(pageNum);
                            break;
                        case 'r':
                        case 'R':
                            e.preventDefault();
                            rotation = (rotation + 90) % 360;
                            queueRenderPage(pageNum);
                            buildThumbnails();
                            break;
                        case 'w':
                        case 'W':
                            e.preventDefault();
                            fitMode = 'width';
                            queueRenderPage(pageNum);
                            break;
                        case 'f':
                        case 'F':
                            e.preventDefault();
                            fitMode = 'page';
                            queueRenderPage(pageNum);
                            break;
                    }
                });
            })();
        </script>
    </body>
</html>