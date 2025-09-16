<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Alter enum 'status' menambahkan 'rejected'
        DB::statement("ALTER TABLE users MODIFY status ENUM('pending','approved','active','rejected') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert tanpa 'rejected' (data dengan 'rejected' harus diubah dulu supaya tidak error)
        DB::statement("ALTER TABLE users MODIFY status ENUM('pending','approved','active') DEFAULT 'pending'");
    }
};
