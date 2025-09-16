<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangan = [
            [
                'nama_ruangan' => 'Gatotkaca',
                'kode_ruangan' => 'GTK',
                'deskripsi' => 'Ruangan Gatotkaca untuk perawatan umum',
            ],
            [
                'nama_ruangan' => 'Bima',
                'kode_ruangan' => 'BIM',
                'deskripsi' => 'Ruangan Bima untuk perawatan khusus',
            ],
            [
                'nama_ruangan' => 'Nakula Sadewa',
                'kode_ruangan' => 'NKS',
                'deskripsi' => 'Ruangan Nakula Sadewa untuk perawatan intensif',
            ],
        ];

        foreach ($ruangan as $data) {
            Ruangan::updateOrCreate(
                ['kode_ruangan' => $data['kode_ruangan']],
                [
                    'nama_ruangan' => $data['nama_ruangan'],
                    'deskripsi' => $data['deskripsi'] ?? null,
                ]
            );
        }
    }
}
