<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::with([
            'user',
            'ruangan',
            'profesi',
            'statusPegawai',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'dokumen.kategoriDokumen'
        ])->withCount('dokumen');
        
        // Filter berdasarkan input
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        
        if ($request->filled('profesi_id')) {
            $query->where('profesi_id', $request->profesi_id);
        }
        
        if ($request->filled('status_pegawai_id')) {
            $query->where('status_pegawai_id', $request->status_pegawai_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }

        // Jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Tanggal masuk range
        if ($request->filled('tanggal_masuk_from')) {
            $query->whereDate('tanggal_masuk_kerja', '>=', $request->tanggal_masuk_from);
        }
        if ($request->filled('tanggal_masuk_to')) {
            $query->whereDate('tanggal_masuk_kerja', '<=', $request->tanggal_masuk_to);
        }
        
        // Filter status kelengkapan
        if ($request->filled('status_kelengkapan')) {
            $statusFilter = $request->status_kelengkapan;
            
            if ($statusFilter === 'lengkap') {
                $query->where('status_kelengkapan', 'lengkap');
            } elseif ($statusFilter === 'belum_lengkap') {
                $query->where('status_kelengkapan', '!=', 'lengkap');
            } elseif ($statusFilter === 'dokumen_lengkap') {
                // Filter karyawan yang dokumen wajibnya lengkap
                $kategoriWajib = \App\Models\KategoriDokumen::where('wajib', true)->pluck('id');
                $query->whereHas('dokumen', function($q) use ($kategoriWajib) {
                    $q->whereIn('kategori_dokumen_id', $kategoriWajib)
                      ->havingRaw('COUNT(DISTINCT kategori_dokumen_id) = ?', [$kategoriWajib->count()]);
                });
            } elseif ($statusFilter === 'dokumen_belum_lengkap') {
                // Filter karyawan yang dokumen wajibnya belum lengkap
                $kategoriWajib = \App\Models\KategoriDokumen::where('wajib', true)->pluck('id');
                $query->whereDoesntHave('dokumen', function($q) use ($kategoriWajib) {
                    $q->whereIn('kategori_dokumen_id', $kategoriWajib)
                      ->havingRaw('COUNT(DISTINCT kategori_dokumen_id) = ?', [$kategoriWajib->count()]);
                });
            }
        }
        
        $karyawan = $query->paginate(15);
        
        // Data untuk dropdown filter
        $ruangan = \App\Models\Ruangan::orderBy('nama_ruangan')->get();
        $profesi = \App\Models\Profesi::orderBy('nama_profesi')->get();
        $statusPegawai = \App\Models\StatusPegawai::orderBy('nama')->get();
        
        return view('admin.laporan', compact('karyawan', 'ruangan', 'profesi', 'statusPegawai'));
    }
    
    public function exportCsv(Request $request)
    {
        $query = Karyawan::with([
            'user',
            'ruangan',
            'profesi',
            'statusPegawai',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
        ])->withCount('dokumen');
        
        // Terapkan filter yang sama dengan index
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        
        if ($request->filled('profesi_id')) {
            $query->where('profesi_id', $request->profesi_id);
        }
        
        if ($request->filled('status_pegawai_id')) {
            $query->where('status_pegawai_id', $request->status_pegawai_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }

        // Jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Tanggal masuk range
        if ($request->filled('tanggal_masuk_from')) {
            $query->whereDate('tanggal_masuk_kerja', '>=', $request->tanggal_masuk_from);
        }
        if ($request->filled('tanggal_masuk_to')) {
            $query->whereDate('tanggal_masuk_kerja', '<=', $request->tanggal_masuk_to);
        }
        
        $fileName = 'laporan_karyawan_' . date('Y-m-d_H-i-s') . '.csv';
        
        return new StreamedResponse(function() use ($query) {
            $handle = fopen('php://output', 'w');
            // Tulis BOM agar Excel mengenali UTF-8
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Header CSV
            fputcsv($handle, [
                'NIK',
                'NIP', 
                'Nama Lengkap',
                'Email',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'No HP',
                'Provinsi',
                'Kabupaten/Kota',
                'Kecamatan',
                'Kelurahan',
                'Alamat Detail',
                'Ruangan',
                'Profesi',
                'Status Pegawai',
                'Tanggal Masuk',
                'Agama',
                'Pendidikan Terakhir',
                'Gelar',
                'Kampus',
                'Golongan Darah',
                'Status Perkawinan',
                'Nama Ibu Kandung',
                'Jumlah Dokumen',
                'Status Kelengkapan'
            ]);
            
            // Data rows
            $query->chunk(100, function($karyawan) use ($handle) {
                foreach ($karyawan as $k) {
                    // Tanggal bisa berupa string atau Carbon; fallback ke string apa adanya
                    $tglLahir = method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : ($k->tanggal_lahir ?: '-');
                    $tglMasuk = method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : ($k->tanggal_masuk_kerja ?: '-');

                    fputcsv($handle, [
                        $k->nik ?: '-',
                        $k->nip ?: '-',
                        $k->user->name ?? '-',
                        $k->user->email ?? '-',
                        $k->jenis_kelamin ?: '-',
                        $tglLahir,
                        $k->no_hp ?: '-',
                        $k->provinsi->name ?? '-',
                        $k->kabupaten->name ?? '-',
                        $k->kecamatan->name ?? '-',
                        $k->kelurahan->name ?? '-',
                        $k->alamat_detail ?: '-',
                        $k->ruangan->nama_ruangan ?? '-',
                        $k->profesi->nama_profesi ?? '-',
                        $k->statusPegawai->nama ?? '-',
                        $tglMasuk,
                        $k->agama ?: '-',
                        $k->pendidikan_terakhir ?: '-',
                        $k->gelar ?: '-',
                        $k->kampus ?: '-',
                        $k->golongan_darah ?: '-',
                        $k->status_perkawinan ?: '-',
                        $k->nama_ibu_kandung ?: '-',
                        $k->dokumen_count ?? 0,
                        $k->status_kelengkapan ?: 'Belum Lengkap'
                    ]);
                }
            });
            
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
    
    public function print(Request $request)
    {
        $query = Karyawan::with([
            'user',
            'ruangan',
            'profesi',
            'statusPegawai',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
        ])->withCount('dokumen');
        
        // Terapkan filter yang sama
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        
        if ($request->filled('profesi_id')) {
            $query->where('profesi_id', $request->profesi_id);
        }
        
        if ($request->filled('status_pegawai_id')) {
            $query->where('status_pegawai_id', $request->status_pegawai_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }

        // Jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Tanggal masuk range
        if ($request->filled('tanggal_masuk_from')) {
            $query->whereDate('tanggal_masuk_kerja', '>=', $request->tanggal_masuk_from);
        }
        if ($request->filled('tanggal_masuk_to')) {
            $query->whereDate('tanggal_masuk_kerja', '<=', $request->tanggal_masuk_to);
        }
        
        $karyawan = $query->get();
        $filters = $request->only(['ruangan_id', 'profesi_id', 'status_pegawai_id', 'search']);
        
        return view('admin.laporan-print', compact('karyawan', 'filters'));
    }
}