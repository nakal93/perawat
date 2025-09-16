<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    protected $table = 'kategori_dokumen';
    
    protected $fillable = [
        'nama_kategori',
        'wajib',
        'deskripsi',
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    public function dokumenKaryawan()
    {
        return $this->hasMany(DokumenKaryawan::class);
    }
}
