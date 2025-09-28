@extends('layouts.app')

@section('breadcrumb', 'Settings')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
        <!-- Header -->
        <div class="relative bg-gradient-to-r from-purple-600 to-indigo-800 mb-10 shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="w-full py-12 relative z-10">
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                    <div class="mb-4 xl:mb-0">
                        <h1 class="text-4xl font-bold text-white tracking-tight">
                            Pengaturan Sistem
                        </h1>
                        <p class="mt-2 text-lg text-purple-100">
                            Konfigurasi dan manajemen sistem RSUD Dolopo
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

        <div class="w-full pb-12">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(($settings['maintenance_mode'] ?? false))
                <div class="bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded mb-6" role="alert">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-semibold">Maintenance aktif</span>
                            <span class="ml-2 text-sm">Aplikasi sedang dalam mode perawatan.</span>
                        </div>
                        @if(!empty($settings['maintenance_secret'] ?? null))
                            <a href="/{{ $settings['maintenance_secret'] }}" target="_blank" class="underline text-amber-800 hover:text-amber-900 text-sm">Buka link bypass</a>
                        @endif
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                
                <!-- Settings Categories -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <!-- System Settings -->
                    <div class="bg-white rounded-2xl shadow-lg shadow-blue-900/5 border border-slate-200 p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/25 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.365 1.19.404 1.836Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Pengaturan Sistem</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="flex items-center justify-between">
                                    <span class="text-slate-700 font-medium">Mode Maintenance</span>
                     <input type="checkbox" name="maintenance_mode" value="1" 
                         {{ old('maintenance_mode', ($settings['maintenance_mode'] ?? false) ? 1 : 0) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </label>
                                <p class="text-sm text-slate-500 mt-1">Mengaktifkan mode maintenance untuk sistem</p>
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="flex items-center justify-between">
                                    <span class="text-slate-700 font-medium">Auto Approval</span>
                     <input type="checkbox" name="auto_approval" value="1" 
                         {{ old('auto_approval', ($settings['auto_approval'] ?? false) ? 1 : 0) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </label>
                                <p class="text-sm text-slate-500 mt-1">Persetujuan otomatis untuk karyawan baru</p>
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="flex items-center justify-between">
                                    <span class="text-slate-700 font-medium">Email Notifications</span>
                     <input type="checkbox" name="email_notifications" value="1" 
                         {{ old('email_notifications', ($settings['email_notifications'] ?? true) ? 1 : 0) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </label>
                                <p class="text-sm text-slate-500 mt-1">Notifikasi email untuk admin</p>
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="block text-slate-700 font-medium mb-2">Max File Size (MB)</label>
                                <input type="number" name="max_file_size" 
                                       value="{{ old('max_file_size', $settings['max_file_size'] ?? 10) }}" 
                                       min="1" max="100"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-sm text-slate-500 mt-1">Ukuran maksimal file upload</p>
                                @error('max_file_size')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="bg-white rounded-2xl shadow-lg shadow-red-900/5 border border-slate-200 p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg shadow-red-500/25 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Keamanan</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="flex items-center justify-between">
                                    <span class="text-slate-700 font-medium">Two-Factor Authentication</span>
                     <input type="checkbox" name="two_factor_auth" value="1" 
                         {{ old('two_factor_auth', ($settings['two_factor_auth'] ?? false) ? 1 : 0) ? 'checked' : '' }}
                                           class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500">
                                </label>
                                <p class="text-sm text-slate-500 mt-1">Verifikasi dua langkah untuk admin</p>
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="flex items-center justify-between">
                                    <span class="text-slate-700 font-medium">Password Complexity</span>
                     <input type="checkbox" name="password_complexity" value="1" 
                         {{ old('password_complexity', ($settings['password_complexity'] ?? true) ? 1 : 0) ? 'checked' : '' }}
                                           class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500">
                                </label>
                                <p class="text-sm text-slate-500 mt-1">Kompleksitas password minimal</p>
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="block text-slate-700 font-medium mb-2">Session Timeout (minutes)</label>
                                <input type="number" name="session_timeout" 
                                       value="{{ old('session_timeout', $settings['session_timeout'] ?? 120) }}" 
                                       min="5" max="1440"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <p class="text-sm text-slate-500 mt-1">Timeout otomatis untuk sesi</p>
                                @error('session_timeout')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <label class="block text-slate-700 font-medium mb-2">Login Attempts</label>
                                <input type="number" name="login_attempts" 
                                       value="{{ old('login_attempts', $settings['login_attempts'] ?? 5) }}" 
                                       min="1" max="10"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <p class="text-sm text-slate-500 mt-1">Maksimal percobaan login sebelum blokir</p>
                                @error('login_attempts')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Master Data Management -->
            <div class="bg-white rounded-2xl shadow-lg shadow-emerald-900/5 border border-slate-200 p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg shadow-emerald-500/25 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Master Data</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.ruangan.index') }}" class="block p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-blue-900">Ruangan</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                        <p class="text-blue-700">Kelola data ruangan</p>
                    </a>
                    
                    <a href="{{ route('admin.profesi.index') }}" class="block p-6 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200 hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-emerald-900">Profesi</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600 group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                        <p class="text-emerald-700">Kelola data profesi</p>
                    </a>
                    
                    <a href="{{ route('admin.kategori-dokumen.index') }}" class="block p-6 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl border border-amber-200 hover:from-amber-100 hover:to-amber-200 transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-amber-900">Kategori Dokumen</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600 group-hover:translate-x-1 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                        <p class="text-amber-700">Kelola kategori dokumen</p>
                    </a>
                </div>
            </div>

                <!-- Save Button -->
                <div class="text-center">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/25 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-600/40 transition-all duration-300">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>

            <!-- System Info -->
            <div class="mt-10 bg-white rounded-2xl shadow-lg border border-slate-200 p-6" x-data="{info:null,loading:false,error:null,load(){this.loading=true;this.error=null;fetch('{{ route('admin.settings.system-info') }}').then(r=>r.json()).then(d=>{this.info=d}).catch(e=>{this.error='Gagal memuat informasi sistem'}).finally(()=>{this.loading=false})}}">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Informasi Sistem</h3>
                    <button @click="load()" type="button" class="px-3 py-1.5 text-sm bg-slate-800 text-white rounded-lg hover:bg-slate-700" :disabled="loading">
                        <span x-show="!loading" x-cloak>Muat</span>
                        <span x-show="loading" x-cloak>Memuat…</span>
                    </button>
                </div>
                <template x-if="error">
                    <p class="text-sm text-red-600" x-text="error"></p>
                </template>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-show="info" x-cloak>
                    <div class="text-sm"><span class="text-slate-500">PHP:</span> <span class="font-medium" x-text="info.php_version"></span></div>
                    <div class="text-sm"><span class="text-slate-500">Laravel:</span> <span class="font-medium" x-text="info.laravel_version"></span></div>
                    <div class="text-sm"><span class="text-slate-500">Database:</span> <span class="font-medium" x-text="info.database_connection"></span></div>
                    <div class="text-sm"><span class="text-slate-500">Cache:</span> <span class="font-medium" x-text="info.cache_driver"></span></div>
                    <div class="text-sm"><span class="text-slate-500">Queue:</span> <span class="font-medium" x-text="info.queue_driver"></span></div>
                    <div class="text-sm"><span class="text-slate-500">Mail:</span> <span class="font-medium" x-text="info.mail_driver"></span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
