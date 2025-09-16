<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            RuanganSeeder::class,
            ProfesiSeeder::class,
            KategoriDokumenSeeder::class,
        ]);

        // Ensure default users exist (idempotent)
        User::updateOrCreate(
            ['email' => 'admin@rsdolopo.com'],
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'status' => 'active',
                // set a default password only if not set via factory elsewhere
                'password' => bcrypt('password')
            ]
        );

        User::updateOrCreate(
            ['email' => 'superuser@rsdolopo.com'],
            [
                'name' => 'Super User',
                'role' => 'superuser',
                'status' => 'active',
                'password' => bcrypt('password')
            ]
        );
    }
}
