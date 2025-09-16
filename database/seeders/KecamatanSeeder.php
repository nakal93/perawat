<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('kecamatan.json');
        if (!file_exists($file)) {
            $this->command->error('kecamatan.json not found');
            return;
        }

        $json = json_decode(file_get_contents($file), true);
        if (!is_array($json)) {
            $this->command->error('Failed to parse kecamatan.json');
            return;
        }

        // Map full_code kabupaten (4 digit sesuai dataset) => id DB
        $kabMap = Kabupaten::query()->pluck('id', 'full_code')->toArray();

        $batch = [];
        $count = 0;
        foreach ($json as $row) {
            $full = (string)($row['full_code'] ?? '');
            $kabCode = substr($full, 0, 4);
            $kabId = $kabMap[$kabCode] ?? null;
            if (!$kabId) {
                continue; // skip jika kabupaten belum ditemukan
            }

            $batch[] = [
                'kabupaten_id' => $kabId,
                'name' => $row['name'] ?? null,
                'code' => $row['code'] ?? null,
                'full_code' => $full,
            ];
            if (count($batch) >= 1000) {
                Kecamatan::insert($batch);
                $count += count($batch);
                $batch = [];
            }
        }
        if ($batch) {
            Kecamatan::insert($batch);
            $count += count($batch);
        }

        $this->command->info("Kecamatan inserted: {$count}");
    }
}
