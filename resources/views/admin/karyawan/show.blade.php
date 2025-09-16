@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Karyawan</h1>
                <p class="text-gray-600">Informasi lengkap karyawan</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.karyawan.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('qr.generate', $karyawan->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Generate QR
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Profile Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8">
                        <div class="flex items-center">
                            <div class="h-20 w-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-2xl font-bold mr-6">
                                {{ substr($karyawan->user->name, 0, 2) }}
                            </div>
                            <div class="text-white">
                                <h2 class="text-2xl font-bold">{{ $karyawan->user->name }}</h2>
                                <p class="text-blue-100 text-lg">{{ $karyawan->profesi->nama_profesi ?? '-' }}</p>
                                <p class="text-blue-200 text-sm">NIK: {{ $karyawan->nik }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Dasar</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="text-gray-900">{{ $karyawan->user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                        <p class="text-gray-900">{{ $karyawan->jenis_kelamin }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Ruangan</label>
                                        <p class="text-gray-900">{{ $karyawan->ruangan->nama_ruangan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Profesi</label>
                                        <p class="text-gray-900">{{ $karyawan->profesi->nama_profesi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Alamat</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Provinsi</label>
                                        <p class="text-gray-900">{{ $karyawan->provinsi->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Kabupaten/Kota</label>
                                        <p class="text-gray-900">{{ isset($karyawan->kabupaten) ? ($karyawan->kabupaten->type . ' ' . $karyawan->kabupaten->name) : '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Kecamatan</label>
                                        <p class="text-gray-900">{{ $karyawan->kecamatan->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Kelurahan/Desa</label>
                                        <p class="text-gray-900">{{ $karyawan->kelurahan->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Detail Alamat</label>
                                        <p class="text-gray-900">{{ $karyawan->alamat_detail ?? $karyawan->alamat ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Kelengkapan</h3>
                    <div class="text-center">
                        @if($karyawan->status_kelengkapan == 'lengkap')
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Data Lengkap
                            </div>
                            <p class="text-sm text-gray-600">Semua data telah terverifikasi</p>
                        @elseif($karyawan->status_kelengkapan == 'tahap2')
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Tahap 2
                            </div>
                            <p class="text-sm text-gray-600">Perlu melengkapi data tahap 2</p>
                        @else
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Tahap 1
                            </div>
                            <p class="text-sm text-gray-600">Menunggu aktivasi akun</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('qr.generate', $karyawan->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Generate QR Code
                        </a>
                        <a href="{{ route('admin.ruangan.show', $karyawan->ruangan_id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Lihat Ruangan
                        </a>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Role</label>
                            <p class="text-gray-900 capitalize">{{ $karyawan->user->role }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Terdaftar</label>
                            <p class="text-gray-900">{{ $karyawan->user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Terakhir Update</label>
                            <p class="text-gray-900">{{ $karyawan->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
