<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalMataKuliah;
use App\Models\JadwalSempro;
use App\Models\Dosen;
use App\Models\JadwalSemproApproval;
use App\Models\PengajuanSempro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    // CRUD untuk Jadwal Mata Kuliah
    public function mataKuliahIndex(Request $request)
    {
        $search = $request->query('search');
        $jadwal = JadwalMataKuliah::with(['dosen.user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('hari', 'like', "%{$search}%")
                        ->orWhere('mata_kuliah', 'like', "%{$search}%")
                        ->orWhere('ruang', 'like', "%{$search}%")
                        ->orWhereHas('dosen.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->paginate(10); // Add pagination
        return view('admin.jadwal.mata-kuliah.index', compact('jadwal', 'search'));
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
    public function semproIndex(Request $request)
    {
        $search = $request->query('search');
        $jadwal = JadwalSempro::with(['pengajuanSempro.mahasiswa.user', 'dosenPenguji1.user', 'dosenPenguji2.user', 'dosenPenguji3.user', 'approvals.dosen'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('pengajuanSempro', function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%")
                            ->orWhereHas('mahasiswa.user', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                        ->orWhere('ruang', 'like', "%{$search}%")
                        ->orWhereHas('dosenPenguji1.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosenPenguji2.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosenPenguji3.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->paginate(10); // Add pagination
        return view('admin.jadwal.sempro.index', compact('jadwal', 'search'));
    }
    public function semproEdit($id)
    {
        $jadwal = JadwalSempro::findOrFail($id);
        // Ambil pengajuan sempro yang belum dijadwalkan, tapi sertakan pengajuan sempro saat ini
        $pengajuanSemproList = PengajuanSempro::whereNotIn('id', JadwalSempro::where('id', '!=', $id)->pluck('pengajuan_sempro_id'))
            ->with('bidangKeilmuan')
            ->get();
        $dosenList = Dosen::has('penguji')->with('bidangKeilmuan')->get();
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

        $pengajuan = PengajuanSempro::findOrFail($request->pengajuan_sempro_id);
        $bidangKeilmuanId = $pengajuan->bidang_keilmuan_id;

        // Validasi bahwa semua dosen penguji memiliki bidang keilmuan yang sama
        foreach (['dosen_penguji_1', 'dosen_penguji_2', 'dosen_penguji_3'] as $field) {
            $dosen = Dosen::findOrFail($request->$field);
            if ($dosen->bidang_keilmuan_id !== $bidangKeilmuanId) {
                return back()->withErrors([$field => 'Dosen penguji harus memiliki bidang keilmuan yang sama dengan pengajuan sempro.']);
            }
        }

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

    public function semproCreate()
    {
        // Ambil pengajuan sempro yang belum dijadwalkan
        $pengajuanSemproList = PengajuanSempro::whereNotIn('id', JadwalSempro::pluck('pengajuan_sempro_id'))
            ->with(['bidangKeilmuan', 'mahasiswa.user'])
            ->get();
        // Ambil dosen yang terdaftar sebagai penguji
        $dosenList = Dosen::has('penguji')->with(['user', 'bidangKeilmuan'])->get();
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
            'waktu' => 'required|in:12:00,13:00,14:00',
            'ruang' => 'required|string|max:50',
            'dosen_penguji_1' => 'required|exists:dosen,id|different:dosen_penguji_2|different:dosen_penguji_3',
            'dosen_penguji_2' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_3',
            'dosen_penguji_3' => 'required|exists:dosen,id|different:dosen_penguji_1|different:dosen_penguji_2',
            'status' => 'required|in:dijadwalkan,selesai',
        ]);

        // Use a transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Create JadwalSempro
            $jadwal = JadwalSempro::create($request->all());

            // Create JadwalSemproApproval for each dosen penguji
            $approvals = [
                [
                    'jadwal_sempro_id' => $jadwal->id,
                    'dosen_id' => $request->dosen_penguji_1,
                    'status' => 'pending',
                    'approved_at' => null,
                ],
                [
                    'jadwal_sempro_id' => $jadwal->id,
                    'dosen_id' => $request->dosen_penguji_2,
                    'status' => 'pending',
                    'approved_at' => null,
                ],
                [
                    'jadwal_sempro_id' => $jadwal->id,
                    'dosen_id' => $request->dosen_penguji_3,
                    'status' => 'pending',
                    'approved_at' => null,
                ],
            ];

            foreach ($approvals as $approval) {
                JadwalSemproApproval::create($approval);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan jadwal sempro dan approval: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.jadwal.sempro.index')->with('success', 'Jadwal sempro dan approval dosen berhasil ditambahkan.');
    }

    public function approvalCreate()
    {
        $jadwalSempro = JadwalSempro::with('pengajuanSempro')->get();
        $dosen = Dosen::with('user')->get();
        return view('admin.jadwal.sempro.create', compact('jadwalSempro', 'dosen'));
    }

    public function approvalStore(Request $request)
    {
        $request->validate([
            'jadwal_sempro_id' => 'required|exists:jadwal_sempro,id',
            'dosen_id' => 'required|exists:dosen,id',
            'status' => 'required|in:pending,setuju,tolak',
        ]);

        JadwalSemproApproval::create([
            'jadwal_sempro_id' => $request->jadwal_sempro_id,
            'dosen_id' => $request->dosen_id,
            'status' => $request->status,
            'approved_at' => $request->status == 'setuju' ? now() : null,
        ]);

        return redirect()->route('admin.jadwal.sempro.index', ['tab' => 'dosen'])
            ->with('success', 'Approval dosen berhasil ditambahkan.');
    }

    public function approvalEdit($id)
    {
        $approval = JadwalSemproApproval::findOrFail($id);
        $jadwalSempro = JadwalSempro::with('pengajuanSempro')->get();
        $dosen = Dosen::with('user')->get();
        return view('admin.jadwal.sempro.approval.edit', compact('approval', 'jadwalSempro', 'dosen'));
    }

    public function approvalUpdate(Request $request, $id)
    {
        $request->validate([
            'jadwal_sempro_id' => 'required|exists:jadwal_sempro,id',
            'dosen_id' => 'required|exists:dosen,id',
            'status' => 'required|in:pending,setuju,tolak',
        ]);

        $approval = JadwalSemproApproval::findOrFail($id);
        $approval->update([
            'jadwal_sempro_id' => $request->jadwal_sempro_id,
            'dosen_id' => $request->dosen_id,
            'status' => $request->status,
            'approved_at' => $request->status == 'setuju' ? now() : null,
        ]);

        return redirect()->route('admin.jadwal.sempro.index', ['tab' => 'dosen'])
            ->with('success', 'Approval dosen berhasil diperbarui.');
    }

    public function approvalDestroy($id)
    {
        $approval = JadwalSemproApproval::findOrFail($id);
        $approval->delete();

        return redirect()->route('admin.jadwal.sempro.index', ['tab' => 'dosen'])
            ->with('success', 'Approval dosen berhasil dihapus.');
    }

    public function editPenguji($jadwalId, $penguji)
    {
        $jadwal = JadwalSempro::with('pengajuanSempro')->findOrFail($jadwalId);

        // Ambil bidang keilmuan dari pengajuan sempro
        $bidangKeilmuanId = $jadwal->pengajuanSempro->bidang_keilmuan_id;

        // Ambil dosen yang:
        // 1. Memiliki bidang keilmuan yang sama dengan pengajuan sempro
        // 2. Terdaftar sebagai dosen penguji
        $dosen = Dosen::where('bidang_keilmuan_id', $bidangKeilmuanId)
            ->whereHas('penguji') // Pastikan dosen memiliki entri di dosen_penguji
            ->with('user')
            ->get();

        $currentDosenId = $jadwal->{"dosen_penguji_$penguji"};
        $approval = JadwalSemproApproval::where('jadwal_sempro_id', $jadwalId)
            ->where('dosen_id', $currentDosenId)
            ->first();
        $currentStatus = $approval ? $approval->status : 'pending';

        return view('admin.jadwal.sempro.approval.edit_penguji', compact('jadwal', 'penguji', 'dosen', 'currentDosenId', 'currentStatus'));
    }

    public function updatePenguji(Request $request, $jadwalId, $penguji)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'status' => 'required|in:pending,setuju,tolak',
        ]);

        $jadwal = JadwalSempro::findOrFail($jadwalId);
        $oldDosenId = $jadwal->{"dosen_penguji_$penguji"};

        // Update dosen penguji di jadwal_sempro
        $jadwal->update(["dosen_penguji_$penguji" => $request->dosen_id]);

        // Update atau buat entri di jadwal_sempro_approvals
        $approval = JadwalSemproApproval::where('jadwal_sempro_id', $jadwalId)
            ->where('dosen_id', $oldDosenId)
            ->first();

        if ($approval) {
            // Jika approval ada untuk dosen lama, hapus atau perbarui
            $approval->delete();
        }

        // Buat approval baru untuk dosen baru
        JadwalSemproApproval::create([
            'jadwal_sempro_id' => $jadwalId,
            'dosen_id' => $request->dosen_id,
            'status' => $request->status,
            'approved_at' => $request->status == 'setuju' ? now() : null,
        ]);

        return redirect()->route('admin.jadwal.sempro.index', ['tab' => 'dosen'])
            ->with('success', "Dosen Penguji $penguji berhasil diganti.");
    }
    public function getDosenJadwal($dosenId)
    {
        $jadwal = JadwalMataKuliah::where('dosen_id', $dosenId)->get(['hari', 'pukul', 'mata_kuliah', 'ruang']);
        return response()->json($jadwal);
    }
}
