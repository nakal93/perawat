<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriDokumen;

class KategoriDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'SIP (Surat Izin Praktik)',
                'wajib' => true,
                'deskripsi' => 'Surat izin praktik untuk tenaga kesehatan',
            ],
            [
                'nama_kategori' => 'STR (Surat Tanda Registrasi)',
                'wajib' => true,
                'deskripsi' => 'Surat tanda registrasi tenaga kesehatan',
            ],
            [
                'nama_kategori' => 'SIKP (Surat Izin Kerja Perawat)',
                'wajib' => true,
                'deskripsi' => 'Surat izin kerja khusus perawat',
            ],
            [
                'nama_kategori' => 'Sertifikat Pelatihan',
                'wajib' => false,
                'deskripsi' => 'Sertifikat pelatihan tambahan',
            ],
            [
                'nama_kategori' => 'SK Keputusan',
                'wajib' => false,
                'deskripsi' => 'Surat keputusan dari instansi terkait',
            ],
            [
                'nama_kategori' => 'Transkrip Nilai',
                'wajib' => true,
                'deskripsi' => 'Transkrip nilai pendidikan terakhir',
            ],
            [
                'nama_kategori' => 'SK Kewenangan Klinis',
                'wajib' => false,
                'deskripsi' => 'Surat keputusan kewenangan klinis',
            ],
        ];

        foreach ($kategori as $data) {
            KategoriDokumen::updateOrCreate(
                ['nama_kategori' => $data['nama_kategori']],
                [
                    'wajib' => $data['wajib'],
                    'deskripsi' => $data['deskripsi'] ?? null,
                ]
            );
        }
    }
}
