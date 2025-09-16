<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        // Create superuser
        // Create sample karyawan
        // no-op
        $this->command->info('No operations performed to prevent duplicate data creation.');
    }
}
