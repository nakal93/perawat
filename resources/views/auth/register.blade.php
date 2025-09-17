<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Pendataan Karyawan RS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="/js/wilayah-selector.js"></script>
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
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            position: relative;
        }
        .step.active {
            background: rgba(99, 102, 241, 0.8);
            color: white;
        }
        .step.inactive {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
        }
        .step-line {
            width: 60px;
            height: 2px;
            background: rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 50%;
            right: -70px;
            transform: translateY(-50%);
        }
        .step:last-child .step-line { display: none; }
        .section-divider {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin: 1.5rem 0;
            padding-bottom: 1.5rem;
        }
        .section-title {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        .radio-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        .radio-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(99, 102, 241, 0.5);
        }
        .radio-card input[type="radio"]:checked + label {
            background: rgba(99, 102, 241, 0.2);
            border-color: rgba(99, 102, 241, 0.5);
        }
        
        /* Dropdown options styling for better visibility */
        select option {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            padding: 8px 12px !important;
        }
        
        select option:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        
        select option:checked {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
        }
        
        /* For better cross-browser compatibility */
        select {
            color: white !important;
        }
        
        select:focus option {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
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
        <div class="max-w-4xl w-full space-y-8">
            <!-- Logo & Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Pendaftaran Karyawan</h2>
                <p class="text-blue-100">Sistem Pendataan Karyawan Rumah Sakit</p>
            </div>

            <!-- Register Card -->
            <div class="glass-card rounded-2xl shadow-2xl p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-8" x-data="{ ruangan: '{{ old('ruangan_id') }}', profesi: '{{ old('profesi_id') }}' }" x-init="() => {
                    WilayahSelector.init({
                        preselect: {
                            provinsi_id: '{{ old('provinsi_id') }}',
                            kabupaten_id: '{{ old('kabupaten_id') }}',
                            kecamatan_id: '{{ old('kecamatan_id') }}',
                            kelurahan_id: '{{ old('kelurahan_id') }}'
                        }
                    });
                }">
                    @csrf

                    <!-- Section 1: Data Dasar -->
                    <div class="section-divider">
                        <h3 class="section-title">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Data Dasar & Akun
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-white mb-2">
                                    Nama Lengkap
                                </label>
                                <input id="name" 
                                       type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name"
                                       class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-white mb-2">
                                    Email Address
                                </label>
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="username"
                                       class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                                       placeholder="email@example.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-white mb-2">
                                    NIK (16 digit)
                                </label>
                                <input id="nik" 
                                       type="text" 
                                       name="nik" 
                                       value="{{ old('nik') }}" 
                                       required 
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                                       placeholder="16 digit NIK">
                                @error('nik')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                <div>
                                <label for="password" class="block text-sm font-medium text-white mb-2">
                                    Password
                                </label>
                    <input id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                        placeholder="Min 6, 1 huruf besar & 1 angka">
                    <p id="pwHint" class="mt-2 text-xs text-white/80">Syarat: minimal 6 karakter, mengandung huruf besar dan angka.</p>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">
                                    Konfirmasi Password
                                </label>
                                <input id="password_confirmation" 
                                       type="password" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200"
                                       placeholder="Ulangi password">
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Alamat -->
                    <div class="section-divider">
                        <h3 class="section-title">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Alamat Domisili
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Provinsi -->
                            <div>
                                <label for="provinsi_id" class="block text-sm font-medium text-white mb-2">
                                    Provinsi
                                </label>
                                <select id="provinsi_id" name="provinsi_id" required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Memuat data provinsi...</option>
                                </select>
                                @error('provinsi_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kabupaten -->
                            <div>
                                <label for="kabupaten_id" class="block text-sm font-medium text-white mb-2">
                                    Kabupaten/Kota
                                </label>
                                <select id="kabupaten_id" name="kabupaten_id" disabled required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                                @error('kabupaten_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label for="kecamatan_id" class="block text-sm font-medium text-white mb-2">
                                    Kecamatan
                                </label>
                                <select id="kecamatan_id" name="kecamatan_id" disabled required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelurahan -->
                            <div>
                                <label for="kelurahan_id" class="block text-sm font-medium text-white mb-2">
                                    Kelurahan/Desa
                                </label>
                                <select id="kelurahan_id" name="kelurahan_id" disabled required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                                @error('kelurahan_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Detail Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat_detail" class="block text-sm font-medium text-white mb-2">
                                    Detail Alamat
                                </label>
                                <textarea id="alamat_detail" name="alamat_detail" rows="3" required
                                          class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200 resize-none"
                                          placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05">{{ old('alamat_detail') }}</textarea>
                                @error('alamat_detail')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hidden alamat field -->
                            <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror

                            <!-- Address Preview -->
                            <div id="alamat_preview" class="md:col-span-2 mt-2"></div>
                        </div>
                    </div>

                    <!-- Section 3: Data Kepegawaian -->
                    <div>
                        <h3 class="section-title">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Data Kepegawaian
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-sm font-medium text-white mb-3">
                                    Jenis Kelamin
                                </label>
                                <div class="space-y-2">
                                    <label class="radio-card flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" 
                                               {{ old('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' }}
                                               class="w-4 h-4 text-indigo-500 border-white/20 bg-white/10 focus:ring-indigo-400 focus:ring-offset-0" required>
                                        <span class="ml-3 text-white">Laki-laki</span>
                                    </label>
                                    <label class="radio-card flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" 
                                               {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }}
                                               class="w-4 h-4 text-indigo-500 border-white/20 bg-white/10 focus:ring-indigo-400 focus:ring-offset-0" required>
                                        <span class="ml-3 text-white">Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ruangan -->
                            <div>
                                <label for="ruangan_id" class="block text-sm font-medium text-white mb-2">
                                    Ruangan
                                </label>
                                <select id="ruangan_id" name="ruangan_id" x-model="ruangan" required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::all() as $ruangan)
                                        <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }} ({{ $ruangan->kode_ruangan }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruangan_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Profesi -->
                            <div>
                                <label for="profesi_id" class="block text-sm font-medium text-white mb-2">
                                    Profesi
                                </label>
                                <select id="profesi_id" name="profesi_id" x-model="profesi" required
                                        class="input-glow w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Profesi</option>
                                    @foreach(\App\Models\Profesi::all() as $profesi)
                                        <option value="{{ $profesi->id }}" {{ old('profesi_id') == $profesi->id ? 'selected' : '' }}>
                                            {{ $profesi->nama_profesi }} ({{ $profesi->kode_profesi }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('profesi_id')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg text-lg">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Daftar Sekarang
                    </button>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t border-white/10">
                        <p class="text-white/70">Sudah memiliki akun?</p>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center mt-2 text-blue-200 hover:text-white font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk ke Akun
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <x-footer variant="simple" :dark="true" />
        </div>
    </div>

    <!-- Include Wilayah Selector Script -->
    <script src="{{ asset('js/wilayah-selector.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alamatDetailEl = document.getElementById('alamat_detail');
            const alamatHiddenEl = document.getElementById('alamat');
            const previewEl = document.getElementById('alamat_preview');
            const form = document.querySelector('form[action="{{ route('register') }}"]');
            const regionIds = ['provinsi_id','kabupaten_id','kecamatan_id','kelurahan_id'];
            const pw = document.getElementById('password');
            const pwc = document.getElementById('password_confirmation');

            function validatePasswordInline() {
                if (!pw) return true;
                const val = pw.value || '';
                const ok = val.length >= 6 && /[A-Z]/.test(val) && /\d/.test(val);
                const hint = document.getElementById('pwHint');
                if (hint) {
                    hint.className = 'mt-2 text-xs ' + (ok ? 'text-emerald-300' : 'text-red-300');
                }
                return ok;
            }

            function composeAlamat() {
                const detail = alamatDetailEl.value.trim();
                // Attempt to read displayed names from the select elements' selected options
                const parts = regionIds.map(id => {
                    const sel = document.getElementById(id);
                    if (!sel || !sel.value) return null;
                    const opt = sel.options[sel.selectedIndex];
                    return opt ? opt.text.replace(/\s+/g,' ').trim() : null;
                }).filter(Boolean);

                const wilayah = parts.join(', ');
                let full = detail;
                if (wilayah) {
                    full = detail ? detail + ', ' + wilayah : wilayah;
                }
                alamatHiddenEl.value = full;
                return full;
            }

            function updatePreview() {
                const full = composeAlamat();
                if (previewEl) {
                    previewEl.innerHTML = full
                        ? '<div class="mt-2 text-xs text-emerald-200">Alamat Lengkap:</div><div class="text-sm text-white">' + full + '</div>'
                        : '';
                }
            }

            // Bind listeners
            alamatDetailEl.addEventListener('input', () => { composeAlamat(); updatePreview(); });
            regionIds.forEach(id => {
                const sel = document.getElementById(id);
                if (sel) {
                    sel.addEventListener('change', () => { composeAlamat(); updatePreview(); });
                }
            });

            // Double-submit guard & client-side validation
            if (form) {
                let submitting = false;
                form.addEventListener('submit', function(e) {
                    composeAlamat();
                    if (!alamatHiddenEl.value) {
                        e.preventDefault();
                        alert('Alamat belum lengkap. Lengkapi detail alamat dan pilih wilayah.');
                        return;
                    }
                    // quick client-side password check
                    if (!validatePasswordInline()) {
                        e.preventDefault();
                        alert('Password belum memenuhi syarat (min 6, huruf besar, angka).');
                        return;
                    }
                    if (pwc && pw && pw.value !== pwc.value) {
                        e.preventDefault();
                        alert('Konfirmasi password tidak cocok.');
                        return;
                    }
                    if (submitting) {
                        e.preventDefault();
                        return;
                    }
                    submitting = true;
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-70','cursor-not-allowed');
                        btn.innerHTML = '<svg class="inline w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 12a8 8 0 018-8" /></svg> Memproses...';
                    }
                });
            }

            // Initial compose (in case of old() values)
            composeAlamat();
            updatePreview();
            if (pw) {
                pw.addEventListener('input', validatePasswordInline);
            }
        });
    </script>
</body>
</html>
