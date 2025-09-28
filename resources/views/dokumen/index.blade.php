@extends('layouts.app')

@section('content')
<div class="w-full py-6" x-data="{
        open: false,
        formId: null,
        filename: '',
        openModal(detail) {
            this.formId = detail?.formId || null;
            this.filename = detail?.filename || '';
            this.open = true;
            this.$nextTick(() => { this.$refs.cancelBtn?.focus(); });
        },
        close() {
            this.open = false;
            this.formId = null;
            this.filename = '';
        },
        confirmDelete() {
            if (!this.formId) return;
            const form = document.getElementById(this.formId);
            if (form) form.submit();
            this.close();
        }
    }" @keydown.escape.window="open && close()" @open-delete="openModal($event.detail)">
    @if(request()->boolean('debug'))
    @php
        $user = auth()->user();
        $k = isset($karyawan) ? $karyawan : optional($user)->karyawan;
        $diskUrl = config('filesystems.disks.public.url');
        $host = request()->getHost();
        $port = request()->getPort();
        $diskHost = $diskUrl ? parse_url($diskUrl, PHP_URL_HOST) : null;
        $diskPort = $diskUrl ? (parse_url($diskUrl, PHP_URL_PORT) ?? (Str::startsWith($diskUrl, 'https') ? 443 : 80)) : null;
        $symlink = public_path('storage');
        $symlinkExists = file_exists($symlink);
        $isLink = is_link($symlink);
    @endphp
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm">
        <div class="font-semibold text-amber-800 mb-2">Debug Dokumen</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-amber-900">
            <div><span class="font-medium">User:</span> {{ $user->id }} — {{ $user->name }}</div>
            <div><span class="font-medium">Request host:port:</span> {{ $host }}:{{ $port }}</div>
            <div><span class="font-medium">Disk public url:</span> {{ $diskUrl ?? 'null' }}</div>
            <div><span class="font-medium">Disk host:port:</span> {{ $diskHost }}:{{ $diskPort }}</div>
            <div><span class="font-medium">Symlink:</span> {{ $symlinkExists ? ($isLink ? 'LINK' : 'DIR') : 'MISSING' }}</div>
            <div><span class="font-medium">Total Dokumen:</span> {{ $dokumen->count() }}</div>
        </div>
        @if($diskUrl && ($diskHost !== $host || $diskPort !== $port))
            <div class="mt-3 p-3 rounded bg-red-50 border border-red-200 text-red-700">
                Peringatan: URL disk public berbeda host/port dengan request saat ini. Menggunakan URL relatif untuk thumbnail.
            </div>
        @endif
    </div>
    @endif
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Dokumen Saya</h1>
        <a href="{{ route('dokumen.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload Dokumen</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 border rounded-lg bg-green-50 border-green-200 text-green-800">{{ session('success') }}</div>
    @endif

    @if(!$karyawan)
        <p class="text-gray-600">Profil karyawan belum dibuat.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($dokumen as $d)
                <div class="bg-white border rounded-lg p-4 flex flex-col">
                    @php
                        $ext = pathinfo($d->file_name, PATHINFO_EXTENSION);
                        $lowerExt = strtolower($ext);
                        $isImage = in_array($lowerExt, ['jpg','jpeg','png','gif','webp']);
                        $isPdf = $lowerExt === 'pdf';
                        // Use secure preview route for private/legacy files
                        $fileRel = route('dokumen.preview', $d);
                        $thumbRel = $fileRel;
                        // Hitung ukuran file dari storage privat; fallback ke public
                        $sizeBytes = null;
                        try {
                            if ($d->file_path) {
                                if (Storage::disk('local')->exists($d->file_path)) {
                                    $sizeBytes = Storage::disk('local')->size($d->file_path);
                                } elseif (Storage::disk('public')->exists($d->file_path)) {
                                    $sizeBytes = Storage::disk('public')->size($d->file_path);
                                }
                            }
                        } catch (\Throwable $e) { $sizeBytes = null; }
                        $sizeHuman = '-';
                        if (is_int($sizeBytes)) {
                            $units = ['B','KB','MB','GB','TB'];
                            $pow = $sizeBytes > 0 ? floor(log($sizeBytes, 1024)) : 0;
                            $pow = min($pow, count($units)-1);
                            $sizeHuman = number_format($sizeBytes / pow(1024, $pow), $pow >= 2 ? 2 : 0).' '.$units[$pow];
                        }
                    @endphp
                    @if($isImage)
                        <div class="relative group">
                            <button onclick="openImageModal('{{ $thumbRel }}', '{{ addslashes($d->file_name) }}')" 
                                class="block w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                                <img src="{{ $thumbRel }}" 
                                     alt="{{ $d->file_name }}" 
                                     class="w-full h-32 object-cover rounded-md mb-3 ring-1 ring-slate-200 group-hover:ring-blue-300 transition cursor-pointer"
                                     loading="lazy">
                            </button>
                            <!-- Preview indicator -->
                            <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat
                            </div>
                        </div>
                    @else
                        <div class="w-full mb-3">
                            @if($isPdf)
                                <!-- Inline PDF preview seperti di halaman admin detail -->
                                <div class="relative w-full h-40 sm:h-56 border rounded-md overflow-hidden bg-white">
                                    <iframe src="{{ $fileRel }}" class="w-full h-full" frameborder="0" loading="lazy"></iframe>
                                    <button type="button" onclick="openPdfViewer('{{ $fileRel }}', '{{ addslashes($d->file_name) }}')"
                                            class="absolute bottom-2 right-2 inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-red-600 text-white hover:bg-red-700 shadow">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Perbesar
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Preview PDF - <a href="{{ $fileRel }}" target="_blank" class="text-blue-600 hover:underline">Buka di tab baru</a></p>
                            @else
                                <div class="w-full h-32 bg-gray-50 border border-dashed rounded-md flex items-center justify-center text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-sm uppercase font-medium">{{ $ext }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="text-sm text-gray-500">Kategori</div>
                    <div class="font-medium">{{ $d->kategoriDokumen->nama_kategori ?? '-' }}</div>
                    <div class="mt-2 text-sm text-gray-500">Nama File</div>
                    <div class="truncate">{{ $d->file_name }}</div>
                    <div class="mt-2 text-sm text-gray-500">Ukuran</div>
                    <div class="text-sm">{{ $sizeHuman }}</div>
                    <div class="mt-2 text-sm text-gray-500">Masa Berlaku</div>
                    <div class="text-sm">@if($d->berlaku_seumur_hidup) Seumur Hidup @else {{ optional($d->tanggal_mulai)->format('d M Y') }} - {{ optional($d->tanggal_berakhir)->format('d M Y') }} @endif</div>
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('dokumen.download', $d) }}" class="px-3 py-2 border rounded-lg hover:bg-gray-50">Unduh</a>
                        <form id="delete-form-{{ $d->id }}" action="{{ route('dokumen.destroy', $d) }}" method="POST">
                            @csrf
                            @method('DELETE')
                <button type="submit"
                    class="px-3 py-2 border rounded-lg text-red-600 hover:bg-red-50"
                    @click.prevent="openModal({ formId: 'delete-form-{{ $d->id }}', filename: '{{ addslashes($d->file_name) }}' })">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-gray-600">Belum ada dokumen.</div>
            @endforelse
        </div>
        @if(method_exists($dokumen, 'links'))
        <div class="mt-6">
            {{ $dokumen->withQueryString()->onEachSide(1)->links() }}
        </div>
        @endif
    @endif

    <!-- Konfirmasi Hapus Dokumen (dipindah ke dalam root x-data) -->
    <div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 z-[12000]" role="dialog" aria-modal="true" aria-labelledby="confirmDeleteTitle" aria-describedby="confirmDeleteDesc">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="close()"></div>

        <!-- Panel -->
        <div class="relative h-full w-full flex items-end sm:items-center justify-center p-4 sm:p-6">
            <div x-show="open" x-transition.opacity x-transition.duration.200ms
                 class="w-full max-w-md sm:max-w-lg bg-white rounded-2xl shadow-xl ring-1 ring-slate-200 overflow-hidden">
                <div class="px-6 sm:px-8 pt-6 pb-5 sm:pb-6">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0 w-10 h-10 rounded-full bg-red-100 text-red-700 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M4.93 19.07a10 10 0 1 1 14.14 0 10 10 0 0 1-14.14 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 id="confirmDeleteTitle" class="text-lg sm:text-xl font-semibold text-slate-900">Hapus dokumen ini?</h2>
                            <p id="confirmDeleteDesc" class="mt-1.5 text-sm leading-relaxed text-slate-600">Tindakan ini tidak bisa dibatalkan. Dokumen <span class="font-medium text-slate-900" x-text="filename"></span> akan dihapus permanen.</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-slate-200"></div>
                <div class="px-6 sm:px-8 py-4 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 sm:gap-3.5">
                    <button type="button" @click="close()" x-ref="cancelBtn"
                            class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-slate-400">
                        Batal
                    </button>
                    <button type="button" @click="confirmDelete()"
                            class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-semibold text-white hover:bg-red-700 shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-red-500">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-1-3a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3" />
                        </svg>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- (Modal pratinjau PDF global tetap di layout) -->
@endsection
 
