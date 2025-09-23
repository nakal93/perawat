@extends('layouts.app')

@section('breadcrumb', 'Laporan')

@section('content')
<div class="bg-gradient-to-br from-slate-50 to-gray-100 pt-6">
  <div class="w-full px-6 pb-10">
    <!-- Filters -->
    <form method="GET" action="{{ route('admin.laporan') }}" class="bg-white rounded border border-slate-200 p-4 mb-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Unit (Ruangan)</label>
          <select name="ruangan_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Semua Ruangan</option>
            @foreach($ruangan as $r)
              <option value="{{ $r->id }}" {{ (string)request('ruangan_id') === (string)$r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Profesi</label>
          <select name="profesi_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Semua Profesi</option>
            @foreach($profesi as $p)
              <option value="{{ $p->id }}" {{ (string)request('profesi_id') === (string)$p->id ? 'selected' : '' }}>{{ $p->nama_profesi }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status Pegawai</label>
          <select name="status_pegawai_id" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            @foreach($statusPegawai as $s)
              <option value="{{ $s->id }}" {{ (string)request('status_pegawai_id') === (string)$s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status Kelengkapan</label>
          <select name="status_kelengkapan" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Semua</option>
            <option value="lengkap" {{ request('status_kelengkapan')==='lengkap' ? 'selected' : '' }}>Data Diri Lengkap</option>
            <option value="belum_lengkap" {{ request('status_kelengkapan')==='belum_lengkap' ? 'selected' : '' }}>Data Diri Belum Lengkap</option>
            <option value="dokumen_lengkap" {{ request('status_kelengkapan')==='dokumen_lengkap' ? 'selected' : '' }}>Dokumen Wajib Lengkap</option>
            <option value="dokumen_belum_lengkap" {{ request('status_kelengkapan')==='dokumen_belum_lengkap' ? 'selected' : '' }}>Dokumen Wajib Belum Lengkap</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Semua</option>
            <option value="Laki-laki" {{ request('jenis_kelamin')==='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ request('jenis_kelamin')==='Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Masuk (Dari - Sampai)</label>
          <div class="grid grid-cols-2 gap-2">
            <input type="date" name="tanggal_masuk_from" value="{{ request('tanggal_masuk_from') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <input type="date" name="tanggal_masuk_to" value="{{ request('tanggal_masuk_to') }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
          </div>
        </div>
        <div class="md:col-span-3">
          <label class="block text-sm font-medium text-slate-700 mb-2">Pencarian</label>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="NIK, NIP, atau Nama..." class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>
      </div>
      <div class="mt-4 flex flex-wrap items-center gap-3">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Filter</button>
        <a href="{{ route('admin.laporan') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600">Reset</a>
        <div class="ml-auto flex items-center gap-3">
          <a href="{{ route('admin.laporan.export-csv', request()->query()) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Unduh CSV</a>
          <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Unduh Excel</a>
          <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Unduh PDF</a>
          <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cetak F4</a>
        </div>
      </div>
    </form>

    <!-- Quick Stats -->
    <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-6 gap-2 mb-4">
      <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
        <div class="text-xs text-slate-500">Total Karyawan</div>
        <div class="text-lg font-bold text-blue-600">{{ $karyawan->total() }}</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
        @php $lengkapCount = $karyawan->where('status_kelengkapan','lengkap')->count(); @endphp
        <div class="text-xs text-slate-500">Data Diri Lengkap</div>
        <div class="text-lg font-bold text-green-600">{{ $lengkapCount }}</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-2">
        <div class="text-xs text-slate-500">Data Diri Kurang</div>
        <div class="text-lg font-bold text-yellow-600">{{ $karyawan->total() - $lengkapCount }}</div>
      </div>
    </div>

    <!-- Data List -->
    <div class="bg-white rounded border border-slate-200 overflow-hidden">
      <div class="px-3 py-2 border-b border-slate-200 bg-indigo-600">
        <h3 class="text-sm font-semibold text-white">Data Karyawan <span class="text-sm font-normal text-indigo-100">({{ $karyawan->total() }} total)</span></h3>
      </div>

      <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
          <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">No</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Identitas</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Kontak & Alamat</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Unit & Profesi</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-200">
            @forelse($karyawan as $k)
              <tr class="hover:bg-slate-50 align-top">
                <td class="px-3 py-2 text-sm text-slate-900">{{ ($karyawan->currentPage() - 1) * $karyawan->perPage() + $loop->iteration }}</td>
                <td class="px-3 py-2 text-sm">
                  <div class="text-slate-900 font-medium">{{ $k->user->name ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">NIK: {{ $k->nik ?: '-' }}</div>
                  <div class="text-slate-500 text-xs">NIP: {{ $k->nip ?: '-' }}</div>
                  <div class="text-slate-500 text-xs">JK: {{ $k->jenis_kelamin ?: '-' }}</div>
                  <div class="text-slate-500 text-xs">Tgl Lahir: {{ $k->tanggal_lahir ? (method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : $k->tanggal_lahir) : '-' }}</div>
                </td>
                <td class="px-3 py-2 text-sm">
                  <div class="text-slate-900">Email: {{ $k->user->email ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">HP: {{ $k->no_hp ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Provinsi: {{ $k->provinsi->name ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Kab/Kota: {{ $k->kabupaten->name ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Kec: {{ $k->kecamatan->name ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Kel: {{ $k->kelurahan->name ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Alamat: {{ $k->alamat_detail ?? '-' }}</div>
                </td>
                <td class="px-3 py-2 text-sm">
                  <div class="text-slate-900">Ruangan: {{ $k->ruangan->nama_ruangan ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Profesi: {{ $k->profesi->nama_profesi ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Agama: {{ $k->agama ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Pendidikan: {{ $k->pendidikan_terakhir ?? '-' }}</div>
                  <div class="text-slate-500 text-xs">Tgl Masuk: {{ $k->tanggal_masuk_kerja ? (method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : $k->tanggal_masuk_kerja) : '-' }}</div>
                  <div class="text-slate-500 text-xs">Dokumen: {{ $k->dokumen_count ?? 0 }}</div>
                  <div class="text-slate-500 text-xs">Status Pegawai: {{ $k->statusPegawai->nama ?? '-' }}</div>
                </td>
                <td class="px-3 py-2 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ ($k->status_kelengkapan === 'lengkap') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $k->status_kelengkapan === 'lengkap' ? 'Lengkap' : 'Belum Lengkap' }}
                  </span>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">
                  <div class="flex gap-2">
                    <a href="{{ route('qr.show', $k->id) }}" class="px-3 py-1 rounded-md bg-slate-100 text-slate-700 hover:bg-slate-200">QR</a>
                    <a href="{{ route('admin.laporan.print', array_merge(request()->query(), ['search' => $k->user->name ?? $k->nik])) }}" target="_blank" class="px-3 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700">Cetak</a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-12 text-center text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Mobile Cards -->
      <div class="md:hidden divide-y divide-slate-100">
        @forelse($karyawan as $k)
          <details class="group">
            <summary class="px-4 py-3 flex items-center justify-between gap-2 cursor-pointer hover:bg-slate-50">
              <div>
                <div class="font-semibold text-slate-900">{{ $k->user->name ?? '-' }}</div>
                <div class="text-xs text-slate-500">{{ $k->ruangan->nama_ruangan ?? '-' }} • {{ $k->profesi->nama_profesi ?? '-' }}</div>
              </div>
              <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold rounded-full {{ ($k->status_kelengkapan === 'lengkap') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $k->status_kelengkapan === 'lengkap' ? 'Lengkap' : 'Belum Lengkap' }}
              </span>
            </summary>
            <div class="px-4 pb-4 text-sm text-slate-700">
              <div class="grid grid-cols-1 gap-2">
                <div class="bg-slate-50 rounded-lg p-3">
                  <div class="text-slate-900 font-medium mb-1">Identitas</div>
                  <div>NIK: {{ $k->nik ?: '-' }}</div>
                  <div>NIP: {{ $k->nip ?: '-' }}</div>
                  <div>JK: {{ $k->jenis_kelamin ?: '-' }}</div>
                  <div>Tgl Lahir: {{ $k->tanggal_lahir ? (method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : $k->tanggal_lahir) : '-' }}</div>
                </div>
                <div class="bg-slate-50 rounded-lg p-3">
                  <div class="text-slate-900 font-medium mb-1">Kontak & Alamat</div>
                  <div>Email: {{ $k->user->email ?? '-' }}</div>
                  <div>HP: {{ $k->no_hp ?? '-' }}</div>
                  <div>Provinsi: {{ $k->provinsi->name ?? '-' }}</div>
                  <div>Kab/Kota: {{ $k->kabupaten->name ?? '-' }}</div>
                  <div>Kec: {{ $k->kecamatan->name ?? '-' }}</div>
                  <div>Kel: {{ $k->kelurahan->name ?? '-' }}</div>
                  <div>Alamat: {{ $k->alamat_detail ?? '-' }}</div>
                </div>
                <div class="bg-slate-50 rounded-lg p-3">
                  <div class="text-slate-900 font-medium mb-1">Unit & Profesi</div>
                  <div>Ruangan: {{ $k->ruangan->nama_ruangan ?? '-' }}</div>
                  <div>Profesi: {{ $k->profesi->nama_profesi ?? '-' }}</div>
                  <div>Agama: {{ $k->agama ?? '-' }}</div>
                  <div>Pendidikan: {{ $k->pendidikan_terakhir ?? '-' }}</div>
                  <div>Tgl Masuk: {{ $k->tanggal_masuk_kerja ? (method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : $k->tanggal_masuk_kerja) : '-' }}</div>
                  <div>Dokumen: {{ $k->dokumen_count ?? 0 }}</div>
                  <div>Status Pegawai: {{ $k->statusPegawai->nama ?? '-' }}</div>
                </div>
              </div>
              <div class="mt-3 flex gap-2">
                <a href="{{ route('qr.show', $k->id) }}" class="px-3 py-1 rounded-md bg-slate-100 text-slate-700">QR</a>
                <a href="{{ route('admin.laporan.print', array_merge(request()->query(), ['search' => $k->user->name ?? $k->nik])) }}" target="_blank" class="px-3 py-1 rounded-md bg-blue-600 text-white">Cetak</a>
              </div>
            </div>
          </details>
        @empty
          <div class="px-6 py-12 text-center text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</div>
        @endforelse
      </div>

      @if($karyawan->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
          {{ $karyawan->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
