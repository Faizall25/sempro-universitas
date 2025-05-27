<?php

namespace App\Http\Controllers\Dosen;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\JadwalMataKuliah;
use App\Models\PengajuanSempro;
use Illuminate\Http\Request;

class DosenHomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        $jadwal = collect();
        $pengajuan = collect();

        if ($dosen) {
            // Ambil hari ini dalam format lokal bahasa Indonesia
            $hariIni = Carbon::now()->locale('id')->isoFormat('dddd'); // contoh: "Senin", "Selasa", dll.

            // Ambil jadwal dosen hanya untuk hari ini
            $jadwal = JadwalMataKuliah::with('dosen.user')
                ->where('dosen_id', $dosen->id)
                ->where('hari', $hariIni)
                ->get();

            // Ambil pengajuan sempro yang dibimbing oleh dosen login
            $pengajuan = PengajuanSempro::with(['mahasiswa.user', 'dosenPembimbing.user'])
                ->where('dosen_pembimbing_id', $dosen->id)
                ->get();
        }

        return view('dosen.home', compact('dosen', 'jadwal', 'pengajuan'));
    }
}
