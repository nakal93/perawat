@extends('layouts.app')

@section('title', 'Lengkapi Profil Karyawan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Header Info -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Lengkapi Profil Karyawan</h2>
                    <p class="text-sm text-gray-600">Isi seluruh form di bawah ini untuk mengaktifkan akun dan mengakses sistem.</p>
                </div>
                <div class="flex items-center gap-3">
                    @php $status = auth()->user()->status; @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $status==='active' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : ($status==='approved' ? 'bg-blue-50 border border-blue-200 text-blue-700' : 'bg-amber-50 border border-amber-200 text-amber-700') }}">
                        Status: {{ ucfirst($status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Ada beberapa kesalahan yang perlu diperbaiki:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('karyawan.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Foto Profil -->
                    <div class="sm:col-span-2">
                        <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil (Opsional)</label>
                        <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('foto_profil')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik', $karyawan->nik ?? '') }}" required maxlength="16" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nik')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Status Pegawai -->
                    <div>
                        <label for="status_pegawai_id" class="block text-sm font-medium text-gray-700 mb-2">Status Pegawai *</label>
                        <select name="status_pegawai_id" id="status_pegawai_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Status</option>
                            @foreach(\App\Models\StatusPegawai::orderBy('nama')->get() as $st)
                                <option value="{{ $st->id }}" @selected(old('status_pegawai_id', $karyawan->status_pegawai_id ?? null)==$st->id)>{{ $st->nama }}</option>
                            @endforeach
                        </select>
                        @error('status_pegawai_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP <span class="text-xs text-gray-500">(Opsional)</span></label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $karyawan->nip ?? '') }}" maxlength="30" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Wajib untuk status PNS atau PPPK.</p>
                        @error('nip')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')==='Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')==='Perempuan')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', isset($karyawan->tanggal_lahir) ? \Illuminate\Support\Carbon::parse($karyawan->tanggal_lahir)->format('Y-m-d') : '') }}" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_lahir')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Golongan Darah -->
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tidak tahu</option>
                            @foreach(['A','B','AB','O'] as $g)
                                <option value="{{ $g }}" @selected(old('golongan_darah', $karyawan->golongan_darah ?? '')===$g)>{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('golongan_darah')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Status Perkawinan -->
                    <div>
                        <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            <option value="Belum Kawin" @selected(old('status_perkawinan', $karyawan->status_perkawinan ?? '')==='Belum Kawin')>Belum Kawin</option>
                            <option value="Kawin" @selected(old('status_perkawinan', $karyawan->status_perkawinan ?? '')==='Kawin')>Kawin</option>
                            <option value="Cerai Hidup" @selected(old('status_perkawinan', $karyawan->status_perkawinan ?? '')==='Cerai Hidup')>Cerai Hidup</option>
                            <option value="Cerai Mati" @selected(old('status_perkawinan', $karyawan->status_perkawinan ?? '')==='Cerai Mati')>Cerai Mati</option>
                        </select>
                        @error('status_perkawinan')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $karyawan->no_hp ?? '') }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0812...">
                        @error('no_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nama Ibu Kandung -->
                    <div>
                        <label for="nama_ibu_kandung" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu Kandung</label>
                        <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $karyawan->nama_ibu_kandung ?? '') }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_ibu_kandung')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Alamat Detail & Wilayah -->
                    <div class="sm:col-span-2 space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Alamat Domisili *</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            <select id="provinsi_id" name="provinsi_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('provinsi_id', $karyawan->provinsi_id ?? '') }}">
                                <option value="">Provinsi</option>
                            </select>
                            <select id="kabupaten_id" name="kabupaten_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kabupaten_id', $karyawan->kabupaten_id ?? '') }}" disabled>
                                <option value="">Kab/Kota</option>
                            </select>
                            <select id="kecamatan_id" name="kecamatan_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kecamatan_id', $karyawan->kecamatan_id ?? '') }}" disabled>
                                <option value="">Kecamatan</option>
                            </select>
                            <select id="kelurahan_id" name="kelurahan_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kelurahan_id', $karyawan->kelurahan_id ?? '') }}" disabled>
                                <option value="">Kelurahan</option>
                            </select>
                        </div>
                        <textarea id="alamat_detail" name="alamat_detail" rows="2" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Detail (RT/RW, Jalan, Blok)">{{ old('alamat_detail', $karyawan->alamat_detail ?? '') }}</textarea>
                        <div id="alamat_preview" class="text-xs text-gray-600"></div>
                        <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat', $karyawan->alamat ?? '') }}">
                        @error('alamat')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Ruangan -->
                    <div>
                        <label for="ruangan_id" class="block text-sm font-medium text-gray-700 mb-2">Ruangan *</label>
                        <select name="ruangan_id" id="ruangan_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" @selected(old('ruangan_id', $karyawan->ruangan_id ?? null)==$r->id)>{{ $r->nama_ruangan }} ({{ $r->kode_ruangan }})</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Profesi -->
                    <div>
                        <label for="profesi_id" class="block text-sm font-medium text-gray-700 mb-2">Profesi *</label>
                        <select name="profesi_id" id="profesi_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Profesi</option>
                            @foreach($profesi as $p)
                                <option value="{{ $p->id }}" @selected(old('profesi_id', $karyawan->profesi_id ?? null)==$p->id)>{{ $p->nama_profesi }} ({{ $p->kode_profesi }})</option>
                            @endforeach
                        </select>
                        @error('profesi_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tanggal Masuk Kerja -->
                    <div>
                        <label for="tanggal_masuk_kerja" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk Kerja</label>
                        <input type="date" name="tanggal_masuk_kerja" id="tanggal_masuk_kerja" value="{{ old('tanggal_masuk_kerja', isset($karyawan->tanggal_masuk_kerja) ? \Illuminate\Support\Carbon::parse($karyawan->tanggal_masuk_kerja)->format('Y-m-d') : '') }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_masuk_kerja')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                        <select name="agama" id="agama" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                                <option value="{{ $agama }}" @selected(old('agama', $karyawan->agama ?? '')===$agama)>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Pendidikan Terakhir -->
                    <div>
                        <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir *</label>
                        <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $karyawan->pendidikan_terakhir ?? '') }}" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="contoh: S1 Keperawatan">
                        @error('pendidikan_terakhir')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Gelar -->
                    <div>
                        <label for="gelar" class="block text-sm font-medium text-gray-700 mb-2">Gelar (Opsional)</label>
                        <input type="text" name="gelar" id="gelar" value="{{ old('gelar', $karyawan->gelar ?? '') }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="S.Kep, Ners">
                        @error('gelar')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kampus -->
                    <div>
                        <label for="kampus" class="block text-sm font-medium text-gray-700 mb-2">Asal Kampus (Opsional)</label>
                        <input type="text" name="kampus" id="kampus" value="{{ old('kampus', $karyawan->kampus ?? '') }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Universitas ...">
                        @error('kampus')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center gap-4">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition-colors focus:ring-4 focus:ring-blue-200">Simpan & Selesaikan Profil</button>
                    <p class="text-xs text-gray-500">Setelah lengkap, Anda akan melihat tampilan profil yang sudah lengkap.</p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/wilayah-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Initialize wilayah selector
    WilayahSelector.init({
        preselect: {
            provinsi_id: document.getElementById('provinsi_id')?.dataset.selected || '',
            kabupaten_id: document.getElementById('kabupaten_id')?.dataset.selected || '',
            kecamatan_id: document.getElementById('kecamatan_id')?.dataset.selected || '',
            kelurahan_id: document.getElementById('kelurahan_id')?.dataset.selected || ''
        }
    });

    // Handle NIP requirement based on status pegawai
    const statusPegawaiSelect = document.getElementById('status_pegawai_id');
    const nipInput = document.getElementById('nip');
    const nipLabel = document.querySelector('label[for="nip"]');
    
    function toggleNipRequirement() {
        const selectedOption = statusPegawaiSelect.options[statusPegawaiSelect.selectedIndex];
        const statusNama = selectedOption.text;
        
        if (statusNama === 'PNS' || statusNama === 'PPPK') {
            nipInput.required = true;
            nipLabel.innerHTML = 'NIP * <span class="text-xs text-gray-500">(Wajib untuk PNS/PPPK)</span>';
            nipInput.classList.remove('border-gray-300');
            nipInput.classList.add('border-red-300');
        } else {
            nipInput.required = false;
            nipLabel.innerHTML = 'NIP <span class="text-xs text-gray-500">(Opsional)</span>';
            nipInput.classList.remove('border-red-300');
            nipInput.classList.add('border-gray-300');
        }
    }
    
    if (statusPegawaiSelect) {
        statusPegawaiSelect.addEventListener('change', toggleNipRequirement);
        // Call once on load to set initial state
        toggleNipRequirement();
    }
});
</script>
@endpush
