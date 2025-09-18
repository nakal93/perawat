<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Reset Password</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Masukkan password baru Anda yang memenuhi persyaratan keamanan.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Alamat Email" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full h-12 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 bg-gray-50" 
                        type="email" 
                        name="email" 
                        :value="old('email', $request->email)" 
                        required 
                        readonly 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Requirements Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Persyaratan Password Baru:
                            </h3>
                            <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                                <li>Minimal 6 karakter</li>
                                <li>Mengandung minimal 1 huruf besar (A-Z)</li>
                                <li>Mengandung minimal 1 huruf kecil (a-z)</li>
                                <li>Mengandung minimal 1 angka (0-9)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password Baru" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full h-12 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Masukkan password baru" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    
                    <!-- Real-time validation will be inserted here -->
                    <div id="password-validation-msg" class="text-xs mt-2 space-y-1"></div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input id="password_confirmation" 
                        class="block mt-1 w-full h-12 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Ulangi password baru" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="w-full justify-center h-12 text-sm font-semibold">
                        Reset Password
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        if (passwordInput) {
            const validatePassword = (password) => {
                const requirements = [
                    { regex: /.{6,}/, text: 'Minimal 6 karakter', met: false },
                    { regex: /[A-Z]/, text: 'Minimal 1 huruf besar', met: false },
                    { regex: /[a-z]/, text: 'Minimal 1 huruf kecil', met: false },
                    { regex: /\d/, text: 'Minimal 1 angka', met: false }
                ];

                requirements.forEach(req => {
                    req.met = req.regex.test(password);
                });

                return requirements;
            };

            const updateValidationUI = (requirements) => {
                const msgEl = document.getElementById('password-validation-msg');
                if (passwordInput.value === '') {
                    msgEl.innerHTML = '';
                    return;
                }

                msgEl.innerHTML = requirements.map(req => 
                    `<div class="flex items-center gap-1 ${req.met ? 'text-green-600' : 'text-red-600'}">
                        <span class="text-xs">${req.met ? '✓' : '✗'}</span>
                        <span>${req.text}</span>
                    </div>`
                ).join('');
            };

            passwordInput.addEventListener('input', (e) => {
                const requirements = validatePassword(e.target.value);
                updateValidationUI(requirements);
            });

            passwordInput.addEventListener('blur', () => {
                if (passwordInput.value === '') {
                    const msgEl = document.getElementById('password-validation-msg');
                    if (msgEl) msgEl.innerHTML = '';
                }
            });
        }
    });
    </script>
    @endpush
</x-guest-layout>
