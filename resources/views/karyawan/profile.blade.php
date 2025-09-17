@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $fotoUrl = ($karyawan && $karyawan->foto_profil) ? '/storage/'.ltrim($karyawan->foto_profil,'/') : null;
@endphp
<div class="min-h-screen bg-gray-50">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Profil Karyawan</h2>
                    <p class="text-sm text-gray-600">Lengkapi seluruh form di bawah ini, lalu klik Simpan untuk menyempurnakan data.</p>
                </div>
                <div class="flex items-center gap-3">
                    @php $status = auth()->user()->status; @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $status==='active' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : ($status==='approved' ? 'bg-blue-50 border border-blue-200 text-blue-700' : 'bg-amber-50 border border-amber-200 text-amber-700') }}">
                        Status: {{ ucfirst($status) }}
                    </span>
                </div>
            </div>
        </div>

    @php($isComplete = ($karyawan->status_kelengkapan === 'lengkap'))
    <!-- Profile Header Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="pt-6 pb-8 px-6 sm:pt-8 sm:pb-10 sm:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center gap-10">
                    <div class="relative w-24 h-24 lg:w-32 lg:h-32 shrink-0 mx-auto lg:mx-0 order-1 mb-6 sm:mb-6 lg:mb-0">
                        <div class="w-full h-full rounded-xl border-2 border-gray-100 bg-gray-50 overflow-hidden flex items-center justify-center">
                            @if($fotoUrl)
                                <img src="{{ $fotoUrl }}" alt="Foto Profil" class="w-full h-full object-cover" onclick="openImageModal('{{ $fotoUrl }}', 'Foto Profil - {{ auth()->user()->name }}')">
                            @else
                                <svg class="w-8 h-8 lg:w-10 lg:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center border-2 border-white">
                            <svg class="w-3 h-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0L4 11.414a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 text-center lg:text-left lg:max-w-3xl order-2 border-t border-gray-200 pt-5 mt-8 lg:border-0 lg:pt-0 lg:mt-0">
                        <h1 class="text-2xl lg:text-3xl font-semibold text-gray-900 mb-2">{{ $karyawan->gelar ? auth()->user()->name . ' ' . $karyawan->gelar : auth()->user()->name }}</h1>
                        <p class="text-gray-600 mb-4 text-sm lg:text-base">{{ auth()->user()->email }}</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-2">
                            @if($karyawan->statusPegawai)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">{{ $karyawan->statusPegawai->nama }}</span>
                            @endif
                            @if($karyawan->profesi)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">{{ $karyawan->profesi->nama_profesi }}</span>
                            @endif
                            @if($karyawan->ruangan)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">{{ $karyawan->ruangan->nama_ruangan }}</span>
                            @endif
                        </div>
                        <!-- Mobile-only Edit button -->
                        <div class="mt-4 lg:hidden">
                            <a href="{{ route('karyawan.settings') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h6m2-13v4m4-4v8a2 2 0 01-2 2H9m10-2v-4a2 2 0 00-2-2h-4m6 4v2"/>
                                </svg>
                                Edit Profil
                            </a>
                            <p class="text-xs text-gray-500 mt-2 text-center">Perbarui data kapan saja</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex flex-col gap-3 items-center lg:items-end order-3">
                        <a href="{{ route('karyawan.settings') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h6m2-13v4m4-4v8a2 2 0 01-2 2H9m10-2v-4a2 2 0 00-2-2h-4m6 4v2"/>
                            </svg>
                            Edit Profil
                        </a>
                        <p class="text-xs text-gray-500">Perbarui data kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    @if($isComplete)
    <!-- Data Sections Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-6">
            <!-- Left Column -->
            <div class="space-y-8">
                <!-- Identitas Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Identitas Pribadi</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php($fieldsIdentitas = [
                            ['label' => 'NIK', 'value' => $karyawan->nik ?? '-'],
                            ['label' => 'NIP', 'value' => $karyawan->nip ?? '-'],
                            ['label' => 'Jenis Kelamin', 'value' => $karyawan->jenis_kelamin ?? '-'],
                            ['label' => 'Tanggal Lahir', 'value' => $karyawan->tanggal_lahir ? \Illuminate\Support\Carbon::parse($karyawan->tanggal_lahir)->format('d M Y') : '-'],
                            ['label' => 'Golongan Darah', 'value' => $karyawan->golongan_darah ?? '-'],
                            ['label' => 'Status Perkawinan', 'value' => $karyawan->status_perkawinan ?? '-'],
                        ])
                        @foreach($fieldsIdentitas as $f)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">{{ $f['label'] }}</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $f['value'] }}</dd>
                            </div>
                        @endforeach
                        <div class="sm:col-span-2 p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Alamat Domisili</dt>
                            @if($karyawan->kelurahan && $karyawan->kecamatan && $karyawan->kabupaten && $karyawan->provinsi)
                                <dd class="space-y-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $karyawan->alamat_detail ?? $karyawan->alamat }}</p>
                                    <p class="text-xs text-gray-600">{{ $karyawan->kelurahan->name }}, {{ $karyawan->kecamatan->name }}, {{ $karyawan->kabupaten->type }} {{ $karyawan->kabupaten->name }}, {{ $karyawan->provinsi->name }} {{ $karyawan->kelurahan->pos_code }}</p>
                                </dd>
                            @else
                                <dd class="text-sm font-semibold text-gray-900">{{ $karyawan->alamat ?? '-' }}</dd>
                            @endif
                        </div>

                <!-- Kontak Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php($fieldsKontak = [
                            ['label' => 'Email', 'value' => auth()->user()->email],
                            ['label' => 'No HP', 'value' => $karyawan->no_hp ?? '-'],
                        ])
                        @foreach($fieldsKontak as $f)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">{{ $f['label'] }}</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $f['value'] }}</dd>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Keluarga Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Keluarga</h3>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Nama Ibu Kandung</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ $karyawan->nama_ibu_kandung ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Kepegawaian Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Data Kepegawaian</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php($fieldsPegawai = [
                            ['label' => 'Status Pegawai', 'value' => $karyawan->statusPegawai->nama ?? '-'],
                            ['label' => 'Tanggal Masuk Kerja', 'value' => $karyawan->tanggal_masuk_kerja ? \Illuminate\Support\Carbon::parse($karyawan->tanggal_masuk_kerja)->format('d M Y') : '-'],
                            ['label' => 'Ruangan', 'value' => $karyawan->ruangan->nama_ruangan ?? '-'],
                            ['label' => 'Profesi', 'value' => $karyawan->profesi->nama_profesi ?? '-'],
                            ['label' => 'Agama', 'value' => $karyawan->agama ?? '-'],
                        ])
                        @foreach($fieldsPegawai as $f)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">{{ $f['label'] }}</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $f['value'] }}</dd>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pendidikan Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pendidikan</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        @php($fieldsPendidikan = [
                            ['label' => 'Pendidikan Terakhir', 'value' => $karyawan->pendidikan_terakhir ?? '-'],
                            ['label' => 'Gelar', 'value' => $karyawan->gelar ?? '-'],
                            ['label' => 'Kampus', 'value' => $karyawan->kampus ?? '-'],
                        ])
                        @foreach($fieldsPendidikan as $f)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">{{ $f['label'] }}</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $f['value'] }}</dd>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sistem Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Sistem & Keamanan</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php($fieldsSystem = [
                            ['label' => 'Status Akun', 'value' => ucfirst(auth()->user()->status)],
                            ['label' => 'Tahap Kelengkapan', 'value' => strtoupper($karyawan->status_kelengkapan ?? '-')],
                        ])
                        @foreach($fieldsSystem as $f)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">{{ $f['label'] }}</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $f['value'] }}</dd>
                            </div>
                        @endforeach
                        <div class="sm:col-span-2 p-4 rounded-lg bg-gray-50 border border-gray-100 hover:bg-gray-100 transition-colors">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Token QR</dt>
                            <dd class="font-mono text-xs bg-gray-200 rounded px-3 py-2 text-gray-700 select-all break-all">{{ $karyawan->qr_token }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Dokumen Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Dokumen Karyawan</h3>
                        <p class="text-sm text-gray-600">Kelola dan unggah dokumen persyaratan</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dokumen.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Dokumen
                    </a>
                    <a href="{{ route('dokumen.create') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Upload Dokumen
                    </a>
                </div>
            </div>

            <!-- QR Code Card -->
            @if(auth()->user()->status === 'active')
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">QR Code Karyawan</h3>
                            <p class="text-sm text-gray-600">Download untuk verifikasi identitas</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('qr.download', 'png') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            PNG
                        </a>
                        <a href="{{ route('qr.download', 'svg') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            SVG
                        </a>
                    </div>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg flex items-center justify-center">
                        @if($qrcode)
                            {!! $qrcode !!}
                        @else
                            <div class="text-gray-500 text-sm">QR Code tidak tersedia</div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @else
        <!-- Form lengkapi profil (ditampilkan hanya jika belum lengkap) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Lengkapi Profil Anda</h3>
                <p class="text-sm text-gray-600">Isi seluruh field wajib bertanda * untuk mengaktifkan akun. Setelah disimpan, tampilan akan berubah menjadi ringkasan.</p>
            </div>
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
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik', $karyawan->nik) }}" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nik')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP (Opsional)</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $karyawan->nip) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nip')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" @selected($karyawan->jenis_kelamin==='Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected($karyawan->jenis_kelamin==='Perempuan')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_lahir')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Golongan Darah -->
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tidak tahu</option>
                            @foreach(['A','B','AB','O'] as $g)
                                <option value="{{ $g }}" @selected($karyawan->golongan_darah===$g)> {{ $g }} </option>
                            @endforeach
                        </select>
                        @error('golongan_darah')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Status Perkawinan -->
                    <div>
                        <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            <option value="Belum Kawin" @selected($karyawan->status_perkawinan==='Belum Kawin')>Belum Kawin</option>
                            <option value="Kawin" @selected($karyawan->status_perkawinan==='Kawin')>Kawin</option>
                            <option value="Cerai Hidup" @selected($karyawan->status_perkawinan==='Cerai Hidup')>Cerai Hidup</option>
                            <option value="Cerai Mati" @selected($karyawan->status_perkawinan==='Cerai Mati')>Cerai Mati</option>
                        </select>
                        @error('status_perkawinan')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0812...">
                        @error('no_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nama Ibu Kandung -->
                    <div>
                        <label for="nama_ibu_kandung" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu Kandung</label>
                        <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $karyawan->nama_ibu_kandung) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_ibu_kandung')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Alamat Detail & Wilayah -->
                    <div class="sm:col-span-2 space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Alamat Domisili</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            <select id="provinsi_id" name="provinsi_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('provinsi_id', $karyawan->provinsi_id) }}">
                                <option value="">Provinsi</option>
                            </select>
                            <select id="kabupaten_id" name="kabupaten_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kabupaten_id', $karyawan->kabupaten_id) }}" disabled>
                                <option value="">Kab/Kota</option>
                            </select>
                            <select id="kecamatan_id" name="kecamatan_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kecamatan_id', $karyawan->kecamatan_id) }}" disabled>
                                <option value="">Kecamatan</option>
                            </select>
                            <select id="kelurahan_id" name="kelurahan_id" class="rounded-lg border-gray-300 h-10 text-sm" data-selected="{{ old('kelurahan_id', $karyawan->kelurahan_id) }}" disabled>
                                <option value="">Kelurahan</option>
                            </select>
                        </div>
                        <textarea id="alamat_detail" name="alamat_detail" rows="2" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Detail (RT/RW, Jalan, Blok)">{{ old('alamat_detail', $karyawan->alamat_detail) }}</textarea>
                        <div id="alamat_preview" class="text-xs"></div>
                        <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat', $karyawan->alamat) }}">
                        @error('alamat')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kepegawaian: Status, Ruangan, Profesi, Tgl Masuk -->
                    <div>
                        <label for="status_pegawai_id" class="block text-sm font-medium text-gray-700 mb-2">Status Pegawai</label>
                        <select name="status_pegawai_id" id="status_pegawai_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            @foreach(\App\Models\StatusPegawai::orderBy('nama')->get() as $st)
                                <option value="{{ $st->id }}" @selected($karyawan->status_pegawai_id==$st->id)>{{ $st->nama }}</option>
                            @endforeach
                        </select>
                        @error('status_pegawai_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="ruangan_id" class="block text-sm font-medium text-gray-700 mb-2">Ruangan</label>
                        <select name="ruangan_id" id="ruangan_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            @foreach(\App\Models\Ruangan::orderBy('nama_ruangan')->get() as $r)
                                <option value="{{ $r->id }}" @selected($karyawan->ruangan_id==$r->id)>{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="profesi_id" class="block text-sm font-medium text-gray-700 mb-2">Profesi</label>
                        <select name="profesi_id" id="profesi_id" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih</option>
                            @foreach(\App\Models\Profesi::orderBy('nama_profesi')->get() as $p)
                                <option value="{{ $p->id }}" @selected($karyawan->profesi_id==$p->id)>{{ $p->nama_profesi }}</option>
                            @endforeach
                        </select>
                        @error('profesi_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal_masuk_kerja" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk Kerja</label>
                        <input type="date" name="tanggal_masuk_kerja" id="tanggal_masuk_kerja" value="{{ old('tanggal_masuk_kerja', $karyawan->tanggal_masuk_kerja) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_masuk_kerja')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                        <select name="agama" id="agama" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $opt)
                                <option value="{{ $opt }}" @selected($karyawan->agama===$opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('agama')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Pendidikan Terakhir -->
                    <div>
                        <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $karyawan->pendidikan_terakhir) }}" required class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="contoh: S1 Keperawatan">
                        @error('pendidikan_terakhir')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Gelar -->
                    <div>
                        <label for="gelar" class="block text-sm font-medium text-gray-700 mb-2">Gelar (Opsional)</label>
                        <input type="text" name="gelar" id="gelar" value="{{ old('gelar', $karyawan->gelar) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="S.Kep, Ners">
                        @error('gelar')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Kampus -->
                    <div>
                        <label for="kampus" class="block text-sm font-medium text-gray-700 mb-2">Asal Kampus (Opsional)</label>
                        <input type="text" name="kampus" id="kampus" value="{{ old('kampus', $karyawan->kampus) }}" class="w-full h-12 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Universitas ...">
                        @error('kampus')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center gap-4">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition-colors focus:ring-4 focus:ring-blue-200">Simpan & Selesaikan</button>
                    <p class="text-xs text-gray-500">Setelah lengkap, Anda akan melihat tampilan ringkasan.</p>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/wilayah-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    WilayahSelector.init({
        preselect: {
            provinsi_id: document.getElementById('provinsi_id')?.dataset.selected || '{{ $karyawan->provinsi_id }}',
            kabupaten_id: document.getElementById('kabupaten_id')?.dataset.selected || '{{ $karyawan->kabupaten_id }}',
            kecamatan_id: document.getElementById('kecamatan_id')?.dataset.selected || '{{ $karyawan->kecamatan_id }}',
            kelurahan_id: document.getElementById('kelurahan_id')?.dataset.selected || '{{ $karyawan->kelurahan_id }}'
        }
    });
});
</script>
@endpush
