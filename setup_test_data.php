<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KategoriDokumen;

// Create admin user
$user = User::where('email', 'admin@test.com')->first();
if (!$user) {
    $user = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
    echo "Admin user created: admin@test.com / password\n";
} else {
    echo "Admin user exists: admin@test.com\n";
}

// Create sample kategori dokumen
$kategoris = ['KTP', 'SIM', 'NPWP', 'Ijazah'];
foreach ($kategoris as $nama) {
    $existing = KategoriDokumen::where('nama_kategori', $nama)->first();
    if (!$existing) {
        KategoriDokumen::create([
            'nama_kategori' => $nama,
            'deskripsi' => 'Dokumen ' . $nama,
            'wajib' => in_array($nama, ['KTP', 'Ijazah'])
        ]);
        echo "Kategori created: $nama\n";
    }
}

echo "Setup completed!\n";
