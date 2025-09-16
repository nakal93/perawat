<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Ruangan;
use App\Models\Profesi;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of karyawan.
     */
    public function index(Request $request)
    {
    $query = Karyawan::with(['user', 'ruangan', 'profesi']);
        
        // Filter by ruangan if provided
        if ($request->has('ruangan') && $request->ruangan) {
            $query->where('ruangan_id', $request->ruangan);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Status filter (supports friendly aliases)
        if ($request->filled('status')) {
            $status = $request->string('status')->lower()->toString();
            $map = [
                'menunggu' => 'tahap1',
                'menunggu-verifikasi' => 'tahap1',
                'tahap1' => 'tahap1',
                'tahap-1' => 'tahap1',
                'tahap2' => 'tahap2',
                'tahap-2' => 'tahap2',
                'lengkap' => 'lengkap',
                'complete' => 'lengkap',
            ];
            $internal = $map[$status] ?? $status;
            $query->where('status_kelengkapan', $internal);
        }
        
        $karyawans = $query->paginate(15);
        
        // Get data for filters
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        $profesis = Profesi::orderBy('nama_profesi')->get();
        
        // Stats for cards
        $stats = [
            'total' => (clone $query)->toBase()->getCountForPagination(),
            'lengkap' => Karyawan::where('status_kelengkapan', 'lengkap')->count(),
            'tahap1' => Karyawan::where('status_kelengkapan', 'tahap1')->count(),
            'ruangan' => Ruangan::count(),
        ];

        return view('admin.karyawan.index', compact('karyawans', 'ruangans', 'profesis', 'stats'));
    }
    
    /**
     * Display the specified karyawan.
     */
    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['user', 'ruangan', 'profesi', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan']);
        
        return view('admin.karyawan.show', compact('karyawan'));
    }
}
