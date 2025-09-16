<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('kelurahan.json');
        if (!file_exists($file)) {
            $this->command->error('kelurahan.json not found');
            return;
        }

        $json = json_decode(file_get_contents($file), true);
        if (!is_array($json)) {
            $this->command->error('Failed to parse kelurahan.json');
            return;
        }

    // Map full_code kecamatan => id DB
    $kecMap = Kecamatan::query()->pluck('id', 'full_code')->toArray();

        $batch = [];
        $count = 0;
        foreach ($json as $row) {
            $full = (string)($row['full_code'] ?? '');
            // Dataset uses various lengths; use parent kecamatan full_code prefix
            $kecCode = substr($full, 0, 7);
            $kecId = $kecMap[$kecCode] ?? null;
            if (!$kecId) {
                // Try 6-digit fallback (some datasets use 6 for kecamatan code)
                $kecCodeAlt = substr($full, 0, 6);
                $kecId = $kecMap[$kecCodeAlt] ?? null;
                if (!$kecId) {
                    continue; // skip jika kecamatan belum ditemukan
                }
            }

            $batch[] = [
                'kecamatan_id' => $kecId,
                'name' => $row['name'] ?? null,
                'code' => $row['code'] ?? null,
                'full_code' => $full,
                'pos_code' => $row['pos_code'] ?? null,
            ];
            if (count($batch) >= 1000) {
                Kelurahan::insert($batch);
                $count += count($batch);
                $batch = [];
            }
        }
        if ($batch) {
            Kelurahan::insert($batch);
            $count += count($batch);
        }

        $this->command->info("Kelurahan inserted: {$count}");
    }
}
