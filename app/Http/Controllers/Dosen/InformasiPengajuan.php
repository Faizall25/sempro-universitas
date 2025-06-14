<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalSempro;
use App\Models\JadwalSemproApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InformasiPengajuan extends Controller
{
    public function index(Request $request)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $tab = $request->query('tab', 'seminar-proposal'); // Sesuaikan dengan nilai di URL

        // Ambil jadwal sempro di mana dosen ini adalah penguji
        $jadwalSempro = JadwalSempro::where(function ($query) use ($dosen) {
                $query->where('dosen_penguji_1', $dosen->id)
                    ->orWhere('dosen_penguji_2', $dosen->id)
                    ->orWhere('dosen_penguji_3', $dosen->id);
            })
            ->with(['pengajuanSempro.mahasiswa.user', 'approvals' => function ($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            }])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();

        // Debugging: Cek apakah ada data
        if ($jadwalSempro->isEmpty()) {
            Log::info('Tidak ada jadwal sempro ditemukan untuk dosen ID: ' . $dosen->id . ' sebagai penguji pada tab: ' . $tab);
        }

        return view('dosen.informasi_pengajuan.index', compact('jadwalSempro', 'tab'));
    }

    public function approveJadwalSempro($jadwalId)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $jadwal = JadwalSempro::findOrFail($jadwalId);

        // Cek apakah dosen terlibat sebagai penguji
        if (!$this->isDosenInvolved($jadwal, $dosen)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui jadwal ini.');
        }

        // Cek batas waktu 1 minggu
        if ($jadwal->created_at->diffInDays(now()) > 7) {
            return redirect()->back()->with('error', 'Batas waktu persetujuan telah habis.');
        }

        $approval = JadwalSemproApproval::updateOrCreate(
            ['jadwal_sempro_id' => $jadwal->id, 'dosen_id' => $dosen->id],
            ['status' => 'setuju', 'approved_at' => now()]
        );

        return redirect()->back()->with('success', 'Jadwal berhasil disetujui.');
    }

    public function rejectJadwalSempro($jadwalId)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $jadwal = JadwalSempro::findOrFail($jadwalId);

        // Cek apakah dosen terlibat sebagai penguji
        if (!$this->isDosenInvolved($jadwal, $dosen)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menolak jadwal ini.');
        }

        // Cek batas waktu 1 minggu
        if ($jadwal->created_at->diffInDays(now()) > 7) {
            return redirect()->back()->with('error', 'Batas waktu penolakan telah habis.');
        }

        $approval = JadwalSemproApproval::updateOrCreate(
            ['jadwal_sempro_id' => $jadwal->id, 'dosen_id' => $dosen->id],
            ['status' => 'tolak', 'approved_at' => now()]
        );

        return redirect()->back()->with('success', 'Jadwal berhasil ditolak.');
    }

    private function isDosenInvolved(JadwalSempro $jadwal, Dosen $dosen)
    {
        return $jadwal->dosen_penguji_1 === $dosen->id ||
            $jadwal->dosen_penguji_2 === $dosen->id ||
            $jadwal->dosen_penguji_3 === $dosen->id;
    }
}