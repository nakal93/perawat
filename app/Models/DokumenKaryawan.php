<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenKaryawan extends Model
{
    protected $table = 'dokumen_karyawan';
    
    protected $fillable = [
        'karyawan_id',
        'kategori_dokumen_id',
        'file_path',
        'file_name',
        'tanggal_mulai',
        'tanggal_berakhir',
        'berlaku_seumur_hidup',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'berlaku_seumur_hidup' => 'boolean',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kategoriDokumen()
    {
        return $this->belongsTo(KategoriDokumen::class);
    }
}
