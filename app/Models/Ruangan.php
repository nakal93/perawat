<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    
    protected $fillable = [
        'nama_ruangan',
        'kode_ruangan',
        'deskripsi',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
