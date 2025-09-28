<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Alter enum 'status' menambahkan 'rejected' (MySQL/MariaDB only)
        $driver = Config::get('database.default');
        $connectionDriver = Config::get("database.connections.$driver.driver");
        if (in_array($connectionDriver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE users MODIFY status ENUM('pending','approved','active','rejected') DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        // Revert tanpa 'rejected' untuk MySQL/MariaDB
        $driver = Config::get('database.default');
        $connectionDriver = Config::get("database.connections.$driver.driver");
        if (in_array($connectionDriver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE users MODIFY status ENUM('pending','approved','active') DEFAULT 'pending'");
        }
    }
};
