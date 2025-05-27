<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\JadwalMataKuliah;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\PengajuanSempro;
use App\Models\HasilSempro;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($mahasiswa) {
            // Ambil pengajuan sempro jika mahasiswa ada
            $pengajuan = PengajuanSempro::where('mahasiswa_id', $mahasiswa->id)->get();

            // Ambil hasil sempro berdasarkan relasi mahasiswa
            $hasilSempro = HasilSempro::whereHas('jadwalSempro.pengajuanSempro', function ($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            })->latest()->first(); // ambil satu yang paling baru jika ada
        } else {
            $pengajuan = collect();
            $hasilSempro = null;
        }

        return view('mahasiswa.home', compact('mahasiswa', 'pengajuan', 'hasilSempro'));
    }
}
