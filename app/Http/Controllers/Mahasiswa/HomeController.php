<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\JadwalMataKuliah;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\PengajuanSempro;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if ($mahasiswa) {
            $pengajuan = PengajuanSempro::where('mahasiswa_id', $mahasiswa->id)->get();
        } else {
            $pengajuan = collect();
        }

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd'); 

        $jadwal = JadwalMataKuliah::where('hari', $hariIni)
            ->with('dosen.user')
            ->get();

        return view('mahasiswa.home', compact('mahasiswa', 'pengajuan', 'jadwal', 'hariIni'));
    }
}
