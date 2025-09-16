<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Karyawan RS Dolopo</h2>
            <p class="mt-2 text-sm text-gray-600">Tahap 1: Data Dasar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ ruangan: '{{ old('ruangan_id') }}', profesi: '{{ old('profesi_id') }}' }" x-init="WilayahSelector.init()">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" class="text-base font-medium" />
                <x-text-input id="name" class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" 
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                              placeholder="Masukkan nama lengkap" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" class="text-base font-medium" />
                <x-text-input id="email" class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" 
                              type="email" name="email" :value="old('email')" required autocomplete="username" 
                              placeholder="email@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" class="text-base font-medium" />
                <x-text-input id="password" class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300"
                            type="password" name="password" required autocomplete="new-password" 
                            placeholder="Minimal 8 karakter" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-base font-medium" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300"
                            type="password" name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- NIK -->
            <div>
                <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" class="text-base font-medium" />
                <x-text-input id="nik" class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" 
                              type="text" name="nik" :value="old('nik')" required maxlength="16" 
                              placeholder="16 digit NIK" />
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>

            <!-- Regional Address Selector -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Alamat Domisili</h3>
                
                <!-- Provinsi -->
                <div>
                    <x-input-label for="provinsi_id" value="Provinsi" class="text-base font-medium" />
                    <select id="provinsi_id" name="provinsi_id" 
                            class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" required>
                        <option value="">Memuat data provinsi...</option>
                    </select>
                    <x-input-error :messages="$errors->get('provinsi_id')" class="mt-2" />
                </div>

                <!-- Kabupaten -->
                <div>
                    <x-input-label for="kabupaten_id" value="Kabupaten/Kota" class="text-base font-medium" />
                    <select id="kabupaten_id" name="kabupaten_id" 
                            class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" disabled required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    <x-input-error :messages="$errors->get('kabupaten_id')" class="mt-2" />
                </div>

                <!-- Kecamatan -->
                <div>
                    <x-input-label for="kecamatan_id" value="Kecamatan" class="text-base font-medium" />
                    <select id="kecamatan_id" name="kecamatan_id" 
                            class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" disabled required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <x-input-error :messages="$errors->get('kecamatan_id')" class="mt-2" />
                </div>

                <!-- Kelurahan -->
                <div>
                    <x-input-label for="kelurahan_id" value="Kelurahan/Desa" class="text-base font-medium" />
                    <select id="kelurahan_id" name="kelurahan_id" 
                            class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" disabled required>
                        <option value="">Pilih Kelurahan/Desa</option>
                    </select>
                    <x-input-error :messages="$errors->get('kelurahan_id')" class="mt-2" />
                </div>

                <!-- Detail Alamat -->
                <div>
                    <x-input-label for="alamat_detail" value="Detail Alamat" class="text-base font-medium" />
                    <textarea id="alamat_detail" name="alamat_detail" rows="3" 
                              class="block mt-2 w-full text-base rounded-lg border-gray-300 resize-none" 
                              placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05" required>{{ old('alamat_detail') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat_detail')" class="mt-2" />
                </div>

                <!-- Alamat Lengkap (Hidden field for legacy alamat) -->
                <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat') }}">

                <!-- Address Preview -->
                <div id="alamat_preview" class="mt-2"></div>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-base font-medium" />
                <div class="mt-2 space-y-3">
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" 
                               class="w-4 h-4 text-blue-600 border-gray-300" 
                               {{ old('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' }} required>
                        <span class="ml-3 text-base text-gray-900">Laki-laki</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" 
                               class="w-4 h-4 text-blue-600 border-gray-300" 
                               {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }} required>
                        <span class="ml-3 text-base text-gray-900">Perempuan</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>

            <!-- Ruangan -->
            <div>
                <x-input-label for="ruangan_id" value="Ruangan" class="text-base font-medium" />
                <select id="ruangan_id" name="ruangan_id" x-model="ruangan" 
                        class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" required>
                    <option value="">Pilih Ruangan</option>
                    @foreach(\App\Models\Ruangan::all() as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }} ({{ $ruangan->kode_ruangan }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('ruangan_id')" class="mt-2" />
            </div>

            <!-- Profesi -->
            <div>
                <x-input-label for="profesi_id" value="Profesi" class="text-base font-medium" />
                <select id="profesi_id" name="profesi_id" x-model="profesi" 
                        class="block mt-2 w-full h-12 text-base rounded-lg border-gray-300" required>
                    <option value="">Pilih Profesi</option>
                    @foreach(\App\Models\Profesi::all() as $profesi)
                        <option value="{{ $profesi->id }}" {{ old('profesi_id') == $profesi->id ? 'selected' : '' }}>
                            {{ $profesi->nama_profesi }} ({{ $profesi->kode_profesi }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('profesi_id')" class="mt-2" />
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-base touch-target transition duration-200">
                    Daftar
                </button>
            </div>

            <div class="text-center">
                <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('login') }}">
                    Sudah punya akun? Masuk di sini
                </a>
            </div>
        </form>
    </div>

    <!-- Include Wilayah Selector Script -->
    <script src="{{ asset('js/wilayah-selector.js') }}"></script>
    <script>
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-update hidden alamat field when address components change
            const updateAlamatField = () => {
                const alamatDetail = document.getElementById('alamat_detail').value;
                const alamatPreview = document.getElementById('alamat_preview');
                
                if (alamatPreview && alamatPreview.textContent.includes('Alamat Lengkap:')) {
                    const alamatLengkap = alamatPreview.querySelector('div:nth-child(2)');
                    if (alamatLengkap) {
                        document.getElementById('alamat').value = alamatDetail + ', ' + alamatLengkap.textContent;
                    }
                } else {
                    document.getElementById('alamat').value = alamatDetail;
                }
            };

            // Listen for changes in detail address
            document.getElementById('alamat_detail').addEventListener('input', updateAlamatField);
        });
    </script>
</x-guest-layout>
