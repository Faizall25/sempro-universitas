<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSemproApproval extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sempro_approvals';

    protected $fillable = [
        'jadwal_sempro_id',
        'dosen_id',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'status' => 'string', // Enum: 'pending', 'setuju', 'tolak'
        'approved_at' => 'datetime',
    ];

    /**
     * Relasi ke JadwalSempro
     */
    public function jadwalSempro()
    {
        return $this->belongsTo(JadwalSempro::class, 'jadwal_sempro_id');
    }

    /**
     * Relasi ke Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
