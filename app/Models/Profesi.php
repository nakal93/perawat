<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    protected $table = 'profesi';
    
    protected $fillable = [
        'nama_profesi',
        'kode_profesi',
        'deskripsi',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
