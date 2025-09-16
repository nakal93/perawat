@extends('layouts.app')

@section('breadcrumb', 'Tambah Karyawan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
        <!-- Header -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-800 mb-10 shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="max-w-full mx-auto px-6 lg:px-12 py-12 relative z-10">
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                    <div class="mb-4 xl:mb-0">
                        <h1 class="text-4xl font-bold text-white tracking-tight">
                            Tambah Karyawan Baru
                        </h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Daftarkan karyawan baru ke sistem RSUD Dolopo
                        </p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-white bg-white/20 rounded-lg px-4 py-2 backdrop-blur-sm hover:bg-white/30 transition-colors duration-300">
                            <span class="font-medium">← Kembali ke Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-6 lg:px-12 pb-12">
            <!-- Form Create Karyawan -->
            <div class="bg-white rounded-2xl shadow-lg shadow-blue-900/5 border border-slate-200 p-8">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <!-- User Account Section -->
                    <div class="border-b border-slate-200 pb-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Data Akun</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="nama@rsud.com">
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Minimal 8 karakter">
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Data Section -->
                    <div class="border-b border-slate-200 pb-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Data Pribadi</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nik" class="block text-sm font-medium text-slate-700 mb-2">NIK</label>
                                <input type="text" id="nik" name="nik" required maxlength="16"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="16 digit NIK">
                            </div>
                            
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                                <textarea id="alamat" name="alamat" required rows="3"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Alamat lengkap"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Work Data Section -->
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Data Pekerjaan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ruangan_id" class="block text-sm font-medium text-slate-700 mb-2">Ruangan</label>
                                <select id="ruangan_id" name="ruangan_id" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($ruangan as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="profesi_id" class="block text-sm font-medium text-slate-700 mb-2">Profesi</label>
                                <select id="profesi_id" name="profesi_id" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Pilih Profesi</option>
                                    @foreach($profesi as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Status Setting -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Pengaturan Status</h3>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="radio" name="auto_approve" value="1" checked
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-blue-800 font-medium">Langsung Setujui</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="auto_approve" value="0"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-blue-800 font-medium">Pending Review</span>
                            </label>
                        </div>
                        <p class="text-sm text-blue-600 mt-2">Pilih apakah karyawan ini langsung disetujui atau perlu review</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-slate-200">
                        <a href="{{ route('admin.dashboard') }}" 
                            class="px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors duration-300 text-center">
                            Batal
                        </a>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-lg shadow-blue-600/25 hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-600/40 transition-all duration-300">
                            Simpan Karyawan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
