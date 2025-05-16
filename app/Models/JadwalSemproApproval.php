<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSemproApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_sempro_id',
        'dosen_id',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function jadwalSempro()
    {
        return $this->belongsTo(JadwalSempro::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
