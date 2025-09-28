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
    <style>[x-cloak]{ display:none !important }</style>
    </head>
    <body class="font-inter antialiased bg-slate-50">
        <div class="min-h-screen">
            <!-- Mobile menu button (hidden on lg+ screens) -->
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
                                    <p class="text-blue-100 text-xs font-medium">Sistem Pendataan Komite Keperawatan</p>
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
                    <nav class="flex-1 px-4 py-6 overflow-y-auto" style="max-height: none !important; overflow: visible !important;">
                        <!-- User Profile Section -->
                        <div class="mb-6 px-3 py-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center ring-2 ring-blue-100">
                                    <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
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
                            <a href="{{ route('admin.karyawan.create') }}" class="@if(request()->routeIs('admin.karyawan.*')) bg-gradient-to-r from-green-50 to-green-100 text-green-700 border-r-4 border-green-600 shadow-sm @else text-slate-700 hover:bg-slate-50 hover:text-slate-900 @endif group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 relative overflow-hidden">
                                @if(request()->routeIs('admin.karyawan.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-green-50/50 to-transparent"></div>
                                @endif
                                <div class="relative flex items-center w-full">
                                    <div class="@if(request()->routeIs('admin.karyawan.*')) bg-green-600 text-white @else bg-slate-200 text-slate-600 group-hover:bg-slate-300 @endif w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Karyawan</span>
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

                                <!-- Security Menu - DEBUGGING -->
                                <div x-data="{ securityOpen: true }" class="bg-red-200 border-2 border-red-600 rounded-xl transition-all duration-200 relative mt-3 shadow-lg p-4" style="background-color: #fecaca !important; border: 2px solid #dc2626 !important;">
                                    <div class="text-red-800 font-bold text-center mb-2">🔒 SECURITY MENU HERE 🔒</div>
                                    @if(request()->routeIs('admin.security.*') || request()->routeIs('telescope*') || request()->routeIs('logs*'))
                                        <div class="absolute inset-0 bg-gradient-to-r from-red-50/50 to-transparent"></div>
                                    @endif
                                    
                                    <!-- Security Toggle Button -->
                                    <button @click="securityOpen = !securityOpen" class="bg-red-600 text-white group flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium transition-all duration-200 relative hover:bg-red-700 rounded-lg" style="background-color: #dc2626 !important; color: white !important;">
                                        <div class="flex items-center">
                                            <div class="bg-red-600 text-white w-7 h-7 rounded-lg flex items-center justify-center mr-3 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-sm">Security</span>
                                        </div>
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="securityOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Security Submenu -->
                                    <div x-show="securityOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-4 mt-2 space-y-1 pb-3">
                                        
                                        <!-- Laravel Telescope -->
                                        <a href="/telescope" target="_blank" class="@if(request()->routeIs('telescope*')) bg-red-100 text-red-700 @else text-slate-500 hover:text-slate-700 hover:bg-slate-50 @endif group flex items-center px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full mr-3 flex-shrink-0"></div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                                <span>Laravel Telescope</span>
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </div>
                                        </a>
                                        
                                        <!-- System Logs -->
                                        <a href="{{ route('admin.security.logs') }}" class="@if(request()->routeIs('admin.security.logs')) bg-red-100 text-red-700 @else text-slate-500 hover:text-slate-700 hover:bg-slate-50 @endif group flex items-center px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 flex-shrink-0"></div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span>System Logs</span>
                                            </div>
                                        </a>
                                        
                                        <!-- Activity Logs -->
                                        <a href="{{ route('admin.security.activity') }}" class="@if(request()->routeIs('admin.security.activity')) bg-red-100 text-red-700 @else text-slate-500 hover:text-slate-700 hover:bg-slate-50 @endif group flex items-center px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200">
                                            <div class="w-2 h-2 bg-green-400 rounded-full mr-3 flex-shrink-0"></div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>Activity Logs</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                        
                    <!-- Enhanced Footer with System Info -->
                    <div class="px-4 pb-4">
                        <x-footer />
                    </div>
                </div>
                
                <!-- Enhanced Main content with responsive sidebar offset -->
                <div class="lg:pl-64">
                    @include('layouts.navigation')
                    
                    <!-- Page Content -->
                    <main class="flex-1">
                        {{ $slot }}
                    </main>
                </div>
            @else
                <!-- Regular layout for non-admin users -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            @endif
        </div>

        <!-- Enhanced Mobile Menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileCloseButton = document.getElementById('mobile-close-button');
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
                
                function openMobileSidebar() {
                    mobileSidebar.classList.remove('-translate-x-full');
                    mobileSidebar.classList.add('translate-x-0');
                    mobileSidebarOverlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
                }
                
                function closeMobileSidebar() {
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebar.classList.remove('translate-x-0');
                    mobileSidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
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
    </body>
</html>
