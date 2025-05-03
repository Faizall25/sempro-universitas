<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    protected $table = 'dosen_pembimbing';

    protected $fillable = [
        'dosen_id',
        'kapasitas_maksimum',
        'status_aktif'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
