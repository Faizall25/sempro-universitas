<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSempro extends Model
{
    protected $table = "jadwal_sempro";

    protected $fillable = [
        'pengajuan_sempro_id',
        'tanggal',
        'waktu',
        'ruang',
        'dosen_penguji_1',
        'dosen_penguji_2',
        'dosen_penguji_3',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime:H:i',
        'status' => 'string',
    ];

    public function pengajuanSempro()
    {
        return $this->belongsTo(PengajuanSempro::class);
    }

    public function dosenPenguji1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji_1');
    }

    public function dosenPenguji2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji_2');
    }

    public function dosenPenguji3()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji_3');
    }

    public function hasilSempro()
    {
        return $this->hasOne(HasilSempro::class);
    }

    /**
     * Relasi ke JadwalSemproApproval
     */
    public function approvals()
    {
        return $this->hasMany(JadwalSemproApproval::class, 'jadwal_sempro_id');
    }
}
