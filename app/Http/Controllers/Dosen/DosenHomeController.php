<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenHomeController extends Controller
{
    public function home()
    {
        $user = auth()->user();
        $dosen = \App\Models\Dosen::where('user_id', $user->id)->first();

        $jadwal = [];
        $pengajuan = [];

        if ($dosen) {
            $jadwal = \App\Models\JadwalMataKuliah::with('dosen.user')
                ->where('dosen_id', $dosen->id)
                ->get();

            // Ambil hanya pengajuan sempro yang dibimbing oleh dosen login
            $pengajuan = \App\Models\PengajuanSempro::with(['mahasiswa.user', 'dosenPembimbing.user'])
                ->where('dosen_pembimbing_id', $dosen->id)
                ->get();
        }

        return view('dosen.home', compact('dosen', 'jadwal', 'pengajuan'));
    }
}
