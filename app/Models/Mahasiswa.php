<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = "mahasiswa";
    protected $fillable = [
        'user_id',
        'npm',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_kota',
        'program_studi',
        'fakultas',
        'angkatan',
        'tahun_masuk'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'angkatan' => 'integer',
        'tahun_masuk' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuanSempro()
    {
        return $this->hasMany(PengajuanSempro::class);
    }
}
