<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\DokumenKaryawan;
use App\Models\Ruangan;
use App\Models\Profesi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();
        $pendingApproval = User::where('status', 'pending')->where('role', 'karyawan')->count();
        $pendingKaryawan = $pendingApproval; // Alias untuk consistency
        $karyawanAktif = User::where('status', 'approved')->where('role', 'karyawan')->count();
        $approvedKaryawan = $karyawanAktif; // Alias untuk consistency
        
        // Dokumen yang akan berakhir dalam 30 hari
        $dokumenMenjelangBerakhir = DokumenKaryawan::where('berlaku_seumur_hidup', false)
            ->where('tanggal_berakhir', '>', now())
            ->where('tanggal_berakhir', '<=', now()->addDays(30))
            ->count();

        // Dokumen yang sudah berakhir
        $dokumenBerakhir = DokumenKaryawan::where('berlaku_seumur_hidup', false)
            ->where('tanggal_berakhir', '<', now())
            ->count();
            
        // Total dokumen yang akan expire (gabungan)
        $expiringDocs = $dokumenMenjelangBerakhir + $dokumenBerakhir;

        // Chart data - karyawan per ruangan dengan nama yang benar
    $ruanganStats = Ruangan::withCount('karyawan')
            ->orderBy('karyawan_count', 'desc')
            ->take(10)
            ->get()
            ->map(function($ruangan) {
        return [
            'nama' => $ruangan->nama_ruangan,
                    'jumlah' => $ruangan->karyawan_count
                ];
            });

        // Chart data - karyawan per profesi dengan nama yang benar  
    $profesiStats = Profesi::withCount('karyawan')
            ->orderBy('karyawan_count', 'desc')
            ->take(10)
            ->get()
            ->map(function($profesi) {
        return [
            'nama' => $profesi->nama_profesi,
                    'jumlah' => $profesi->karyawan_count
                ];
            });

        // Legacy data untuk compatibility
        $karyawanPerRuangan = $ruanganStats->pluck('jumlah', 'nama');
        $karyawanPerProfesi = $profesiStats->pluck('jumlah', 'nama');

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'pendingApproval',
            'pendingKaryawan', 
            'karyawanAktif',
            'approvedKaryawan',
            'dokumenMenjelangBerakhir',
            'dokumenBerakhir',
            'expiringDocs',
            'karyawanPerRuangan',
            'karyawanPerProfesi',
            'ruanganStats',
            'profesiStats'
        ));
    }
}
