<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenPembimbing extends Model
{
    use SoftDeletes;
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
