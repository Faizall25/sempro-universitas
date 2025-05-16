<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalMataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPerkuliahan extends Controller
{
    public function index(Request $request)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $tab = $request->query('tab', 'jadwal-dosen'); // Default ke jadwal dosen

        if ($tab === 'seluruh-jadwal') {
            // Ambil semua jadwal
            $jadwal = JadwalMataKuliah::with('dosen')->get();
        } else {
            // Ambil jadwal hanya untuk dosen yang login
            $jadwal = JadwalMataKuliah::where('dosen_id', $dosen->id)
                ->with('dosen')
                ->get();
        }

        // Debugging: Cek apakah ada data
        if ($jadwal->isEmpty()) {
            \Log::info('Tidak ada jadwal ditemukan untuk dosen ID: ' . $dosen->id . ' pada tab: ' . $tab);
        }

        return view('dosen.jadwal_perkuliahan.index', compact('jadwal', 'tab'));
    }
}
