<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMataKuliah extends Model
{
    protected $table = 'jadwal_mata_kuliah';
    protected $fillable = [
        'hari',
        'pukul',
        'kelas',
        'ruang',
        'kode',
        'mata_kuliah',
        'sks',
        'dosen_id',
        'asisten_dosen',
        'mk_jurusan',
        'keterangan'
    ];

    protected $casts = [
        'pukul' => 'datetime:H:i',
        'sks' => 'integer',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
