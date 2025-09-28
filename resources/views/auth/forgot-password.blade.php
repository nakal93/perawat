<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Pendataan Karyawan RS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        .shape:nth-child(1) { top: 10%; left: 20%; width: 80px; height: 80px; animation-delay: 0s; }
        .shape:nth-child(2) { top: 20%; right: 20%; width: 120px; height: 120px; animation-delay: 2s; }
        .shape:nth-child(3) { bottom: 20%; left: 10%; width: 100px; height: 100px; animation-delay: 4s; }
        .shape:nth-child(4) { bottom: 30%; right: 10%; width: 60px; height: 60px; animation-delay: 1s; }
        .shape:nth-child(5) { top: 50%; left: 5%; width: 40px; height: 40px; animation-delay: 3s; }
        .shape:nth-child(6) { top: 60%; right: 15%; width: 90px; height: 90px; animation-delay: 5s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
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
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-xl xl:max-w-2xl">
            <!-- Main Card -->
            <div class="glass-card rounded-2xl lg:rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12 slide-in">
                <!-- Header -->
                <div class="text-center mb-8 lg:mb-12">
                    <div class="mx-auto w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mb-6 lg:mb-8">
                        <svg class="w-8 h-8 lg:w-10 lg:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-3 lg:mb-4">Lupa Password?</h1>
                    <p class="text-sm sm:text-base lg:text-lg text-blue-100 leading-relaxed max-w-lg mx-auto">
                        Tidak masalah! Masukkan alamat email Anda dan kami akan mengirimkan link untuk reset password.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-6 lg:mb-8 p-4 lg:p-6 bg-gradient-to-r from-green-400/20 to-emerald-500/20 border border-green-300/30 rounded-xl lg:rounded-2xl backdrop-blur-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 lg:h-8 lg:w-8 text-green-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm lg:text-base font-medium text-green-100 leading-relaxed">
                                    {{ session('status') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6 lg:space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm lg:text-base font-medium text-blue-100 mb-3 lg:mb-4">
                            Alamat Email
                        </label>
                        <input id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            placeholder="Masukkan alamat email Anda"
                            class="w-full h-12 lg:h-14 xl:h-16 px-4 lg:px-6 bg-white/10 border border-white/20 rounded-xl lg:rounded-2xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-sm lg:text-base input-glow" />
                        @error('email')
                            <p class="mt-2 text-sm lg:text-base text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div class="bg-gradient-to-r from-blue-400/20 to-indigo-500/20 border border-blue-300/30 rounded-xl lg:rounded-2xl p-4 lg:p-6 backdrop-blur-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 lg:h-8 lg:w-8 text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm lg:text-base font-medium text-blue-100 mb-3 lg:mb-4">
                                    Cara menggunakan fitur ini:
                                </h3>
                                <div class="text-xs lg:text-sm text-blue-200">
                                    <ol class="list-decimal list-inside space-y-2 lg:space-y-3 leading-relaxed">
                                        <li>Masukkan alamat email yang terdaftar</li>
                                        <li>Klik tombol "Kirim Link Reset Password"</li>
                                        <li>Periksa email Anda, Jangan Lupa cek Folder Spam</li>
                                        <li>Klik link di email untuk reset password</li>
                                        <li>Buat password baru sesuai persyaratan</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col space-y-4 lg:space-y-6">
                        <button type="submit" class="w-full h-12 lg:h-14 xl:h-16 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl lg:rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300/50 text-sm lg:text-base xl:text-lg">
                            Kirim Link Reset Password
                        </button>
                        
                        <!-- Back to Login -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center text-sm lg:text-base text-blue-200 hover:text-white font-medium transition-colors duration-300 hover:underline group">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Halaman Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
