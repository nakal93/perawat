<?php

namespace Tests\Feature;

use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumenUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
    }

    private function createKaryawanUser(string $name = 'Khusnul'): array
    {
        $user = User::factory()->create([
            'name' => $name,
            'role' => 'karyawan',
            'status' => 'active',
        ]);

        // Minimal master data required by foreign keys
        $ruanganId = \DB::table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruang A',
            'kode_ruangan' => 'R-A',
            'deskripsi' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $profesiId = \DB::table('profesi')->insertGetId([
            'nama_profesi' => 'Perawat',
            'kode_profesi' => 'PRW',
            'deskripsi' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $karyawan = Karyawan::create([
            'user_id' => $user->id,
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Mawar No. 1',
            'jenis_kelamin' => 'Laki-laki',
            'ruangan_id' => $ruanganId,
            'profesi_id' => $profesiId,
            // Use one of the base enum values present in initial migration
            'status_kelengkapan' => 'tahap2',
        ]);

        return [$user, $karyawan];
    }

    public function test_user_uploads_document_with_deterministic_name(): void
    {
        [$user, $karyawan] = $this->createKaryawanUser('Agus Setiawan');
        $kategori = KategoriDokumen::create(['nama_kategori' => 'Ijazah terakhir']);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('random.jpg', 100, 100);

        $response = $this->post(route('dokumen.store'), [
            'kategori_dokumen_id' => $kategori->id,
            'file' => $file,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_berakhir' => now()->addMonth()->toDateString(),
            'berlaku_seumur_hidup' => false,
        ]);

        $response->assertRedirect(route('dokumen.index'));

        $dok = DokumenKaryawan::first();
        $this->assertNotNull($dok, 'DokumenKaryawan should exist');
        $this->assertEquals($karyawan->id, $dok->karyawan_id);
        $this->assertEquals('Agus-Setiawan-Ijazah-terakhir.jpg', $dok->file_name);
        Storage::disk('local')->assertExists($dok->file_path);
    }

    public function test_filename_collision_adds_numeric_suffix(): void
    {
        [$user, $karyawan] = $this->createKaryawanUser('Budi Santoso');
        $kategori = KategoriDokumen::create(['nama_kategori' => 'STR']);

        $this->actingAs($user);

        // First upload
        $file1 = UploadedFile::fake()->create('anything.pdf', 10, 'application/pdf');
        $this->post(route('dokumen.store'), [
            'kategori_dokumen_id' => $kategori->id,
            'file' => $file1,
        ])->assertRedirect();

        $first = DokumenKaryawan::latest('id')->first();
        $this->assertEquals('Budi-Santoso-STR.pdf', $first->file_name);
        Storage::disk('local')->assertExists($first->file_path);

        // Second upload with same base name should get -2 suffix
        $file2 = UploadedFile::fake()->create('else.pdf', 10, 'application/pdf');
        $this->post(route('dokumen.store'), [
            'kategori_dokumen_id' => $kategori->id,
            'file' => $file2,
        ])->assertRedirect();

        $second = DokumenKaryawan::latest('id')->first();
        $this->assertEquals('Budi-Santoso-STR-2.pdf', $second->file_name);
        Storage::disk('local')->assertExists($second->file_path);
    }
}
