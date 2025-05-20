<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenPenguji extends Model
{
    use SoftDeletes;
    protected $table = 'dosen_penguji';

    protected $fillable = [
        'dosen_id',
        'pengalaman_jadi_penguji',
        'status_aktif'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
