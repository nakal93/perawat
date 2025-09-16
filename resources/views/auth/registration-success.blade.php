<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Pendaftaran Berhasil</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 10s;
        }
        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 30%;
            animation-delay: 15s;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(0px) rotate(180deg); }
            75% { transform: translateY(20px) rotate(270deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="gradient-bg">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12" style="z-index: 10; position: relative;">
        <div class="max-w-2xl w-full">
            <div class="glass-card rounded-2xl p-8 md:p-12 fade-in">
                <!-- Success Icon -->
                <div class="text-center mb-8">
                    <div class="mx-auto h-20 w-20 bg-emerald-500 rounded-full flex items-center justify-center mb-6 shadow-lg success-animation">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Pendaftaran Berhasil!</h1>
                    <div class="h-1 w-20 bg-emerald-400 mx-auto rounded-full mb-6"></div>
                </div>

                <!-- Success Message -->
                <div class="text-center space-y-6 mb-8">
                    <div class="bg-emerald-500/20 border border-emerald-400/30 rounded-xl p-6">
                        <svg class="h-8 w-8 text-emerald-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h2 class="text-xl font-semibold text-white mb-3">Terima Kasih telah Mendaftar!</h2>
                        <p class="text-emerald-100 leading-relaxed">
                            Data pendaftaran Anda telah berhasil disimpan dalam sistem kami. 
                            Akun Anda saat ini dalam status <strong class="text-emerald-300">menunggu aktivasi</strong>.
                        </p>
                    </div>

                    <div class="bg-blue-500/20 border border-blue-400/30 rounded-xl p-6">
                        <svg class="h-8 w-8 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-3">Proses Selanjutnya</h3>
                        <p class="text-blue-100 leading-relaxed">
                            Silakan tunggu konfirmasi dari <strong class="text-blue-300">Administrator</strong> untuk aktivasi akun Anda. 
                            Proses verifikasi biasanya memakan waktu <strong class="text-blue-300">1-2 hari kerja</strong>.
                        </p>
                    </div>
                </div>

                <!-- Information Cards -->
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <h4 class="text-white font-medium">Notifikasi Email</h4>
                        </div>
                        <p class="text-white/70 text-sm">
                            Anda akan menerima email konfirmasi setelah akun diaktivasi oleh admin.
                        </p>
                    </div>

                    <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h4 class="text-white font-medium">Data Tersimpan</h4>
                        </div>
                        <p class="text-white/70 text-sm">
                            Semua informasi yang Anda berikan telah tersimpan dengan aman di sistem.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Ke Halaman Login
                    </a>
                    
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-all duration-200 border border-white/20 hover:border-white/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/50">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Daftar Lagi
                    </a>
                </div>

                <!-- Footer Info -->
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-white/60 text-sm">
                        <x-footer variant="simple" :dark="true" class="!py-2" />
                    </p>
                    <p class="text-white/50 text-xs mt-1">
                        Jika Anda mengalami kendala, hubungi administrator sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
