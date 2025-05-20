<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSempro;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\BidangKeilmuan;
use Illuminate\Http\Request;

class SemproController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $pengajuanSempro = PengajuanSempro::with(['mahasiswa.user', 'dosenPembimbing.user', 'bidangKeilmuan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('mahasiswa', function ($q) use ($search) {
                        $q->whereHas('user', function ($q) use ($search) {
                            $q->withTrashed()->where('name', 'like', "%{$search}%");
                        });
                    })
                        ->orWhere('judul', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%")
                        ->orWhere('fakultas', 'like', "%{$search}%")
                        ->orWhereHas('dosenPembimbing', function ($q) use ($search) {
                            $q->whereHas('user', function ($q) use ($search) {
                                $q->withTrashed()->where('name', 'like', "%{$search}%");
                            });
                        })
                        ->orWhereHas('bidangKeilmuan', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere(function ($q) use ($search) {
                            if (stripos('Dosen Tidak Tersedia', $search) !== false) {
                                $q->whereHas('dosenPembimbing', function ($q) {
                                    $q->withTrashed()->whereNotNull('deleted_at');
                                });
                            }
                        })
                        ->orWhere(function ($q) use ($search) {
                            if (stripos('Mahasiswa Tidak Tersedia', $search) !== false) {
                                $q->whereHas('mahasiswa', function ($q) {
                                    $q->withTrashed()->whereNotNull('deleted_at');
                                });
                            }
                        });
                });
            })
            ->paginate(10);
        return view('admin.pengajuan-sempro.index', compact('pengajuanSempro', 'search'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::with('user')->get();
        $dosen = Dosen::with('user', 'bidangKeilmuan')->whereHas('pembimbing', function ($query) {
            $query->where('status_aktif', true);
        })->get();
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.pengajuan-sempro.create', compact('mahasiswa', 'dosen', 'bidangKeilmuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'judul' => 'required|string',
            'abstrak' => 'required|string',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        PengajuanSempro::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'judul' => $request->judul,
            'abstrak' => $request->abstrak,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'bidang_keilmuan_id' => $request->bidang_keilmuan_id,
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pengajuan-sempro.index')
            ->with('success', 'Pengajuan sempro berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengajuan = PengajuanSempro::findOrFail($id);
        $mahasiswa = Mahasiswa::with('user')->get();
        $dosen = Dosen::with('user')->whereHas('pembimbing', function ($query) {
            $query->where('status_aktif', true);
        })->get();
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.pengajuan-sempro.edit', compact('pengajuan', 'mahasiswa', 'dosen', 'bidangKeilmuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanSempro::findOrFail($id);

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'judul' => 'required|string',
            'abstrak' => 'required|string',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $pengajuan->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'judul' => $request->judul,
            'abstrak' => $request->abstrak,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'bidang_keilmuan_id' => $request->bidang_keilmuan_id,
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pengajuan-sempro.index')
            ->with('success', 'Pengajuan sempro berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanSempro::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan-sempro.index')
            ->with('success', 'Pengajuan sempro berhasil dihapus.');
    }
}
