@extends('layouts.app')

@section('breadcrumb', 'Pengaturan Akun')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex justify-between items-center h-14 sm:h-16">
                <h1 class="text-lg sm:text-xl font-semibold text-gray-900">Pengaturan Profil</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 lg:py-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-6">
            <!-- Settings menu - Desktop -->
            <aside class="hidden lg:block lg:col-span-3">
                <div class="bg-white rounded-xl border shadow-sm p-4 sticky top-24">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Pengaturan</h3>
                    <nav class="space-y-1 text-sm">
                        <a href="#akun" data-target="akun" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Akun</a>
                        <a href="#identitas" data-target="identitas" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Identitas</a>
                        <a href="#kepegawaian" data-target="kepegawaian" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Kepegawaian</a>
                        <a href="#kontak" data-target="kontak" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Kontak</a>
                        <a href="#pendidikan" data-target="pendidikan" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Pendidikan</a>
                        <a href="#keluarga" data-target="keluarga" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Keluarga</a>
                        <a href="#password" data-target="password" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600 transition-colors">Kata Sandi</a>
                    </nav>
                </div>
            </aside>

            <!-- Settings content -->
            <div class="lg:col-span-9 space-y-6 lg:space-y-8">
                <!-- Mobile tabs nav -->
                <div class="lg:hidden bg-white rounded-xl border shadow-sm p-2 sticky top-0 z-20">
                    <div class="overflow-x-auto">
                        <nav class="flex items-center gap-2 min-w-max pb-2">
                            @php $tabs = ['akun'=>'Akun','identitas'=>'Identitas','kepegawaian'=>'Kepegawaian','kontak'=>'Kontak','pendidikan'=>'Pendidikan','keluarga'=>'Keluarga','password'=>'Kata Sandi']; @endphp
                            @foreach($tabs as $id=>$label)
                                <a href="#{{ $id }}" data-target="{{ $id }}" class="js-nav-link whitespace-nowrap px-3 py-2 text-sm rounded-full bg-slate-50 text-slate-700 hover:bg-slate-100 transition-colors">{{ $label }}</a>
                            @endforeach
                        </nav>
                    </div>
                </div>
                @if(session('success'))
                    <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
                @endif

                <form action="{{ route('karyawan.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsUnifiedForm">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Akun -->
                    <div id="akun" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-blue-500 to-indigo-600"></span>
                            <h2 class="text-lg font-semibold text-slate-900">Akun</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $akunErrorKeys = ['name','email','foto_profil'];
                                $akunErrors = [];
                                foreach ($akunErrorKeys as $key) { 
                                    foreach ($errors->get($key) as $message) { 
                                        $akunErrors[] = $message; 
                                    } 
                                }
                            @endphp
                            @if(!empty($akunErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($akunErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                                    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Foto Profil</label>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    @if(isset($user) && $user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border">
                                    @else
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                    <input type="file" name="foto_profil" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                @error('foto_profil')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Identitas -->
                    <div id="identitas" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-teal-500 to-emerald-600"></span>
                            <h2 class="text-lg font-semibold">Identitas</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $identitasKeys = ['nik','nip','tanggal_lahir','jenis_kelamin','alamat','golongan_darah'];
                                $identitasErrors = [];
                                foreach ($identitasKeys as $k) { foreach ($errors->get($k) as $m) { $identitasErrors[] = $m; } }
                            @endphp
                            @if(!empty($identitasErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($identitasErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">NIK</label>
                                    <input type="text" name="nik" value="{{ old('nik', $karyawan->nik ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm sm:text-base">
                                    @error('nik')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div id="field-nip" class="hidden">
                                    <label class="block text-sm font-medium text-slate-600 mb-2">NIP</label>
                                    <input type="text" name="nip" value="{{ old('nip', $karyawan->nip ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm sm:text-base">
                                    @error('nip')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm sm:text-base">
                                    @error('tanggal_lahir')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm sm:text-base">
                                        <option value="">- Pilih -</option>
                                        <option value="Laki-laki" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')=='Laki-laki')>Laki-laki</option>
                                        <option value="Perempuan" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')=='Perempuan')>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Golongan Darah</label>
                                    <select name="golongan_darah" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm sm:text-base">
                                        <option value="">Tidak tahu</option>
                                        @foreach(['A','B','AB','O'] as $g)
                                            <option value="{{ $g }}" @selected(($karyawan->golongan_darah ?? '')===$g)> {{ $g }} </option>
                                        @endforeach
                                    </select>
                                    @error('golongan_darah')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            
                            <!-- Alamat Domisili -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Alamat Domisili</label>
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                                    <select id="provinsi_id_settings" name="provinsi_id" class="border border-gray-300 rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm" data-selected="{{ old('provinsi_id', $karyawan->provinsi_id ?? '') }}">
                                        <option value="">Provinsi</option>
                                    </select>
                                    <select id="kabupaten_id_settings" name="kabupaten_id" class="border border-gray-300 rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm" disabled data-selected="{{ old('kabupaten_id', $karyawan->kabupaten_id ?? '') }}">
                                        <option value="">Kab/Kota</option>
                                    </select>
                                    <select id="kecamatan_id_settings" name="kecamatan_id" class="border border-gray-300 rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm" disabled data-selected="{{ old('kecamatan_id', $karyawan->kecamatan_id ?? '') }}">
                                        <option value="">Kecamatan</option>
                                    </select>
                                    <select id="kelurahan_id_settings" name="kelurahan_id" class="border border-gray-300 rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm" disabled data-selected="{{ old('kelurahan_id', $karyawan->kelurahan_id ?? '') }}">
                                        <option value="">Kelurahan</option>
                                    </select>
                                </div>
                                <textarea id="alamat_detail_settings" name="alamat_detail" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none text-sm" placeholder="Detail alamat (Jl, RT/RW, patokan)">{{ old('alamat_detail', $karyawan->alamat_detail ?? '') }}</textarea>
                                <input type="hidden" name="alamat" id="alamat_settings" value="{{ old('alamat', $karyawan->alamat ?? '') }}">
                                @error('alamat')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kepegawaian -->
                    <div id="kepegawaian" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-purple-500 to-fuchsia-600"></span>
                            <h2 class="text-lg font-semibold">Kepegawaian</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $kepegawaianKeys = ['status_pegawai_id','tanggal_masuk_kerja','profesi_id','ruangan_id','agama','status_perkawinan'];
                                $kepegawaianErrors = [];
                                foreach ($kepegawaianKeys as $k) { foreach ($errors->get($k) as $m) { $kepegawaianErrors[] = $m; } }
                            @endphp
                            @if(!empty($kepegawaianErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($kepegawaianErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Status Pegawai</label>
                                    <select name="status_pegawai_id" id="status_pegawai_id" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                        <option value="">- Pilih -</option>
                                        @foreach(\App\Models\StatusPegawai::orderBy('nama')->get() as $st)
                                            <option value="{{ $st->id }}" @selected(old('status_pegawai_id', $karyawan->status_pegawai_id ?? '')==$st->id)>{{ $st->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_pegawai_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Tanggal Masuk Kerja</label>
                                    <input type="date" name="tanggal_masuk_kerja" value="{{ old('tanggal_masuk_kerja', $karyawan->tanggal_masuk_kerja ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                    @error('tanggal_masuk_kerja')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Profesi</label>
                                    <select name="profesi_id" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                        <option value="">- Pilih -</option>
                                        @foreach(\App\Models\Profesi::orderBy('nama_profesi')->get() as $p)
                                            <option value="{{ $p->id }}" @selected(old('profesi_id', $karyawan->profesi_id ?? '')==$p->id)>{{ $p->nama_profesi }}</option>
                                        @endforeach
                                    </select>
                                    @error('profesi_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Ruangan</label>
                                    <select name="ruangan_id" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                        <option value="">- Pilih -</option>
                                        @foreach(\App\Models\Ruangan::orderBy('nama_ruangan')->get() as $r)
                                            <option value="{{ $r->id }}" @selected(old('ruangan_id', $karyawan->ruangan_id ?? '')==$r->id)>{{ $r->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Agama</label>
                                    <select name="agama" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                        <option value="">Pilih Agama</option>
                                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $opt)
                                            <option value="{{ $opt }}" @selected(($karyawan->agama ?? '')===$opt)>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Status Perkawinan</label>
                                    <select name="status_perkawinan" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base">
                                        <option value="">Pilih</option>
                                        @php $sp = $karyawan->status_perkawinan ?? ''; @endphp
                                        <option value="Belum Kawin" @selected($sp==='Belum Kawin')>Belum Kawin</option>
                                        <option value="Kawin" @selected($sp==='Kawin')>Kawin</option>
                                        <option value="Cerai Hidup" @selected($sp==='Cerai Hidup')>Cerai Hidup</option>
                                        <option value="Cerai Mati" @selected($sp==='Cerai Mati')>Cerai Mati</option>
                                    </select>
                                    @error('status_perkawinan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div id="kontak" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-rose-500 to-orange-500"></span>
                            <h2 class="text-lg font-semibold">Kontak</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $kontakKeys = ['no_hp'];
                                $kontakErrors = [];
                                foreach ($kontakKeys as $k) { foreach ($errors->get($k) as $m) { $kontakErrors[] = $m; } }
                            @endphp
                            @if(!empty($kontakErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($kontakErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">No HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm sm:text-base" placeholder="Contoh: 08123456789">
                                    @error('no_hp')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pendidikan -->
                    <div id="pendidikan" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-cyan-500 to-sky-500"></span>
                            <h2 class="text-lg font-semibold">Pendidikan</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $pendidikanKeys = ['pendidikan_terakhir','gelar','kampus'];
                                $pendidikanErrors = [];
                                foreach ($pendidikanKeys as $k) { foreach ($errors->get($k) as $m) { $pendidikanErrors[] = $m; } }
                            @endphp
                            @if(!empty($pendidikanErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($pendidikanErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Pendidikan Terakhir</label>
                                    @php $pt = old('pendidikan_terakhir', $karyawan->pendidikan_terakhir ?? ''); @endphp
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base">
                                        <option value="">- Pilih -</option>
                                        <option value="SD" @selected($pt==='SD')>SD</option>
                                        <option value="SMP" @selected($pt==='SMP')>SMP</option>
                                        <option value="SMA/SMK" @selected($pt==='SMA/SMK')>SMA/SMK</option>
                                        <option value="D1" @selected($pt==='D1')>D1</option>
                                        <option value="D2" @selected($pt==='D2')>D2</option>
                                        <option value="D3" @selected($pt==='D3')>D3</option>
                                        <option value="D4/Sarjana Terapan" @selected($pt==='D4/Sarjana Terapan')>D4/Sarjana Terapan</option>
                                        <option value="S1" @selected($pt==='S1')>S1</option>
                                        <option value="S2" @selected($pt==='S2')>S2</option>
                                        <option value="S3" @selected($pt==='S3')>S3</option>
                                        <option value="Lainnya" @selected($pt==='Lainnya')>Lainnya</option>
                                    </select>
                                    @error('pendidikan_terakhir')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                    <div id="pendidikan_lainnya_wrap" class="mt-2 hidden">
                                        <input type="text" name="pendidikan_terakhir_lainnya" value="{{ old('pendidikan_terakhir_lainnya') }}" placeholder="Sebutkan pendidikan terakhir" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Gelar</label>
                                    <input type="text" name="gelar" value="{{ old('gelar', $karyawan->gelar ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base" placeholder="Contoh: S.Kep">
                                    @error('gelar')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Kampus</label>
                                    <input type="text" name="kampus" value="{{ old('kampus', $karyawan->kampus ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base" placeholder="Nama universitas/institusi">
                                    @error('kampus')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keluarga -->
                    <div id="keluarga" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-amber-500 to-yellow-500"></span>
                            <h2 class="text-lg font-semibold">Keluarga</h2>
                        </div>
                        <div class="space-y-4">
                            @php
                                $keluargaKeys = ['nama_ibu_kandung'];
                                $keluargaErrors = [];
                                foreach ($keluargaKeys as $k) { foreach ($errors->get($k) as $m) { $keluargaErrors[] = $m; } }
                            @endphp
                            @if(!empty($keluargaErrors))
                                <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                                    <ul class="list-disc ml-5 text-sm">
                                        @foreach($keluargaErrors as $msg)<li>{{ $msg }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Nama Ibu Kandung</label>
                                    <input type="text" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $karyawan->nama_ibu_kandung ?? '') }}" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm sm:text-base">
                                    @error('nama_ibu_kandung')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div id="password" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 rounded bg-gradient-to-b from-gray-500 to-slate-600"></span>
                            <h2 class="text-lg font-semibold text-slate-900">Ubah Password</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Password Baru</label>
                                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 text-sm sm:text-base" placeholder="Masukkan password baru">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-2">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 text-sm sm:text-base" placeholder="Ulangi password baru">
                                </div>
                            </div>
                            @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            <div class="text-sm text-gray-600 space-y-1">
                                <p class="font-medium">Persyaratan Password:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>Minimal 6 karakter</li>
                                    <li>Mengandung minimal 1 huruf besar (A-Z)</li>
                                    <li>Mengandung minimal 1 huruf kecil (a-z)</li>
                                    <li>Mengandung minimal 1 angka (0-9)</li>
                                </ul>
                                <p class="text-xs italic mt-2">Kosongkan jika tidak ingin mengubah password</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="bg-white rounded-xl border shadow-sm p-4 sm:p-6">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors font-medium">
                            Simpan Semua Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Status pegawai dan NIP field toggle
    const selectStatus = document.getElementById('status_pegawai_id');
    const fieldNip = document.getElementById('field-nip');
    function toggleNip(){
        if(!selectStatus){return}
        const txt = selectStatus.options[selectStatus.selectedIndex]?.text || '';
        if(['PNS','PPPK'].includes(txt.trim())){
            fieldNip?.classList.remove('hidden');
        } else {
            fieldNip?.classList.add('hidden');
        }
    }
    selectStatus?.addEventListener('change', toggleNip);
    toggleNip();

    // Smooth scroll + enhanced scrollspy for responsive navigation
    const navLinks = document.querySelectorAll('.js-nav-link');
    const sections = document.querySelectorAll('.section-anchor');
    
    // Smooth scrolling
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const isMobile = window.innerWidth < 1024;
                    const offset = isMobile ? 120 : 100; // More offset for mobile sticky nav
                    const y = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            }
        });
    });

    // Enhanced scrollspy with better mobile support
    const spy = () => {
        let currentId = null;
        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const threshold = window.innerWidth < 1024 ? 150 : 120;
            if (rect.top <= threshold && rect.bottom >= threshold) {
                currentId = section.id;
            }
        });
        
        if (currentId) {
            navLinks.forEach(link => {
                // Reset all states
                link.classList.remove(
                    'bg-slate-900', 'text-white', 'ring-2', 'ring-slate-900',
                    'bg-slate-100', 'text-slate-900', 'ring-slate-200',
                    'bg-indigo-100', 'text-indigo-700', 'border-indigo-300'
                );
                
                if (link.dataset.target === currentId) {
                    if (link.classList.contains('rounded-full')) {
                        // Mobile navigation style
                        link.classList.add('bg-indigo-100', 'text-indigo-700', 'border-indigo-300');
                    } else {
                        // Desktop navigation style
                        link.classList.add('bg-slate-100', 'text-slate-900', 'ring-2', 'ring-slate-900');
                    }
                }
            });
        }
    };
    
    // Throttled scroll listener for better performance
    let scrollTimeout;
    document.addEventListener('scroll', () => {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(spy, 10);
    }, { passive: true });
    
    // Initial spy call
    spy();

    // Pendidikan lainnya toggle
    const selectPt = document.getElementById('pendidikan_terakhir');
    const ptWrap = document.getElementById('pendidikan_lainnya_wrap');
    function togglePt(){
        if (!selectPt || !ptWrap) return;
        if (selectPt.value === 'Lainnya') {
            ptWrap.classList.remove('hidden');
        } else {
            ptWrap.classList.add('hidden');
        }
    }
    selectPt?.addEventListener('change', togglePt);
    togglePt();
    
    // Responsive navigation improvements
    const mobileNav = document.querySelector('.lg\\:hidden nav');
    if (mobileNav) {
        // Auto-scroll active tab into view on mobile
        const scrollActiveIntoView = () => {
            const activeTab = mobileNav.querySelector('.bg-indigo-100');
            if (activeTab) {
                activeTab.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest', 
                    inline: 'center' 
                });
            }
        };
        
        // Scroll active tab into view after navigation updates
        setTimeout(scrollActiveIntoView, 100);
    }

    // Password validation
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
    
    if (passwordInput) {
        const createValidationMessage = () => {
            let msgEl = document.getElementById('password-validation-msg');
            if (!msgEl) {
                msgEl = document.createElement('div');
                msgEl.id = 'password-validation-msg';
                msgEl.className = 'text-xs mt-1 space-y-1';
                passwordInput.parentNode.appendChild(msgEl);
            }
            return msgEl;
        };

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
            const msgEl = createValidationMessage();
            if (passwordInput.value === '') {
                msgEl.innerHTML = '';
                return;
            }

            const allMet = requirements.every(req => req.met);
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
<script src="{{ asset('js/wilayah-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    WilayahSelector.init({
        ids: {
            provinsi: 'provinsi_id_settings',
            kabupaten: 'kabupaten_id_settings',
            kecamatan: 'kecamatan_id_settings',
            kelurahan: 'kelurahan_id_settings',
            detail: 'alamat_detail_settings',
            hidden: 'alamat_settings'
        },
        preselect: {
            provinsi_id: document.getElementById('provinsi_id_settings')?.dataset.selected || '',
            kabupaten_id: document.getElementById('kabupaten_id_settings')?.dataset.selected || '',
            kecamatan_id: document.getElementById('kecamatan_id_settings')?.dataset.selected || '',
            kelurahan_id: document.getElementById('kelurahan_id_settings')?.dataset.selected || ''
        }
    });
});
</script>
@endpush
