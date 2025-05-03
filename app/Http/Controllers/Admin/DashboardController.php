<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\PengajuanSempro;
use App\Models\JadwalSempro;
use App\Models\HasilSempro;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik total
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalPengajuan = PengajuanSempro::count();
        $totalJadwal = JadwalSempro::count();
        $totalHasil = HasilSempro::count();

        // Persentase perubahan (minggu ini vs minggu lalu)
        $startOfWeek = Carbon::today()->startOfWeek();
        $startOfLastWeek = $startOfWeek->copy()->subWeek();
        $mahasiswaThisWeek = Mahasiswa::whereBetween('created_at', [$startOfWeek, Carbon::today()])->count();
        $mahasiswaLastWeek = Mahasiswa::whereBetween('created_at', [$startOfLastWeek, $startOfWeek])->count();
        $mahasiswaChange = $mahasiswaLastWeek > 0 ? (($mahasiswaThisWeek - $mahasiswaLastWeek) / $mahasiswaLastWeek * 100) : ($mahasiswaThisWeek > 0 ? 100 : 0);

        $jadwalThisWeek = JadwalSempro::whereBetween('created_at', [$startOfWeek, Carbon::today()])->count();
        $jadwalLastWeek = JadwalSempro::whereBetween('created_at', [$startOfLastWeek, $startOfWeek])->count();
        $jadwalChange = $jadwalLastWeek > 0 ? (($jadwalThisWeek - $jadwalLastWeek) / $jadwalLastWeek * 100) : ($jadwalThisWeek > 0 ? 100 : 0);

        // Data untuk grafik (distribusi status Hasil Sempro)
        $statusCounts = HasilSempro::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Jadwal mendatang (7 hari ke depan, status dijadwalkan)
        $jadwalMendatang = JadwalSempro::with('pengajuanSempro')
            ->where('status', 'dijadwalkan')
            ->where('tanggal', '>=', Carbon::today())
            ->where('tanggal', '<=', Carbon::today()->addDays(7))
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalPengajuan',
            'totalJadwal',
            'totalHasil',
            'mahasiswaChange',
            'jadwalChange',
            'statusCounts',
            'jadwalMendatang'
        ));
    }
}