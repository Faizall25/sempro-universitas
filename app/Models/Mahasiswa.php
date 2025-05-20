<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use SoftDeletes;
    protected $table = "mahasiswa";
    protected $fillable = [
        'user_id',
        'nim',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_kota',
        'program_studi',
        'fakultas',
        'tahun_masuk'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function pengajuanSempro()
    {
        return $this->hasMany(PengajuanSempro::class);
    }
}
