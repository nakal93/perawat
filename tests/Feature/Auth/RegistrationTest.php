<?php

namespace Tests\Feature\Auth;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Ruangan;
use App\Models\Profesi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        // Create required master data for registration test
        $provinsi = Provinsi::create(['id' => 1, 'code' => '11', 'name' => 'Test Provinsi']);
        $kabupaten = Kabupaten::create([
            'id' => 1, 
            'provinsi_id' => 1, 
            'type' => 'Kabupaten',
            'code' => '1101', 
            'full_code' => '11.01',
            'name' => 'Test Kabupaten'
        ]);
        $kecamatan = Kecamatan::create([
            'id' => 1, 
            'kabupaten_id' => 1, 
            'code' => '110101', 
            'full_code' => '11.01.01',
            'name' => 'Test Kecamatan'
        ]);
        $kelurahan = Kelurahan::create([
            'id' => 1, 
            'kecamatan_id' => 1, 
            'code' => '1101010001', 
            'full_code' => '11.01.01.0001',
            'pos_code' => '12345',
            'name' => 'Test Kelurahan'
        ]);
        $ruangan = Ruangan::create([
            'id' => 1, 
            'nama_ruangan' => 'Test Ruangan',
            'kode_ruangan' => 'TR01',
            'deskripsi' => 'Test Description'
        ]);
        $profesi = Profesi::create([
            'id' => 1, 
            'nama_profesi' => 'Test Profesi',
            'kode_profesi' => 'TP01',
            'deskripsi' => 'Test Description'
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nik' => '3171010101000999',
            'alamat' => 'Test Address',
            'provinsi_id' => 1,
            'kabupaten_id' => 1,
            'kecamatan_id' => 1,
            'kelurahan_id' => 1,
            'alamat_detail' => 'Test Detail Address',
            'jenis_kelamin' => 'Laki-laki',
            'ruangan_id' => 1,
            'profesi_id' => 1,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
