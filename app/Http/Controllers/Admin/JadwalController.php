<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalMataKuliah;
use App\Models\JadwalSempro;
use App\Models\Dosen;
use App\Models\PengajuanSempro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    // CRUD untuk Jadwal Mata Kuliah
    public function mataKuliahIndex()
    {
        $jadwal = JadwalMataKuliah::with('dosen')->get();
        return view('admin.jadwal.mata-kuliah.index', compact('jadwal'));
    }

    public function mataKuliahCreate()
    {
        $dosenList = Dosen::all();
        return view('admin.jadwal.mata-kuliah.create', compact('dosenList'));
    }

    public function mataKuliahStore(Request $request)
    {
        $request->validate([
            'hari' => 'required|string|max:20',
            'pukul' => 'required|date_format:H:i',
            'kelas' => 'required|string|max:50',
            'ruang' => 'required|string|max:50',
            'kode' => 'required|string|max:20',
            'mata_kuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1',
            'dosen_id' => 'required|exists:dosen,id',
            'asisten_dosen' => 'nullable|string|max:100',
            'mk_jurusan' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        JadwalMataKuliah::create($request->all());

        return redirect()->route('admin.jadwal.mata-kuliah.index')
            ->with('success', 'Jadwal mata kuliah berhasil ditambahkan.');
    }

    public function mataKuliahEdit($id)
    {
        $jadwal = JadwalMataKuliah::findOrFail($id);
        $dosenList = Dosen::all();
        return view('admin.jadwal.mata-kuliah.edit', compact('jadwal', 'dosenList'));
    }

    public function mataKuliahUpdate(Request $request, $id)
    {
        $jadwal = JadwalMataKuliah::findOrFail($id);

        $request->validate([
            'hari' => 'required|string|max:20',
            'pukul' => 'required|date_format:H:i',
            'kelas' => 'required|string|max:50',
            'ruang' => 'required|string|max:50',
            'kode' => 'required|string|max:20',
            'mata_kuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1',
            'dosen_id' => 'required|exists:dosen,id',
            'asisten_dosen' => 'nullable|string|max:100',
            'mk_jurusan' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.mata-kuliah.index')
            ->with('success', 'Jadwal mata kuliah berhasil diperbarui.');
    }

    public function mataKuliahDestroy($id)
    {
        $jadwal = JadwalMataKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.mata-kuliah.index')
            ->with('success', 'Jadwal mata kuliah berhasil dihapus.');
    }

    // CRUD untuk Jadwal Sempro
    public function semproIndex()
    {
        $jadwal = JadwalSempro::with(['pengajuanSempro', 'dosenPenguji1', 'dosenPenguji2', 'dosenPenguji3'])->get();
        return view('admin.jadwal.sempro.index', compact('jadwal'));
    }

    public function semproCreate()
    {
        // Hanya ambil pengajuan sempro yang belum dijadwalkan
        $pengajuanSemproList = PengajuanSempro::whereNotIn('id', JadwalSempro::pluck('pengajuan_sempro_id'))->get();
        $dosenList = Dosen::has('penguji')->get();
        return view('admin.jadwal.sempro.create', compact('pengajuanSemproList', 'dosenList'));
    }

    public function semproStore(Request $request)
    {
        $request->validate([
            'pengajuan_sempro_id' => [
                'required',
                'exists:pengajuan_sempro,id',
                Rule::unique('jadwal_sempro', 'pengajuan_sempro_id'),
            ],
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'ruang' => 'required|string|max:50',
            'dosen_penguji_1' => 'required|exists:dosen,id|different:dosen_penguji_2|different:dosen_penguji_3',
            'dosen_penguji_2' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_3',
            'dosen_penguji_3' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_2',
            'status' => 'required|in:dijadwalkan,selesai',
        ]);

        JadwalSempro::create($request->all());

        return redirect()->route('admin.jadwal.sempro.index')
            ->with('success', 'Jadwal sempro berhasil ditambahkan.');
    }

    public function semproEdit($id)
    {
        $jadwal = JadwalSempro::findOrFail($id);
        // Ambil pengajuan sempro yang belum dijadwalkan, tapi sertakan pengajuan sempro saat ini
        $pengajuanSemproList = PengajuanSempro::whereNotIn('id', JadwalSempro::where('id', '!=', $id)->pluck('pengajuan_sempro_id'))
            ->get();
        $dosenList = Dosen::has('penguji')->get();
        return view('admin.jadwal.sempro.edit', compact('jadwal', 'pengajuanSemproList', 'dosenList'));
    }

    public function semproUpdate(Request $request, $id)
    {
        $jadwal = JadwalSempro::findOrFail($id);

        $request->validate([
            'pengajuan_sempro_id' => [
                'required',
                'exists:pengajuan_sempro,id',
                Rule::unique('jadwal_sempro', 'pengajuan_sempro_id')->ignore($id),
            ],
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'ruang' => 'required|string|max:50',
            'dosen_penguji_1' => 'required|exists:dosen,id|different:dosen_penguji_2|different:dosen_penguji_3',
            'dosen_penguji_2' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_3',
            'dosen_penguji_3' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_2',
            'status' => 'required|in:dijadwalkan,selesai',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.sempro.index')
            ->with('success', 'Jadwal sempro berhasil diperbarui.');
    }

    public function semproDestroy($id)
    {
        $jadwal = JadwalSempro::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.sempro.index')
            ->with('success', 'Jadwal sempro berhasil dihapus.');
    }
}
