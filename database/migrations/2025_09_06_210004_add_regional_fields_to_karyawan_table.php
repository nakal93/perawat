<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            // Add regional address fields
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi')->after('alamat');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupaten')->after('provinsi_id');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->after('kabupaten_id');
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan')->after('kecamatan_id');
            $table->string('alamat_detail')->nullable()->after('kelurahan_id'); // Detail alamat seperti nama jalan, RT/RW, dll
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropForeign(['provinsi_id']);
            $table->dropForeign(['kabupaten_id']);
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn(['provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'alamat_detail']);
        });
    }
};
