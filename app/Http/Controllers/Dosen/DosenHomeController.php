<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\PengajuanSempro;
use App\Models\JadwalMataKuliah;
use App\Models\JadwalSempro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DosenHomeController extends Controller
{
    public function home(Request $request)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();

        // Jadwal Mata Kuliah Hari Ini
        $today = Carbon::today()->locale('id')->translatedFormat('l'); // Nama hari dalam bahasa Indonesia
        $jadwalMataKuliah = JadwalMataKuliah::where('dosen_id', $dosen->id)
            ->where('hari', $today)
            ->orderBy('pukul')
            ->get();

        // Pengajuan Sempro
        $pengajuanSempro = PengajuanSempro::with(['mahasiswa.user', 'bidangKeilmuan'])
            ->where('dosen_pembimbing_id', $dosen->id)
            ->when($request->search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        // Jadwal Sempro Dijadwalkan (sebagai pembimbing atau penguji)
        $jadwalSempro = JadwalSempro::with(['pengajuanSempro.mahasiswa.user', 'pengajuanSempro.dosenPembimbing'])
            ->where('status', 'dijadwalkan')
            ->where(function ($query) use ($dosen) {
                $query->where('dosen_penguji_1', $dosen->id)
                    ->orWhere('dosen_penguji_2', $dosen->id)
                    ->orWhere('dosen_penguji_3', $dosen->id)
                    ->orWhereHas('pengajuanSempro', function ($q) use ($dosen) {
                        $q->where('dosen_pembimbing_id', $dosen->id);
                    });
            })
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        // Statistik
        $stats = [
            'pending_pengajuan' => PengajuanSempro::where('dosen_pembimbing_id', $dosen->id)
                ->where('status', 'pending')
                ->count(),
            'jadwal_sempro_week' => JadwalSempro::where('status', 'dijadwalkan')
                ->whereBetween('tanggal', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])
                ->where(function ($query) use ($dosen) {
                    $query->where('dosen_penguji_1', $dosen->id)
                        ->orWhere('dosen_penguji_2', $dosen->id)
                        ->orWhere('dosen_penguji_3', $dosen->id)
                        ->orWhereHas('pengajuanSempro', function ($q) use ($dosen) {
                            $q->where('dosen_pembimbing_id', $dosen->id);
                        });
                })
                ->count(),
            'mata_kuliah_week' => JadwalMataKuliah::where('dosen_id', $dosen->id)
                ->whereIn('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])
                ->count(),
        ];

        return view('dosen.home', compact('dosen', 'jadwalMataKuliah', 'pengajuanSempro', 'jadwalSempro', 'stats', 'today'));
    }

    public function approve(Request $request, $id)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $pengajuan = PengajuanSempro::where('dosen_pembimbing_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->update([
            'status' => 'diterima',
        ]);

        return redirect()->route('dosen.home')
            ->with('success', 'Pengajuan sempro berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $pengajuan = PengajuanSempro::where('dosen_pembimbing_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->update([
            'status' => 'ditolak',
        ]);

        return redirect()->route('dosen.home')
            ->with('success', 'Pengajuan sempro berhasil ditolak.');
    }
}
