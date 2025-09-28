<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pendataan Karyawan RS</title>
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
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
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

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo & Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                <p class="text-blue-100">Sistem Pendataan Karyawan Rumah Sakit</p>
            </div>

            <!-- Login Card -->
            <div class="glass-card rounded-2xl shadow-2xl p-8">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-400 bg-green-900/20 border border-green-400/20 rounded-lg p-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            Email Address
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                               placeholder="masukkan email anda">
                        @error('email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="input-glow w-full px-4 py-3 pr-12 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                                   placeholder="masukkan password">
                            <button type="button" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan/Sembunyikan password" class="absolute inset-y-0 right-0 px-3 flex items-center text-white/70 hover:text-white">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember"
                                   class="rounded bg-white/10 border-white/20 text-indigo-500 shadow-sm focus:ring-indigo-400 focus:ring-offset-transparent">
                            <span class="ml-2 text-sm text-white/90">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm text-blue-200 hover:text-white transition-colors duration-200">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- CAPTCHA -->
                    @php
                        $captcha = App\Helpers\CaptchaHelper::generate();
                        session(['captcha_hash' => $captcha['hash']]);
                    @endphp
                    <div>
                        <label for="captcha" class="block text-sm font-medium text-white mb-2">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Keamanan - Berapa hasil dari: 
                            <span id="captcha-question" class="font-bold text-yellow-200 text-lg">{{ $captcha['question'] }}</span> ?
                            <button type="button" 
                                    id="refresh-captcha" 
                                    class="ml-2 inline-flex items-center px-2 py-1 bg-white/10 hover:bg-white/20 border border-white/30 rounded-lg text-white/80 hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                    title="Ganti soal matematika">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                        </label>
                        <div class="relative">
                            <input id="captcha" 
                                   type="number" 
                                   name="captcha" 
                                   required 
                                   class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan jawaban (contoh: 15)"
                                   autocomplete="off">
                        </div>
                        <input type="hidden" name="captcha_hash" id="captcha-hash" value="{{ $captcha['hash'] }}">
                        @error('captcha')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk ke Sistem
                    </button>

                    <!-- Register Link -->
                    <div class="text-center pt-4 border-t border-white/10">
                        <p class="text-white/70">Belum memiliki akun?</p>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center mt-2 text-blue-200 hover:text-white font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Daftar Sekarang
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <x-footer variant="simple" :dark="true" />
        </div>
    </div>
</body>
<script>
    // Simple eye toggle
    (function(){
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        if(btn && input){
            btn.addEventListener('click', function(){
                const showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';
                // toggle icon (swap to crossed eye when showing)
                const eye = document.getElementById('eyeIcon');
                if(eye){
                    eye.innerHTML = showing
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.058 10.058 0 012.66-4.304m3.2-2.163A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-4.429 5.818M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m-3-3L3 21"/>';
                }
            });
        }
    })();

    // CAPTCHA refresh functionality
    (function(){
        const refreshBtn = document.getElementById('refresh-captcha');
        const questionSpan = document.getElementById('captcha-question');
        const hashInput = document.getElementById('captcha-hash');
        const captchaInput = document.getElementById('captcha');

        if(refreshBtn && questionSpan && hashInput && captchaInput){
            refreshBtn.addEventListener('click', async function(){
                // Show loading state
                const originalHtml = refreshBtn.innerHTML;
                refreshBtn.disabled = true;
                refreshBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                try {
                    const response = await fetch('{{ route("captcha.refresh") }}');
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    
                    const data = await response.json();
                    
                    // Update the display
                    questionSpan.textContent = data.question;
                    hashInput.value = data.hash;
                    captchaInput.value = ''; // Clear the input
                    captchaInput.focus(); // Focus on input for user convenience

                    // Show success feedback briefly
                    refreshBtn.innerHTML = '<svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    
                    setTimeout(() => {
                        refreshBtn.innerHTML = originalHtml;
                        refreshBtn.disabled = false;
                    }, 1000);

                } catch (error) {
                    console.error('Error refreshing CAPTCHA:', error);
                    
                    // Show error feedback
                    refreshBtn.innerHTML = '<svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    
                    setTimeout(() => {
                        refreshBtn.innerHTML = originalHtml;
                        refreshBtn.disabled = false;
                    }, 2000);
                }
            });
        }
    })();
    </script>
</html>
