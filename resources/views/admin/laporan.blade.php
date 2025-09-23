@extends('layouts.app')

@section('breadcrumb', 'Laporan')

@section('content')
<div class="bg-gradient-to-br from-slate-50 to-gray-100 pt-6">
  <div class="w-full px-2 sm:px-4 lg:px-6 pb-10">
    <!-- Filters -->
    <form method="GET" action="{{ route('admin.laporan') }}" class="bg-white rounded border border-slate-200 p-3 sm:p-4 mb-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
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
      <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <div class="flex flex-wrap gap-3">
          <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
            </svg>
            Filter
          </button>
          <a href="{{ route('admin.laporan') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-slate-500 to-slate-600 text-white text-sm font-medium rounded-xl hover:from-slate-600 hover:to-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset
          </a>
        </div>
        <div class="flex flex-wrap gap-2 sm:ml-auto">
          <a href="{{ route('admin.laporan.export-csv', request()->query()) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-medium rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            CSV
          </a>
          <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs font-medium rounded-lg hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Excel
          </a>
          <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707L13.414 3.7a1 1 0 00-.707-.293H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            PDF
          </a>
          <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print
          </a>
        </div>
      </div>
    </form>

    <!-- Quick Stats -->
    <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-6 gap-1 sm:gap-2 mb-4 sm:mb-6">
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

    <!-- Interactive Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-4 mb-4 sm:mb-6">
      <!-- Ruangan Chart -->
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-3 sm:p-4">
        <h3 class="text-base font-semibold text-slate-800 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          Per Ruangan
        </h3>
        <div class="relative" style="height: 200px;">
          <canvas id="ruanganChart"></canvas>
        </div>
      </div>

      <!-- Profesi Chart -->
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-3 sm:p-4">
        <h3 class="text-base font-semibold text-slate-800 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6m8 0V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"></path>
          </svg>
          Per Profesi
        </h3>
        <div class="relative" style="height: 200px;">
          <canvas id="profesiChart"></canvas>
        </div>
      </div>

      <!-- Status Pegawai Chart -->
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-3 sm:p-4">
        <h3 class="text-base font-semibold text-slate-800 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
          </svg>
          Status Pegawai
        </h3>
        <div class="relative" style="height: 200px;">
          <canvas id="statusChart"></canvas>
        </div>
      </div>

      <!-- Gender Chart -->
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-3 sm:p-4">
        <h3 class="text-base font-semibold text-slate-800 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          Jenis Kelamin
        </h3>
        <div class="relative" style="height: 200px;">
          <canvas id="genderChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Data List -->
    <div class="bg-white rounded border border-slate-200 overflow-hidden">
      <div class="px-2 sm:px-3 py-2 border-b border-slate-200 bg-indigo-600">
        <h3 class="text-sm font-semibold text-white">Data Karyawan <span class="text-sm font-normal text-indigo-100">({{ $karyawan->total() }} total)</span></h3>
      </div>

      <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
          <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">No</th>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Identitas</th>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Kontak & Alamat</th>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Unit & Profesi</th>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
              <th class="px-2 sm:px-3 py-2 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-200">
            @forelse($karyawan as $k)
              <tr class="hover:bg-slate-50 align-top">
                <td class="px-2 sm:px-3 py-2 text-sm text-slate-900">{{ ($karyawan->currentPage() - 1) * $karyawan->perPage() + $loop->iteration }}</td>
                <td class="px-2 sm:px-3 py-2 text-sm">
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
                <td colspan="6" class="px-3 sm:px-6 py-12 text-center text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Mobile Cards -->
      <div class="md:hidden divide-y divide-slate-100">
        @forelse($karyawan as $k)
          <details class="group">
            <summary class="px-3 py-3 flex items-center justify-between gap-2 cursor-pointer hover:bg-slate-50">
              <div>
                <div class="font-semibold text-slate-900">{{ $k->user->name ?? '-' }}</div>
                <div class="text-xs text-slate-500">{{ $k->ruangan->nama_ruangan ?? '-' }} • {{ $k->profesi->nama_profesi ?? '-' }}</div>
              </div>
              <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold rounded-full {{ ($k->status_kelengkapan === 'lengkap') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $k->status_kelengkapan === 'lengkap' ? 'Lengkap' : 'Belum Lengkap' }}
              </span>
            </summary>
            <div class="px-3 pb-4 text-sm text-slate-700">
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
          <div class="px-3 sm:px-6 py-12 text-center text-slate-500">Tidak ada karyawan yang sesuai dengan filter.</div>
        @endforelse
      </div>

      @if($karyawan->hasPages())
        <div class="px-2 sm:px-4 py-3 border-t border-slate-200">
          {{ $karyawan->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart colors
    const colors = {
        primary: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#ec4899', '#14b8a6'],
        hover: ['#2563eb', '#7c3aed', '#059669', '#d97706', '#dc2626', '#4f46e5', '#db2777', '#0d9488']
    };

    // Helper function to create chart data
    function createChartData(labels, data, backgroundColor, borderColor) {
        return {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 2,
                hoverBorderWidth: 3
            }]
        };
    }

    // Helper function to create chart options with click handler
    function createChartOptions(title, filterParam, filterValue) {
        return {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.8,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 10
                        },
                        boxWidth: 12
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#f8fafc',
                    bodyColor: '#f8fafc',
                    borderColor: '#475569',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10
                }
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            },
            onClick: (event, activeElements) => {
                if (activeElements.length > 0) {
                    const index = activeElements[0].index;
                    const value = filterValue[index];
                    
                    // Build filter URL
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set(filterParam, value);
                    currentUrl.searchParams.delete('page'); // Reset pagination
                    
                    // Navigate to filtered results
                    window.location.href = currentUrl.toString();
                }
            }
        };
    }

    // Ruangan Chart
    @php
        $ruanganStats = $karyawan->groupBy('ruangan.nama_ruangan')->map->count()->sortDesc()->take(8);
        $ruanganLabels = $ruanganStats->keys()->toArray();
        $ruanganData = $ruanganStats->values()->toArray();
        $ruanganIds = $ruangan->whereIn('nama_ruangan', $ruanganLabels)->pluck('id', 'nama_ruangan')->toArray();
    @endphp
    
    const ruanganChart = new Chart(document.getElementById('ruanganChart'), {
        type: 'doughnut',
        data: createChartData(
            @json($ruanganLabels),
            @json($ruanganData),
            colors.primary,
            colors.hover
        ),
        options: createChartOptions(
            'Per Ruangan',
            'ruangan_id',
            @json(array_values($ruanganIds))
        )
    });

    // Profesi Chart
    @php
        $profesiStats = $karyawan->groupBy('profesi.nama_profesi')->map->count()->sortDesc()->take(8);
        $profesiLabels = $profesiStats->keys()->toArray();
        $profesiData = $profesiStats->values()->toArray();
        $profesiIds = $profesi->whereIn('nama_profesi', $profesiLabels)->pluck('id', 'nama_profesi')->toArray();
    @endphp
    
    const profesiChart = new Chart(document.getElementById('profesiChart'), {
        type: 'bar',
        data: createChartData(
            @json($profesiLabels),
            @json($profesiData),
            colors.primary[1],
            colors.hover[1]
        ),
        options: {
            ...createChartOptions(
                'Per Profesi',
                'profesi_id',
                @json(array_values($profesiIds))
            ),
            aspectRatio: 2,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        maxRotation: 0,
                        font: {
                            size: 9
                        }
                    }
                }
            }
        }
    });

    // Status Pegawai Chart
    @php
        $statusStats = $karyawan->groupBy('statusPegawai.nama')->map->count()->sortDesc();
        $statusLabels = $statusStats->keys()->toArray();
        $statusData = $statusStats->values()->toArray();
        $statusIds = $statusPegawai->whereIn('nama', $statusLabels)->pluck('id', 'nama')->toArray();
    @endphp
    
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: createChartData(
            @json($statusLabels),
            @json($statusData),
            colors.primary.slice(2),
            colors.hover.slice(2)
        ),
        options: createChartOptions(
            'Status Pegawai',
            'status_pegawai_id',
            @json(array_values($statusIds))
        )
    });

    // Gender Chart
    @php
        $genderStats = $karyawan->groupBy('jenis_kelamin')->map->count();
        $genderLabels = $genderStats->keys()->filter()->toArray();
        $genderData = $genderStats->values()->toArray();
    @endphp
    
    const genderChart = new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: createChartData(
            @json($genderLabels),
            @json($genderData),
            ['#ec4899', '#3b82f6'],
            ['#db2777', '#2563eb']
        ),
        options: createChartOptions(
            'Jenis Kelamin',
            'jenis_kelamin',
            @json($genderLabels)
        )
    });
});
</script>
@endpush

@endsection
