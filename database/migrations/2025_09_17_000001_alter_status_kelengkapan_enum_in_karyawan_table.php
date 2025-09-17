<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL enum alteration: recreate column with new allowed values
        DB::statement("ALTER TABLE karyawan MODIFY COLUMN status_kelengkapan ENUM('tahap1','tahap2','lengkap') DEFAULT 'tahap1'");
        // Normalize any existing unexpected values
        DB::statement("UPDATE karyawan SET status_kelengkapan='lengkap' WHERE status_kelengkapan NOT IN ('tahap1','tahap2','lengkap')");
    }

    public function down(): void
    {
        // Revert to original two-value enum; set any 'lengkap' back to 'tahap2'
        DB::statement("UPDATE karyawan SET status_kelengkapan='tahap2' WHERE status_kelengkapan='lengkap'");
        DB::statement("ALTER TABLE karyawan MODIFY COLUMN status_kelengkapan ENUM('tahap1','tahap2') DEFAULT 'tahap1'");
    }
};
