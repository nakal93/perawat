<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawan', 'no_hp')) {
                $table->string('no_hp', 25)->nullable()->after('kampus');
            }
            if (!Schema::hasColumn('karyawan', 'golongan_darah')) {
                $table->string('golongan_darah', 3)->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('karyawan', 'status_perkawinan')) {
                $table->string('status_perkawinan', 30)->nullable()->after('golongan_darah');
            }
            if (!Schema::hasColumn('karyawan', 'nama_ibu_kandung')) {
                $table->string('nama_ibu_kandung', 100)->nullable()->after('status_perkawinan');
            }
            if (!Schema::hasColumn('karyawan', 'tanggal_masuk_kerja')) {
                $table->date('tanggal_masuk_kerja')->nullable()->after('nama_ibu_kandung');
            }
        });
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            foreach (['tanggal_masuk_kerja','nama_ibu_kandung','status_perkawinan','golongan_darah','no_hp'] as $col) {
                if (Schema::hasColumn('karyawan', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
