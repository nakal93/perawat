@extends('layouts.app')

@section('breadcrumb', 'Beranda')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8">
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('dokumen.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl border border-blue-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="text-xs font-medium text-blue-700 uppercase tracking-wide">Total Dokumen</div>
                    <div class="mt-2 text-2xl font-bold text-blue-900">{{ $metrics['total'] ?? 0 }}</div>
                    <div class="mt-1 text-xs text-blue-600">Lihat semua dokumen</div>
                </div>
                <div class="shrink-0 rounded-xl p-3 bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0013.5 7.125V5.25A2.25 2.25 0 0011.25 3h-4.5A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25v-3a1.5 1.5 0 00-1.5-1.5h-6.75a.75.75 0 010-1.5h7.5z"/></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('dokumen.index', ['status' => 'aktif']) }}" class="group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-green-100 rounded-xl border border-emerald-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 to-green-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="text-xs font-medium text-emerald-700 uppercase tracking-wide">Aktif</div>
                    <div class="mt-2 text-2xl font-bold text-emerald-900">{{ $metrics['aktif'] ?? 0 }}</div>
                    <div class="mt-1 text-xs text-emerald-600">Dokumen berlaku</div>
                </div>
                <div class="shrink-0 rounded-xl p-3 bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.527-1.581-1.582a.75.75 0 10-1.06 1.061l2.25 2.25a.75.75 0 001.153-.094l3.694-5.29z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('dokumen.index', ['status' => 'akan_expire']) }}" class="group relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl border border-amber-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="text-xs font-medium text-amber-700 uppercase tracking-wide">Akan Expire</div>
                    <div class="mt-2 text-2xl font-bold text-amber-900">{{ $metrics['akan_expire'] ?? 0 }}</div>
                    <div class="mt-1 text-xs text-amber-600">Dalam 30 hari</div>
                </div>
                <div class="shrink-0 rounded-xl p-3 bg-amber-100 text-amber-600 group-hover:bg-amber-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7"><path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zM12 6a.75.75 0 01.75.75v4.19l2.28 2.28a.75.75 0 11-1.06 1.06l-2.47-2.47A.75.75 0 0111.25 11V6.75A.75.75 0 0112 6z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('dokumen.index', ['status' => 'expired']) }}" class="group relative overflow-hidden bg-gradient-to-br from-rose-50 to-red-100 rounded-xl border border-rose-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-rose-500 to-red-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="text-xs font-medium text-rose-700 uppercase tracking-wide">Expired</div>
                    <div class="mt-2 text-2xl font-bold text-rose-900">{{ $metrics['expired'] ?? 0 }}</div>
                    <div class="mt-1 text-xs text-rose-600">Sudah berakhir</div>
                </div>
                <div class="shrink-0 rounded-xl p-3 bg-rose-100 text-rose-600 group-hover:bg-rose-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM9.53 9.53a.75.75 0 011.06 0L12 10.94l1.41-1.41a.75.75 0 111.06 1.06L13.06 12l1.41 1.41a.75.75 0 11-1.06 1.06L12 13.06l-1.41 1.41a.75.75 0 11-1.06-1.06L10.94 12 9.53 10.59a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border shadow-sm p-6 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50">
                <h2 class="text-lg font-semibold text-slate-900 mb-1">Selamat datang{{ isset($karyawan) && $karyawan? ', '.$karyawan->nama : '' }}</h2>
                <p class="text-slate-600 text-sm">Pantau status akun, dokumen, dan lengkapi data Anda.</p>
            </div>

            @if(isset($karyawan) && $karyawan)
            <!-- Kelengkapan Dokumen -->
            <div class="bg-white rounded-xl border shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-slate-900">Kelengkapan Dokumen</h3>
                    <div class="text-sm text-slate-600">{{ $percentComplete }}% lengkap</div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                    <div class="sm:col-span-1 flex items-center justify-center">
                        <div class="w-36 h-36">
                            <canvas id="completeChart"></canvas>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        @if(($requiredCategories->count() ?? 0) === 0)
                            <p class="text-slate-600">Belum ada kategori dokumen wajib yang ditentukan admin.</p>
                        @elseif(($missingCategories->count() ?? 0) > 0)
                            <div class="mb-3 p-3 rounded-lg bg-amber-50 border border-amber-200 text-amber-800">
                                Segera lengkapi dokumen berikut untuk mencapai 100%.
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($missingCategories as $cat)
                                <div class="flex items-center justify-between p-3 rounded-lg border bg-slate-50">
                                    <div class="text-sm font-medium text-slate-800">{{ $cat->nama_kategori }}</div>
                                    <a href="{{ route('dokumen.create', ['kategori' => $cat->id]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-blue-600 text-white text-xs font-medium hover:bg-blue-700">Upload</a>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800">
                                Semua dokumen wajib telah lengkap. Mantap!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl border shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-slate-900">Dokumen Terbaru</h3>
                    <a href="{{ route('dokumen.index') }}" class="text-blue-600 text-sm">Lihat semua</a>
                </div>
                <div class="text-sm text-slate-500">Tidak ada ringkasan untuk saat ini.</div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl border shadow-sm p-6">
                <h3 class="text-base font-semibold text-slate-900 mb-3">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('karyawan.profile') }}" class="inline-flex items-center gap-2 p-3 rounded-lg text-sm font-medium text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-slate-200 text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/><path fill-rule="evenodd" d="M4.5 20.75a8.25 8.25 0 1116.5 0 .75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75z" clip-rule="evenodd"/></svg>
                        </span>
                        Profil
                    </a>
                    <a href="{{ route('dokumen.index') }}" class="inline-flex items-center gap-2 p-3 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-blue-200 text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0013.5 7.125V5.25A2.25 2.25 0 0011.25 3h-4.5A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25v-3a1.5 1.5 0 00-1.5-1.5h-6.75a.75.75 0 010-1.5h7.5z"/></svg>
                        </span>
                        Dokumen
                    </a>
                    <a href="{{ route('karyawan.settings') }}" class="inline-flex items-center gap-2 p-3 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-indigo-200 text-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.87 1.567l-.149.788a8.284 8.284 0 00-1.418.82l-.733-.293a1.875 1.875 0 00-2.3.936l-.75 1.5a1.875 1.875 0 00.436 2.3l.585.584a8.507 8.507 0 000 1.639l-.585.585a1.875 1.875 0 00-.436 2.299l.75 1.5a1.875 1.875 0 002.3.936l.733-.293c.44.33.91.606 1.418.82l.149.788c.171.904.953 1.567 1.87 1.567h1.5c.917 0 1.699-.663 1.87-1.567l.149-.788c.508-.214.978-.49 1.418-.82l.733.293a1.875 1.875 0 002.3-.936l.75-1.5a1.875 1.875 0 00-.436-2.299l-.585-.585c.04-.272.06-.551.06-.834s-.02-.562-.06-.834l.585-.585c.52-.52.66-1.307.436-2.3l-.75-1.5a1.875 1.875 0 00-2.3-.935l-.733.292a8.284 8.284 0 00-1.418-.82l-.149-.788A1.875 1.875 0 0012.578 2.25h-1.5zM15 12a3 3 0 11-6 0 3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        </span>
                        Pengaturan
                    </a>
                </div>
            </div>

            <!-- Ringkasan Status (mini chart) -->
            <div class="bg-white rounded-xl border shadow-sm p-6">
                <h3 class="text-base font-semibold text-slate-900 mb-3">Ringkasan Status</h3>
                <div class="h-48">
                    <canvas id="quickStatusChart"></canvas>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2 text-xs sm:text-sm text-slate-700">
                    <div class="rounded-md bg-emerald-50 border border-emerald-200 px-2 py-1 text-center"><span class="font-semibold text-emerald-700">Aktif</span><div>{{ $metrics['aktif'] ?? 0 }}</div></div>
                    <div class="rounded-md bg-amber-50 border border-amber-200 px-2 py-1 text-center"><span class="font-semibold text-amber-700">Akan Expire</span><div>{{ $metrics['akan_expire'] ?? 0 }}</div></div>
                    <div class="rounded-md bg-rose-50 border border-rose-200 px-2 py-1 text-center"><span class="font-semibold text-rose-700">Expired</span><div>{{ $metrics['expired'] ?? 0 }}</div></div>
                </div>
            </div>
        </div>
    </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="bg-white rounded-xl border shadow-sm p-6 lg:col-span-2">
                        <div class="flex items-center justify-between mb-2">
                                <h3 class="text-base font-semibold text-slate-900">Aktivitas Upload (6 bulan)</h3>
                        </div>
                        <div class="h-72">
                                <canvas id="uploadsChart"></canvas>
                        </div>
                </div>
                <div class="bg-white rounded-xl border shadow-sm p-6">
                        <h3 class="text-base font-semibold text-slate-900 mb-2">Status Dokumen</h3>
                        <div class="h-72">
                                <canvas id="statusChart"></canvas>
                        </div>
                </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-6">
                <div class="bg-white rounded-xl border shadow-sm p-6">
                        <h3 class="text-base font-semibold text-slate-900 mb-2">Kategori Dokumen</h3>
                        <div class="h-72">
                                <canvas id="kategoriChart"></canvas>
                        </div>
                </div>
        </div>
</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const uploads = @json($chartUploads);
    const kategori = @json($chartKategori);
    const statusData = @json($chartStatus);

    const palette = {
        blue: '#3b82f6', blueLight: '#93c5fd',
        emerald: '#10b981', emeraldLight: '#6ee7b7',
        amber: '#f59e0b', amberLight: '#fde68a',
        rose: '#ef4444', roseLight: '#fecaca',
        slate: '#64748b', slateLight: '#cbd5e1',
    };
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } },
            tooltip: { mode: 'index', intersect: false },
        },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: 'rgba(100,116,139,0.08)' }, ticks: { precision: 0 } },
        },
    };

    // Completeness chart
    const completeCanvas = document.getElementById('completeChart');
    if (completeCanvas) {
        const value = Number({{ (int)($percentComplete ?? 0) }});
        const rest = Math.max(0, 100 - value);
        new Chart(completeCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Lengkap','Belum'],
                datasets: [{
                    data: [value, rest],
                    backgroundColor: [palette.emerald, palette.slateLight],
                    hoverBackgroundColor: [palette.emeraldLight, palette.slate],
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: { ...commonOptions, scales: {}, cutout: '70%', plugins: { ...commonOptions.plugins, legend: { display: false }, tooltip: { enabled: false } } }
        });
    }

        // Ensure safe defaults
        const safeUploads = uploads && uploads.labels && uploads.data ? uploads : { labels: [], data: [] };
        const safeKategori = kategori && kategori.labels && kategori.data ? kategori : { labels: [], data: [] };
        const safeStatus = statusData && statusData.labels && statusData.data ? statusData : { labels: ['Aktif','Akan Expire','Expired'], data: [0,0,0] };

        // Uploads Bar Chart
        const uploadsCanvas = document.getElementById('uploadsChart');
        if (uploadsCanvas) {
            const uploadsCtx = uploadsCanvas.getContext('2d');
            const grad = uploadsCtx.createLinearGradient(0, 0, 0, uploadsCanvas.height);
            grad.addColorStop(0, 'rgba(59,130,246,0.6)');
            grad.addColorStop(1, 'rgba(59,130,246,0.1)');
            new Chart(uploadsCtx, {
            type: 'bar',
            data: {
                    labels: safeUploads.labels,
                datasets: [{
                    label: 'Upload',
                        data: safeUploads.data,
                        backgroundColor: grad,
                    borderRadius: 6,
                    maxBarThickness: 28,
                }]
            },
                options: {
                    ...commonOptions,
                    plugins: { ...commonOptions.plugins, legend: { display: false } },
                }
        });
    }

    // Status Doughnut
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
            new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                    labels: safeStatus.labels,
                datasets: [{
                        data: safeStatus.data,
                    backgroundColor: [palette.emerald, palette.amber, palette.rose],
                    hoverBackgroundColor: [palette.emeraldLight, palette.amberLight, palette.roseLight],
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
                options: { ...commonOptions, scales: {}, cutout: '60%' }
        });
    }

    // Quick Status mini chart (bar)
    const quickCtx = document.getElementById('quickStatusChart');
    if (quickCtx) {
        new Chart(quickCtx, {
            type: 'bar',
            data: {
                labels: safeStatus.labels,
                datasets: [{
                    label: 'Dokumen',
                    data: safeStatus.data,
                    backgroundColor: [palette.emerald, palette.amber, palette.rose],
                    borderRadius: 6,
                    maxBarThickness: 18,
                }]
            },
            options: { ...commonOptions, plugins: { ...commonOptions.plugins, legend: { display: false } } }
        });
    }

    // Kategori Doughnut
    const kategoriCtx = document.getElementById('kategoriChart');
    if (kategoriCtx) {
        const base = [palette.blue, palette.emerald, palette.amber, palette.rose, palette.slate];
        const baseLight = [palette.blueLight, palette.emeraldLight, palette.amberLight, palette.roseLight, palette.slateLight];
            const colors = safeKategori.labels.map((_, i) => base[i % base.length]);
            const colorsLight = safeKategori.labels.map((_, i) => baseLight[i % baseLight.length]);
            new Chart(kategoriCtx, {
            type: 'doughnut',
            data: {
                    labels: safeKategori.labels,
                datasets: [{
                        data: safeKategori.data,
                    backgroundColor: colors,
                    hoverBackgroundColor: colorsLight,
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
                options: { ...commonOptions, scales: {}, cutout: '55%' }
        });
    }
});
</script>
@endsection
