<x-app-layout>
    <style>
        /* Modern Minimalist Color Variables */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --info-gradient: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            
            /* Modern Minimalist Colors */
            --modern-dark: #1a1a2e;
            --modern-purple: #16213e;
            --modern-blue: #0f3460;
            --modern-accent: #e94560;
            --modern-teal: #00d4aa;
            --modern-orange: #ff6b35;
            
            /* Neutral Modern Colors */
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;
            
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --shadow-soft: 0 8px 32px rgba(31, 38, 135, 0.37);
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Modern Background */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(31, 38, 135, 0.5);
        }

        /* Modern Gradient Cards with Minimalist Colors */
        .gradient-card-1 { background: linear-gradient(135deg, var(--modern-teal) 0%, #06b6d4 100%); }
        .gradient-card-2 { background: linear-gradient(135deg, var(--modern-orange) 0%, #f97316 100%); }
        .gradient-card-3 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-card-4 { background: linear-gradient(135deg, var(--modern-accent) 0%, #dc2626 100%); }
        .gradient-card-5 { background: linear-gradient(135deg, var(--neutral-600) 0%, var(--neutral-700) 100%); }
        .gradient-card-6 { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }

        /* Chart Container Styling */
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        /* Modern Button Styles */
        .modern-btn {
            background: var(--modern-purple);
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(143, 68, 253, 0.4);
        }

        .modern-btn:hover {
            background: linear-gradient(45deg, var(--modern-purple), var(--modern-pink));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(143, 68, 253, 0.6);
        }

        /* Modern Minimalist Background */
        .bg-animated {
            background: linear-gradient(-45deg, 
                var(--modern-dark), 
                var(--modern-purple), 
                var(--modern-blue), 
                var(--neutral-800)
            );
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Modern Typography */
        .modern-title {
            background: linear-gradient(45deg, var(--modern-purple), var(--modern-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
        }

        /* Card Animation */
        .animate-card {
            animation: slideUp 0.6s ease forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modern Icons */
        .modern-icon {
            background: var(--glass-bg);
            border-radius: 15px;
            padding: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }

        /* Chart Container Styling */
        .chart-container {
            position: relative;
            overflow: hidden;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            padding: 20px;
            border-radius: 15px;
            background: var(--glass-bg);
        }

        .chart-canvas {
            border-radius: 10px;
        }

        /* Quick Action Cards */
        .quick-action-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .quick-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .quick-action-card:hover::before {
            left: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-title {
                font-size: 2rem;
            }
            
            .glass-card {
                padding: 20px;
            }
            
            .chart-wrapper {
                height: 250px;
                padding: 15px;
            }
        }

        /* Loading Animation */
        .chart-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
            color: white;
        }

        .loading-spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div class="bg-animated min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="max-w-7xl mx-auto">
                <!-- Modern Header -->
                <div class="mb-8 text-center animate-card">
                    <h1 class="modern-title mb-4">Dashboard Admin</h1>
                    <p class="text-white/80 text-lg font-medium">Sistem Manajemen Karyawan Rumah Sakit Modern</p>
                </div>

        <!-- Stats Grid -->
                        <!-- Modern Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Karyawan -->
                    <div class="glass-card gradient-card-1 p-6 text-white animate-card" style="animation-delay: 0.1s;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/90 text-sm font-medium">Total Karyawan</p>
                                <p class="text-3xl font-bold mt-2">{{ $totalKaryawan }}</p>
                                <p class="text-white/80 text-xs mt-1">
                                    <i class="fas fa-users mr-1"></i>Karyawan Aktif
                                </p>
                            </div>
                            <div class="modern-icon">
                                <i class="fas fa-users text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approval -->
                    <div class="glass-card gradient-card-2 p-6 text-white animate-card" style="animation-delay: 0.2s;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/90 text-sm font-medium">Menunggu Persetujuan</p>
                                <p class="text-3xl font-bold mt-2">{{ $pendingKaryawan }}</p>
                                <p class="text-white/80 text-xs mt-1">
                                    <i class="fas fa-clock mr-1"></i>Perlu Review
                                </p>
                            </div>
                            <div class="modern-icon">
                                <i class="fas fa-hourglass-half text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Approved -->
                    <div class="glass-card gradient-card-3 p-6 text-white animate-card" style="animation-delay: 0.3s;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/90 text-sm font-medium">Disetujui</p>
                                <p class="text-3xl font-bold mt-2">{{ $approvedKaryawan }}</p>
                                <p class="text-white/80 text-xs mt-1">
                                    <i class="fas fa-check-circle mr-1"></i>Sudah Diverifikasi
                                </p>
                            </div>
                            <div class="modern-icon">
                                <i class="fas fa-check-circle text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Expiring -->
                    <div class="glass-card gradient-card-4 p-6 text-white animate-card" style="animation-delay: 0.4s;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/90 text-sm font-medium">Dokumen Akan Expire</p>
                                <p class="text-3xl font-bold mt-2">{{ $expiringDocs }}</p>
                                <p class="text-white/80 text-xs mt-1">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>30 Hari Ke Depan
                                </p>
                            </div>
                            <div class="modern-icon">
                                <i class="fas fa-file-medical text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Modern Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Karyawan by Ruangan Chart -->
            <div class="glass-card p-8 chart-container animate-card" style="animation-delay: 0.5s;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Distribusi Karyawan per Ruangan</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full" style="background-color: rgba(0, 212, 170, 1);"></div>
                        <span class="text-sm text-white/70">Jumlah Karyawan</span>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="ruanganChart" class="chart-canvas"></canvas>
                </div>
            </div>

            <!-- Karyawan by Profesi Chart -->
            <div class="glass-card p-8 chart-container animate-card" style="animation-delay: 0.6s;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Distribusi Karyawan per Profesi</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full" style="background: linear-gradient(135deg, rgba(139, 92, 246, 1) 0%, rgba(168, 85, 247, 1) 100%);"></div>
                        <span class="text-sm text-white/70">Persentase</span>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="profesiChart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Modern Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Monthly Registration Trend -->
            <div class="lg:col-span-2 glass-card p-8 chart-container animate-card" style="animation-delay: 0.7s;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Tren Pendaftaran Karyawan</h3>
                    <select id="trendPeriod" class="text-sm bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg px-3 py-1 text-white">
                        <option value="6" class="text-gray-900">6 Bulan Terakhir</option>
                        <option value="12" class="text-gray-900">12 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="chart-wrapper">
                    <canvas id="trendChart" class="chart-canvas"></canvas>
                </div>
            </div>

            <!-- Status Distribution -->
            <div class="glass-card p-8 chart-container animate-card" style="animation-delay: 0.8s;">
                <h3 class="text-xl font-bold text-white mb-6">Status Karyawan</h3>
                <div class="chart-wrapper">
                    <canvas id="statusChart" class="chart-canvas"></canvas>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: rgba(0, 212, 170, 1);"></div>
                            <span class="text-white/90">Aktif</span>
                        </div>
                        <span class="font-medium text-white">{{ $karyawanAktif }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: rgba(255, 107, 53, 1);"></div>
                            <span class="text-white/90">Pending</span>
                        </div>
                        <span class="font-medium text-white">{{ $pendingApproval }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: rgba(233, 69, 96, 1);"></div>
                            <span class="text-white/90">Ditolak</span>
                        </div>
                        <span class="font-medium text-white">{{ $totalKaryawan - $karyawanAktif - $pendingApproval }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modern Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('admin.profesi.index') }}" class="glass-card p-6 quick-action-card group animate-card" style="animation-delay: 0.9s;">
                <div class="flex items-center">
                    <div class="modern-icon bg-gradient-to-r from-orange-500 to-orange-600 group-hover:from-orange-600 group-hover:to-orange-700 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-white">Kelola Profesi</p>
                        <p class="text-sm text-white/70">{{ \App\Models\Profesi::count() }} profesi tersedia</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.ruangan.index') }}" class="glass-card p-6 quick-action-card group animate-card" style="animation-delay: 1.0s;">
                <div class="flex items-center">
                    <div class="modern-icon bg-gradient-to-r from-purple-500 to-purple-600 group-hover:from-purple-600 group-hover:to-purple-700 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-white">Kelola Ruangan</p>
                        <p class="text-sm text-white/70">{{ \App\Models\Ruangan::count() }} ruangan aktif</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.approval.index') }}" class="glass-card p-6 quick-action-card group animate-card" style="animation-delay: 1.1s;">
                <div class="flex items-center">
                    <div class="modern-icon bg-gradient-to-r from-yellow-500 to-yellow-600 group-hover:from-yellow-600 group-hover:to-yellow-700 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-white">Persetujuan</p>
                        <p class="text-sm text-white/70">{{ $pendingApproval }} menunggu</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.dokumen.index') }}" class="glass-card p-6 quick-action-card group animate-card" style="animation-delay: 1.2s;">
                <div class="flex items-center">
                    <div class="modern-icon bg-gradient-to-r from-teal-500 to-teal-600 group-hover:from-teal-600 group-hover:to-teal-700 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-white">Kelola Dokumen</p>
                        <p class="text-sm text-white/70">{{ \App\Models\DokumenKaryawan::count() }} dokumen</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @php
                    $recentUsers = \App\Models\User::where('role', 'karyawan')->latest()->take(5)->get();
                @endphp
                @forelse($recentUsers as $user)
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-sm font-medium text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $user->status === 'pending' ? 'Mendaftar sebagai karyawan' : 'Bergabung sebagai karyawan' }}
                        </p>
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p>Belum ada aktivitas terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modern Chart.js configuration with glassmorphism theme
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = 'rgba(255, 255, 255, 0.8)';
    Chart.defaults.backgroundColor = 'rgba(255, 255, 255, 0.1)';

    // Ruangan Chart Data
    const ruanganData = {!! json_encode($ruanganStats->pluck('jumlah')->toArray()) !!};
    const ruanganLabels = {!! json_encode($ruanganStats->pluck('nama')->toArray()) !!};

    // Profesi Chart Data
    const profesiData = {!! json_encode($profesiStats->pluck('jumlah')->toArray()) !!};
    const profesiLabels = {!! json_encode($profesiStats->pluck('nama')->toArray()) !!};

    // Modern minimalist color palette
    const modernColors = [
        'rgba(0, 212, 170, 0.8)', // Modern Teal
        'rgba(255, 107, 53, 0.8)', // Modern Orange
        'rgba(16, 185, 129, 0.8)', // Green
        'rgba(233, 69, 96, 0.8)', // Modern Accent
        'rgba(99, 102, 241, 0.8)', // Indigo
        'rgba(139, 92, 246, 0.8)', // Purple
        'rgba(6, 182, 212, 0.8)', // Cyan
        'rgba(34, 197, 94, 0.8)', // Emerald
        'rgba(249, 115, 22, 0.8)', // Orange
        'rgba(168, 85, 247, 0.8)' // Violet
    ];

    const modernBorderColors = [
        'rgba(0, 212, 170, 1)', // Modern Teal
        'rgba(255, 107, 53, 1)', // Modern Orange
        'rgba(16, 185, 129, 1)', // Green
        'rgba(233, 69, 96, 1)', // Modern Accent
        'rgba(99, 102, 241, 1)', // Indigo
        'rgba(139, 92, 246, 1)', // Purple
        'rgba(6, 182, 212, 1)', // Cyan
        'rgba(34, 197, 94, 1)', // Emerald
        'rgba(249, 115, 22, 1)', // Orange
        'rgba(168, 85, 247, 1)' // Violet
    ];

    // Ruangan Bar Chart with Modern Styling
    const ruanganCtx = document.getElementById('ruanganChart').getContext('2d');
    new Chart(ruanganCtx, {
        type: 'bar',
        data: {
            labels: ruanganLabels,
            datasets: [{
                label: 'Jumlah Karyawan',
                data: ruanganData,
                backgroundColor: modernColors.slice(0, ruanganData.length),
                borderColor: modernBorderColors.slice(0, ruanganData.length),
                borderWidth: 2,
                borderRadius: 12,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: 'rgba(0, 0, 0, 0.8)',
                    bodyColor: 'rgba(0, 0, 0, 0.7)',
                    cornerRadius: 10,
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)',
                        borderColor: 'rgba(255, 255, 255, 0.3)'
                    }
                },
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Profesi Doughnut Chart with Modern Styling
    const profesiCtx = document.getElementById('profesiChart').getContext('2d');
    new Chart(profesiCtx, {
        type: 'doughnut',
        data: {
            labels: profesiLabels,
            datasets: [{
                data: profesiData,
                backgroundColor: modernColors.slice(0, profesiData.length),
                borderColor: modernBorderColors.slice(0, profesiData.length),
                borderWidth: 2,
                hoverBorderWidth: 4,
                hoverBorderColor: 'rgba(255, 255, 255, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        color: 'rgba(255, 255, 255, 0.8)',
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: 'rgba(0, 0, 0, 0.8)',
                    bodyColor: 'rgba(0, 0, 0, 0.7)',
                    cornerRadius: 10,
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1
                }
            }
        }
    });
    // Trend Chart (Line Chart) with Modern Styling
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Pendaftaran Karyawan',
                data: [4, 8, 12, 6, 15, 10], // Replace with actual data
                borderColor: 'rgba(0, 212, 170, 1)', // Modern Teal
                backgroundColor: 'rgba(0, 212, 170, 0.2)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(0, 212, 170, 1)',
                pointBorderColor: 'rgba(255, 255, 255, 1)',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: 'rgba(0, 212, 170, 1)',
                pointHoverBorderColor: 'rgba(255, 255, 255, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: 'rgba(0, 0, 0, 0.8)',
                    bodyColor: 'rgba(0, 0, 0, 0.7)',
                    cornerRadius: 10,
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)',
                        borderColor: 'rgba(255, 255, 255, 0.3)'
                    }
                },
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Status Chart (Pie Chart) with Modern Styling
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['Aktif', 'Pending', 'Ditolak'],
            datasets: [{
                data: [{{ $karyawanAktif }}, {{ $pendingApproval }}, {{ $totalKaryawan - $karyawanAktif - $pendingApproval }}],
                backgroundColor: [
                    'rgba(0, 212, 170, 0.8)', // Modern Teal for Active
                    'rgba(255, 107, 53, 0.8)', // Modern Orange for Pending
                    'rgba(233, 69, 96, 0.8)' // Modern Accent for Rejected
                ],
                borderColor: [
                    'rgba(0, 212, 170, 1)',
                    'rgba(255, 107, 53, 1)',
                    'rgba(233, 69, 96, 1)'
                ],
                borderWidth: 2,
                hoverBorderWidth: 4,
                hoverBorderColor: 'rgba(255, 255, 255, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: 'rgba(0, 0, 0, 0.8)',
                    bodyColor: 'rgba(0, 0, 0, 0.7)',
                    cornerRadius: 10,
                    borderColor: 'rgba(255, 255, 255, 0.3)',
                    borderWidth: 1
                }
            }
        }
    });

    // Add smooth animations on load
    setTimeout(() => {
        document.querySelectorAll('.animate-card').forEach((card, index) => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }, 100);

    // Modern loading states for charts
    const charts = [ruanganCtx, profesiCtx, trendCtx, statusCtx];
    charts.forEach(chart => {
        chart.canvas.style.opacity = '0';
        chart.canvas.style.transform = 'scale(0.9)';
        chart.canvas.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            chart.canvas.style.opacity = '1';
            chart.canvas.style.transform = 'scale(1)';
        }, 500);
    // Add smooth animations on load
    setTimeout(() => {
        document.querySelectorAll('.animate-card').forEach((card, index) => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }, 100);

    // Modern loading states for charts
    const charts = [ruanganCtx, profesiCtx, trendCtx, statusCtx];
    charts.forEach(chart => {
        chart.canvas.style.opacity = '0';
        chart.canvas.style.transform = 'scale(0.9)';
        chart.canvas.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            chart.canvas.style.opacity = '1';
            chart.canvas.style.transform = 'scale(1)';
        }, 500);
    });
});
</script>

</x-app-layout>
