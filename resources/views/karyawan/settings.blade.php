@extends('layouts.app')

@section('breadcrumb', 'Pengaturan Akun')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Settings menu -->
        <aside class="lg:col-span-3">
            <div class="bg-white rounded-xl border shadow-sm p-4 sticky top-24 hidden lg:block">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">Pengaturan</h3>
                <nav class="space-y-1 text-sm">
                    <a href="#akun" data-target="akun" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Akun</a>
                    <a href="#identitas" data-target="identitas" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Identitas</a>
                    <a href="#kepegawaian" data-target="kepegawaian" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Kepegawaian</a>
                    <a href="#kontak" data-target="kontak" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Kontak</a>
                    <a href="#pendidikan" data-target="pendidikan" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Pendidikan</a>
                    <a href="#keluarga" data-target="keluarga" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Keluarga</a>
                    <a href="#password" data-target="password" class="js-nav-link block px-3 py-2 rounded-lg hover:bg-slate-50 text-slate-600">Kata Sandi</a>
                </nav>
            </div>
        </aside>

        <!-- Settings content -->
    <div class="lg:col-span-9 space-y-8">
        <!-- Mobile tabs nav -->
    <div class="lg:hidden bg-white rounded-xl border shadow-sm p-2 sticky top-0 z-20">
            <nav class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                @php $tabs = ['akun'=>'Akun','identitas'=>'Identitas','kepegawaian'=>'Kepegawaian','kontak'=>'Kontak','pendidikan'=>'Pendidikan','keluarga'=>'Keluarga','password'=>'Kata Sandi']; @endphp
                @foreach($tabs as $id=>$label)
            <a href="#{{ $id }}" data-target="{{ $id }}" class="js-nav-link whitespace-nowrap px-3 py-2 text-sm rounded-full bg-slate-50 text-slate-700 hover:bg-slate-100">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
        @if(session('success'))
            <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

    <div id="akun" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 rounded bg-gradient-to-b from-blue-500 to-indigo-600"></span>
                <h2 class="text-lg font-semibold text-slate-900">Akun</h2>
            </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PATCH')
                @php
                    $akunErrorKeys = ['name','email','foto_profil'];
                    $akunErrors = [];
                    foreach ($akunErrorKeys as $k) { foreach ($errors->get($k) as $m) { $akunErrors[] = $m; } }
                @endphp
                @if(!empty($akunErrors))
                    <div class="p-3 border border-red-200 bg-red-50 text-red-700 rounded"> 
                        <ul class="list-disc ml-5 text-sm">
                            @foreach($akunErrors as $msg)<li>{{ $msg }}</li>@endforeach
                        </ul>
                    </div>
                @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Foto Profil</label>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5">
                        <div class="rounded-full overflow-hidden bg-slate-100 ring-2 ring-slate-200 w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-36 lg:h-36">
                            @if($karyawan && $karyawan->foto_profil)
                                <img src="{{ '/storage/'.ltrim($karyawan->foto_profil,'/') }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Tidak ada foto</div>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <input type="file" name="foto_profil" accept="image/png, image/jpeg" class="block text-sm">
                            <p class="text-xs text-slate-500">Disarankan JPG atau PNG, ukuran maks 2MB.</p>
                        </div>
                    </div>
                    @error('foto_profil')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="pt-2">
                    <button class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Simpan</button>
                </div>
            </form>
        </div>

    <div id="identitas" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 rounded bg-gradient-to-b from-teal-500 to-emerald-600"></span>
                <h2 class="text-lg font-semibold">Identitas</h2>
            </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
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
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $karyawan->nik ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('nik')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div id="field-nip" class="hidden">
                        <label class="block text-sm text-slate-600 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $karyawan->nip ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('nip')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('tanggal_lahir')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">- Pilih -</option>
                            <option value="Laki-laki" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')=='Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')=='Perempuan')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Golongan Darah</label>
                        <select name="golongan_darah" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @php $gd = old('golongan_darah', $karyawan->golongan_darah ?? ''); @endphp
                            <option value="">- Pilih -</option>
                            <option value="NA" @selected($gd==='NA')>Tidak tahu</option>
                            <option value="A" @selected($gd==='A')>A</option>
                            <option value="B" @selected($gd==='B')>B</option>
                            <option value="AB" @selected($gd==='AB')>AB</option>
                            <option value="O" @selected($gd==='O')>O</option>
                        </select>
                        @error('golongan_darah')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <fieldset class="md:col-span-1 lg:col-span-1">
                        <label class="block text-sm text-slate-600 mb-1">Alamat Domisili</label>
                        <div class="grid grid-cols-2 lg:grid-cols-2 gap-2">
                            <select id="provinsi_id_settings" name="provinsi_id" class="border rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500" data-selected="{{ old('provinsi_id', $karyawan->provinsi_id ?? '') }}">
                                <option value="">Provinsi</option>
                            </select>
                            <select id="kabupaten_id_settings" name="kabupaten_id" class="border rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500" disabled data-selected="{{ old('kabupaten_id', $karyawan->kabupaten_id ?? '') }}">
                                <option value="">Kab/Kota</option>
                            </select>
                            <select id="kecamatan_id_settings" name="kecamatan_id" class="border rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500" disabled data-selected="{{ old('kecamatan_id', $karyawan->kecamatan_id ?? '') }}">
                                <option value="">Kecamatan</option>
                            </select>
                            <select id="kelurahan_id_settings" name="kelurahan_id" class="border rounded-lg h-10 px-2 focus:outline-none focus:ring-2 focus:ring-teal-500" disabled data-selected="{{ old('kelurahan_id', $karyawan->kelurahan_id ?? '') }}">
                                <option value="">Kelurahan</option>
                            </select>
                        </div>
                        <textarea id="alamat_detail_settings" name="alamat_detail" rows="2" class="w-full mt-2 border rounded-lg px-2 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none" placeholder="Detail (Jl, RT/RW, patokan)">{{ old('alamat_detail', $karyawan->alamat_detail ?? '') }}</textarea>
                        <input type="hidden" name="alamat" id="alamat_settings" value="{{ old('alamat', $karyawan->alamat ?? '') }}">
                        @error('alamat')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </fieldset>
                </div>
                <div class="pt-3">
                    <button aria-label="Simpan Identitas" class="w-full sm:w-auto px-6 py-3 text-base font-semibold rounded-lg shadow-lg border border-emerald-800 text-white bg-emerald-800 hover:bg-emerald-900 focus:outline-none focus:ring-4 focus:ring-emerald-500 focus:ring-offset-2" style="background-color:#065f46;color:#fff;border-color:#064e3b;">
                        Simpan Identitas
                    </button>
                </div>
            </form>
        </div>

    <div id="kepegawaian" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 rounded bg-gradient-to-b from-purple-500 to-fuchsia-600"></span>
                <h2 class="text-lg font-semibold">Kepegawaian</h2>
            </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
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
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Status Pegawai</label>
                        <select name="status_pegawai_id" id="status_pegawai_id" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">- Pilih -</option>
                            @foreach(\App\Models\StatusPegawai::orderBy('nama')->get() as $st)
                                <option value="{{ $st->id }}" @selected(old('status_pegawai_id', $karyawan->status_pegawai_id ?? '')==$st->id)>{{ $st->nama }}</option>
                            @endforeach
                        </select>
                        @error('status_pegawai_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Tanggal Masuk Kerja</label>
            <input type="date" name="tanggal_masuk_kerja" value="{{ old('tanggal_masuk_kerja', $karyawan->tanggal_masuk_kerja ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('tanggal_masuk_kerja')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Profesi</label>
            <select name="profesi_id" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">- Pilih -</option>
                            @foreach(\App\Models\Profesi::orderBy('nama_profesi')->get() as $p)
                                <option value="{{ $p->id }}" @selected(old('profesi_id', $karyawan->profesi_id ?? '')==$p->id)>{{ $p->nama_profesi }}</option>
                            @endforeach
                        </select>
                        @error('profesi_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Ruangan</label>
            <select name="ruangan_id" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">- Pilih -</option>
                            @foreach(\App\Models\Ruangan::orderBy('nama_ruangan')->get() as $r)
                <option value="{{ $r->id }}" @selected(old('ruangan_id', $karyawan->ruangan_id ?? '')==$r->id)>{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Agama</label>
                        @php $ag = old('agama', $karyawan->agama ?? ''); @endphp
                        <select name="agama" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">- Pilih -</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $opt)
                                <option value="{{ $opt }}" @selected($ag===$opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('agama')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">Status Perkawinan</label>
                        @php $sp = old('status_perkawinan', $karyawan->status_perkawinan ?? ''); @endphp
                        <select name="status_perkawinan" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">- Pilih -</option>
                            <option value="Belum" @selected($sp==='Belum')>Belum Menikah</option>
                            <option value="Menikah" @selected($sp==='Menikah')>Menikah</option>
                            <option value="Cerai" @selected($sp==='Cerai')>Cerai</option>
                        </select>
                        @error('status_perkawinan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="pt-3">
                    <button aria-label="Simpan Kepegawaian" class="w-full sm:w-auto px-6 py-3 text-base font-semibold rounded-lg shadow-lg border border-fuchsia-800 text-white bg-fuchsia-800 hover:bg-fuchsia-900 focus:outline-none focus:ring-4 focus:ring-fuchsia-500 focus:ring-offset-2" style="background-color:#701a75;color:#fff;border-color:#4a044e;">
                        Simpan Kepegawaian
                    </button>
                </div>
            </form>
        </div>

    <div id="kontak" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
        <div class="flex items-center gap-2 mb-4">
        <span class="w-1.5 h-6 rounded bg-gradient-to-b from-rose-500 to-orange-500"></span>
        <h2 class="text-lg font-semibold">Kontak</h2>
        </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
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
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-1">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                        @error('no_hp')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="pt-2"><button class="w-full sm:w-auto px-6 py-3 bg-rose-600 text-white rounded-lg shadow-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">Simpan Kontak</button></div>
            </form>
        </div>

    <div id="pendidikan" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 rounded bg-gradient-to-b from-cyan-500 to-sky-500"></span>
                <h2 class="text-lg font-semibold">Pendidikan</h2>
            </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
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
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm text-slate-600 mb-1">Pendidikan Terakhir</label>
                        @php $pt = old('pendidikan_terakhir', $karyawan->pendidikan_terakhir ?? ''); @endphp
                        <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
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
                            <input type="text" name="pendidikan_terakhir_lainnya" value="{{ old('pendidikan_terakhir_lainnya') }}" placeholder="Sebutkan pendidikan terakhir" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm text-slate-600 mb-1">Gelar</label>
                        <input type="text" name="gelar" value="{{ old('gelar', $karyawan->gelar ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        @error('gelar')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm text-slate-600 mb-1">Kampus</label>
                        <input type="text" name="kampus" value="{{ old('kampus', $karyawan->kampus ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        @error('kampus')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="pt-3">
                    <button aria-label="Simpan Pendidikan" class="w-full sm:w-auto px-6 py-3 text-base font-semibold rounded-lg shadow-lg border border-sky-800 text-white bg-sky-800 hover:bg-sky-900 focus:outline-none focus:ring-4 focus:ring-sky-500 focus:ring-offset-2" style="background-color:#075985;color:#fff;border-color:#0c4a6e;">
                        Simpan Pendidikan
                    </button>
                </div>
            </form>
        </div>

    <div id="keluarga" class="section-anchor scroll-mt-24 bg-white rounded-xl border shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 rounded bg-gradient-to-b from-amber-500 to-yellow-500"></span>
                <h2 class="text-lg font-semibold">Keluarga</h2>
            </div>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm text-slate-600 mb-1">Nama Ibu Kandung</label>
            <input type="text" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $karyawan->nama_ibu_kandung ?? '') }}" class="w-full border rounded-lg h-10 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('nama_ibu_kandung')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="pt-2"><button class="w-full sm:w-auto px-6 py-3 bg-amber-600 text-white rounded-lg shadow-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">Simpan Keluarga</button></div>
            </form>
        </div>

    <div id="password" class="bg-white rounded-xl border shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Ubah Password</h2>
            <form action="{{ route('karyawan.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm text-slate-600 mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border rounded-lg h-10 px-3">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm text-slate-600 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded-lg h-10 px-3">
                    </div>
                </div>
                @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        <div class="pt-2">
            <button class="w-full sm:w-auto px-6 py-3 bg-slate-800 text-white rounded-lg shadow-md hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600">Update Password</button>
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

    // Smooth scroll + scrollspy active nav
    const navLinks = document.querySelectorAll('.js-nav-link');
    navLinks.forEach(a => {
        a.addEventListener('click', (e) => {
            // smooth scrolling behavior
            const href = a.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const y = target.getBoundingClientRect().top + window.pageYOffset - 80; // offset for sticky nav
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            }
        });
    });

    const sections = document.querySelectorAll('.section-anchor');
    const spy = () => {
        let currentId = null;
        sections.forEach(sec => {
            const rect = sec.getBoundingClientRect();
            if (rect.top <= 120 && rect.bottom >= 120) {
                currentId = sec.id;
            }
        });
        if (currentId) {
            navLinks.forEach(a => {
                a.classList.remove('bg-slate-900','text-white','ring-2','ring-slate-900','bg-slate-100','text-slate-900','ring-slate-200');
                if (a.dataset.target === currentId) {
                    // Desktop links rectangular, Mobile rounded-full both get clear contrast
                    if (a.classList.contains('rounded-full')) {
                        a.classList.add('bg-slate-900','text-white');
                    } else {
                        a.classList.add('bg-slate-100','text-slate-900','ring-2','ring-slate-900');
                    }
                }
            });
        }
    };
    document.addEventListener('scroll', spy, { passive: true });
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
