<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    protected $table = 'status_pegawai';
    protected $fillable = ['nama'];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'status_pegawai_id');
    }
}
