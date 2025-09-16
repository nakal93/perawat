<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    
    protected $fillable = [
        'user_id',
        'nik',
    'nip',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'alamat_detail',
        'jenis_kelamin',
    'tanggal_lahir',
        'ruangan_id',
        'profesi_id',
    'status_pegawai_id',
        'foto_profil',
        'agama',
        'pendidikan_terakhir',
        'gelar',
        'kampus',
    'no_hp',
    'golongan_darah',
    'status_perkawinan',
    'nama_ibu_kandung',
    'tanggal_masuk_kerja',
        'status_kelengkapan',
        'qr_token',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            if (empty($model->qr_token)) {
                try {
                    $model->qr_token = bin2hex(random_bytes(16)); // 32 chars to fit legacy column
                } catch (\Throwable $e) {
                    // fallback sederhana jika random_bytes gagal
                    $model->qr_token = uniqid('qr', true);
                }
            }
        });
    }

    public function ensureQrToken(): string
    {
        if (!$this->qr_token) {
            $this->qr_token = bin2hex(random_bytes(16)); // 32 hex chars
            $this->save();
        }
        return $this->qr_token;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function profesi()
    {
        return $this->belongsTo(Profesi::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenKaryawan::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function statusPegawai()
    {
        return $this->belongsTo(StatusPegawai::class, 'status_pegawai_id');
    }
}
