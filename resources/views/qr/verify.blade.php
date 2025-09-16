<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Karyawan</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col items-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    QR Asli Terverifikasi
                </div>
                <h1 class="mt-4 text-2xl font-bold text-slate-900">Data Karyawan</h1>
                <p class="mt-1 text-sm text-slate-600">Halaman read-only. Tidak dapat dipakai untuk akses fitur lain.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                            @if($karyawan->foto_profil)
                                <img src="/storage/{{ ltrim($karyawan->foto_profil,'/') }}" class="w-16 h-16 object-cover" alt="Foto">
                            @else
                                <span class="text-slate-400 text-xs">TIDAK ADA</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-slate-900">{{ $karyawan->user->name }}</p>
                            <p class="text-sm text-slate-600">NIP: {{ $karyawan->nip ?? '—' }}</p>
                        </div>
                    </div>
                    <dl class="grid grid-cols-1 gap-4 text-sm">
                        <div>
                            <dt class="text-slate-500">Profesi</dt>
                            <dd class="font-medium text-slate-900">{{ $karyawan->profesi->nama_profesi ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Ruangan</dt>
                            <dd class="font-medium text-slate-900">{{ $karyawan->ruangan->nama_ruangan ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Status Akun</dt>
                            <dd class="font-medium text-slate-900">{{ $karyawan->user->status }}</dd>
                        </div>
                    </dl>
                    <div class="mt-2 rounded-lg bg-slate-50 border border-slate-200 p-3 text-xs text-slate-600">
                        Ditampilkan pada: {{ now()->format('d M Y H:i') }} WIB
                    </div>
                    <div class="pt-2 border-t text-[10px] text-slate-400 leading-relaxed">
                        Halaman ini hanya menampilkan ringkas data identitas karyawan untuk konfirmasi visual. Tidak dapat digunakan sebagai bukti legal tunggal dan tidak memberi akses ke fitur internal.
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center">
                <a href="/login" class="inline-flex items-center text-xs text-slate-400 hover:text-slate-600 transition">Masuk Aplikasi &rsaquo;</a>
            </div>
        </div>
    </div>
</body>
</html>
