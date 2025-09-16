<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('status_pegawai')) {
            Schema::create('status_pegawai', function (Blueprint $table) {
                $table->id();
                $table->string('nama')->unique(); // PNS, PPPK, PKWT, BLUD
                $table->timestamps();
            });
        }

        Schema::table('karyawan', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawan', 'status_pegawai_id')) {
                $table->foreignId('status_pegawai_id')->nullable()->constrained('status_pegawai')->nullOnDelete()->after('profesi_id');
            }
            if (!Schema::hasColumn('karyawan', 'nip')) {
                $table->string('nip', 30)->nullable()->unique()->after('nik');
            }
            if (!Schema::hasColumn('karyawan', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            }
        });

        // Seed default values if empty
        $defaults = ['PNS', 'PPPK', 'PKWT', 'BLUD'];
        $existing = DB::table('status_pegawai')->pluck('nama')->toArray();
        foreach ($defaults as $d) {
            if (!in_array($d, $existing)) {
                DB::table('status_pegawai')->insert([
                    'nama' => $d,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            if (Schema::hasColumn('karyawan', 'status_pegawai_id')) {
                $table->dropConstrainedForeignId('status_pegawai_id');
            }
            if (Schema::hasColumn('karyawan', 'nip')) {
                $table->dropUnique(['nip']);
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('karyawan', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }
        });

        Schema::dropIfExists('status_pegawai');
    }
};
