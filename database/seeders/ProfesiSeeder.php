<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesi;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesi = [
            [
                'nama_profesi' => 'Perawat',
                'kode_profesi' => 'PWT',
                'deskripsi' => 'Tenaga kesehatan profesional perawat',
            ],
            [
                'nama_profesi' => 'Bidan',
                'kode_profesi' => 'BDN',
                'deskripsi' => 'Tenaga kesehatan profesional bidan',
            ],
            [
                'nama_profesi' => 'Dokter',
                'kode_profesi' => 'DOK',
                'deskripsi' => 'Tenaga kesehatan profesional dokter',
            ],
        ];

        foreach ($profesi as $data) {
            Profesi::updateOrCreate(
                ['kode_profesi' => $data['kode_profesi']],
                [
                    'nama_profesi' => $data['nama_profesi'],
                    'deskripsi' => $data['deskripsi'] ?? null,
                ]
            );
        }
    }
}
