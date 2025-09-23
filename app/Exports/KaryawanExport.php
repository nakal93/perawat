<?php

namespace App\Exports;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KaryawanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        // Re-apply filters similar to controller's applyFilters
        $query = Karyawan::with([
            'user', 'ruangan', 'profesi', 'statusPegawai',
            'provinsi', 'kabupaten', 'kecamatan', 'kelurahan',
        ])->withCount('dokumen');

        $r = $this->request;
        if ($r->filled('ruangan_id')) $query->where('ruangan_id', $r->ruangan_id);
        if ($r->filled('profesi_id')) $query->where('profesi_id', $r->profesi_id);
        if ($r->filled('status_pegawai_id')) $query->where('status_pegawai_id', $r->status_pegawai_id);
        if ($r->filled('jenis_kelamin')) $query->where('jenis_kelamin', $r->jenis_kelamin);
        if ($r->filled('tanggal_masuk_from')) $query->whereDate('tanggal_masuk_kerja', '>=', $r->tanggal_masuk_from);
        if ($r->filled('tanggal_masuk_to')) $query->whereDate('tanggal_masuk_kerja', '<=', $r->tanggal_masuk_to);
        if ($r->filled('search')) {
            $search = $r->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }
        // status_kelengkapan
        if ($r->filled('status_kelengkapan')) {
            $status = $r->status_kelengkapan;
            if ($status === 'lengkap') {
                $query->where('status_kelengkapan', 'lengkap');
            } elseif ($status === 'belum_lengkap') {
                $query->where(function ($q) {
                    $q->whereNull('status_kelengkapan')
                      ->orWhere('status_kelengkapan', '!=', 'lengkap');
                });
            } elseif (in_array($status, ['dokumen_lengkap', 'dokumen_belum_lengkap'])) {
                $kategoriWajib = \App\Models\KategoriDokumen::where('wajib', true)->pluck('id');
                if ($kategoriWajib->count() > 0) {
                    if ($status === 'dokumen_lengkap') {
                        $query->whereHas('dokumen', function($q) use ($kategoriWajib) {
                            $q->whereIn('kategori_dokumen_id', $kategoriWajib);
                        }, '>=', $kategoriWajib->count());
                    } else {
                        $query->where(function ($q) use ($kategoriWajib) {
                            $q->whereDoesntHave('dokumen', function($qq) use ($kategoriWajib) {
                                $qq->whereIn('kategori_dokumen_id', $kategoriWajib);
                            })
                            ->orWhereHas('dokumen', function($qq) use ($kategoriWajib) {
                                $qq->whereIn('kategori_dokumen_id', $kategoriWajib);
                            }, '<', $kategoriWajib->count());
                        });
                    }
                }
            }
        }

        return $query->orderBy('id');
    }

    public function headings(): array
    {
        return [
            'NIK', 'NIP', 'Nama Lengkap', 'Email', 'Jenis Kelamin', 'Tanggal Lahir', 'No HP',
            'Provinsi', 'Kabupaten/Kota', 'Kecamatan', 'Kelurahan', 'Alamat Detail',
            'Ruangan', 'Profesi', 'Status Pegawai', 'Tanggal Masuk', 'Agama',
            'Pendidikan Terakhir', 'Gelar', 'Kampus', 'Golongan Darah', 'Status Perkawinan',
            'Nama Ibu Kandung', 'Jumlah Dokumen', 'Status Kelengkapan'
        ];
    }

    public function map($k): array
    {
        $tglLahir = method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : ($k->tanggal_lahir ?: '-');
        $tglMasuk = method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : ($k->tanggal_masuk_kerja ?: '-');

        return [
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
            $k->status_kelengkapan ?: 'Belum Lengkap',
        ];
    }
}
