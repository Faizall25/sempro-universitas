<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use SoftDeletes;
    protected $table = 'dosen';
    protected $fillable = ['user_id', 'nip', 'tempat_lahir', 'tanggal_lahir', 'asal_kota', 'bidang_keilmuan_id'];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
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

    public function pembimbing()
    {
        return $this->hasOne(DosenPembimbing::class, 'dosen_id');
    }

    public function penguji()
    {
        return $this->hasOne(DosenPenguji::class, 'dosen_id');
    }
}
