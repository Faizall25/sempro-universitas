<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSempro extends Model
{
    protected $table = "pengajuan_sempro";
    protected $fillable = [
        'mahasiswa_id',
        'judul',
        'abstrak',
        'jurusan',
        'fakultas',
        'bidang_keilmuan_id',
        'dosen_pembimbing_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function bidangKeilmuan()
    {
        return $this->belongsTo(BidangKeilmuan::class);
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    public function jadwalSempro()
    {
        return $this->hasOne(JadwalSempro::class);
    }
}
