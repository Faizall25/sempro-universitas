<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $fillable = ['user_id', 'nidn', 'tempat_lahir', 'tanggal_lahir', 'asal_kota', 'bidang_keilmuan_id', 'peran'];

    protected $casts = [
        'peran' => 'string',
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidangKeilmuan()
    {
        return $this->belongsTo(BidangKeilmuan::class);
    }

    public function pengajuanSempro()
    {
        return $this->hasMany(PengajuanSempro::class, 'dosen_pembimbing_id');
    }

    public function jadwalMataKuliah()
    {
        return $this->hasMany(JadwalMataKuliah::class);
    }

    public function jadwalSemproPenguji1()
    {
        return $this->hasMany(JadwalSempro::class, 'dosen_penguji_1');
    }

    public function jadwalSemproPenguji2()
    {
        return $this->hasMany(JadwalSempro::class, 'dosen_penguji_2');
    }

    public function jadwalSemproPenguji3()
    {
        return $this->hasMany(JadwalSempro::class, 'dosen_penguji_3');
    }
}
