<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidangKeilmuan extends Model
{
    protected $table = 'bidang_keilmuan';
    protected $fillable = ['name'];

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    public function pengajuanSempro()
    {
        return $this->hasMany(PengajuanSempro::class);
    }

    public $timestamps = false;
}
