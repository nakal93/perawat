@extends('layouts.app')

@section('breadcrumb', 'Lengkapi Profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-xl font-semibold text-slate-900 mb-4">Lengkapi Profil Karyawan</h1>
        <form method="POST" action="{{ route('karyawan.profile.update') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-slate-700">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $karyawan->nik ?? '') }}" maxlength="16" required class="mt-1 w-full border rounded-lg px-3 py-2" />
                <x-input-error :messages="$errors->get('nik')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Status Pegawai</label>
                <select name="status_pegawai_id" id="statusPegawai" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Status</option>
                    @php($statuses = \App\Models\StatusPegawai::all())
                    @foreach($statuses as $s)
                        <option value="{{ $s->id }}" @selected(old('status_pegawai_id', $karyawan->status_pegawai_id ?? null)==$s->id)>{{ $s->nama }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status_pegawai_id')" class="mt-1" />
            </div>

            <div id="nipField" class="hidden">
                <label class="block text-sm text-slate-700">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $karyawan->nip ?? '') }}" maxlength="30" class="mt-1 w-full border rounded-lg px-3 py-2" />
                <p class="text-[11px] text-slate-500 mt-1">Wajib untuk status PNS atau PPPK.</p>
                <x-input-error :messages="$errors->get('nip')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($karyawan->tanggal_lahir) ? \Illuminate\Support\Carbon::parse($karyawan->tanggal_lahir)->format('Y-m-d') : '') }}" required class="mt-1 w-full border rounded-lg px-3 py-2" />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Alamat</label>
                <textarea name="alamat" rows="2" required class="mt-1 w-full border rounded-lg px-3 py-2">{{ old('alamat', $karyawan->alamat ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')==='Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin ?? '')==='Perempuan')>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Ruangan</label>
                <select name="ruangan_id" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r->id }}" @selected(old('ruangan_id', $karyawan->ruangan_id ?? null)==$r->id)>{{ $r->nama_ruangan }} ({{ $r->kode_ruangan }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('ruangan_id')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm text-slate-700">Profesi</label>
                <select name="profesi_id" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Profesi</option>
                    @foreach($profesi as $p)
                        <option value="{{ $p->id }}" @selected(old('profesi_id', $karyawan->profesi_id ?? null)==$p->id)>{{ $p->nama_profesi }} ({{ $p->kode_profesi }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('profesi_id')" class="mt-1" />
            </div>

            <div class="pt-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan Profil</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const select = document.getElementById('statusPegawai');
    const nipField = document.getElementById('nipField');
    function toggle(){
        const text = select.options[select.selectedIndex]?.text || '';
        if(['PNS','PPPK'].includes(text)) { nipField.classList.remove('hidden'); }
        else { nipField.classList.add('hidden'); }
    }
    select.addEventListener('change', toggle);
    toggle();
});
</script>
@endsection
