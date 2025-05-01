<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSempro extends Model
{
    protected $table = 'hasil_sempro';
    protected $fillable = [
        'jadwal_sempro_id',
        'nilai_peng1',
        'nilai_peng2',
        'nilai_peng3',
        'rata_rata',
        'status',
        'revisi_file_path'
    ];

    protected $casts = [
        'nilai_peng1' => 'float',
        'nilai_peng2' => 'float',
        'nilai_peng3' => 'float',
        'rata_rata' => 'float',
        'status' => 'string',
    ];

    public function jadwalSempro()
    {
        return $this->belongsTo(JadwalSempro::class);
    }
}
