<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Provinsi;
use App\Models\Kabupaten;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('kabupaten.json');
        if (!file_exists($file)) {
            $this->command->error('kabupaten.json not found');
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Hapus data kabupaten, kecamatan, kelurahan untuk menghindari FK issues
        DB::table('kelurahan')->truncate();
        DB::table('kecamatan')->truncate();
        DB::table('kabupaten')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $json = json_decode(file_get_contents($file), true);
        if (!is_array($json)) {
            $this->command->error('Failed to parse kabupaten.json');
            return;
        }

        // Map kode provinsi => id DB
        $provMap = Provinsi::query()->pluck('id', 'code')->toArray();

        $batch = [];
        $count = 0;
        foreach ($json as $row) {
            $full = (string)($row['full_code'] ?? '');
            $provCode = substr($full, 0, 2);
            $provId = $provMap[$provCode] ?? null;
            if (!$provId) {
                continue; // skip jika provinsi belum ada
            }

            $batch[] = [
                'provinsi_id' => $provId,
                'type' => $row['type'] ?? null,
                'name' => $row['name'] ?? null,
                'code' => $row['code'] ?? null,
                'full_code' => $full,
            ];
            if (count($batch) >= 1000) {
                Kabupaten::insert($batch);
                $count += count($batch);
                $batch = [];
            }
        }
        if ($batch) {
            Kabupaten::insert($batch);
            $count += count($batch);
        }

        $this->command->info("Kabupaten inserted: {$count}");
    }
}
