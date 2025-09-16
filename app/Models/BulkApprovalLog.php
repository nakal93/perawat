<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkApprovalLog extends Model
{
    protected $table = 'bulk_approval_log';
    
    protected $fillable = [
        'admin_id',
        'approved_count',
        'karyawan_list',
        'action_type',
    ];

    protected $casts = [
        'karyawan_list' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
