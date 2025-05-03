<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BidangKeilmuan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PengajuanSempro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanSemproController extends Controller
{
    public function pengajuanSemproIndex()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $pengajuan = PengajuanSempro::with(['bidangKeilmuan', 'dosenPembimbing.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        $canSubmit = !$pengajuan->whereIn('status', ['pending', 'diterima'])->count();
        $bidangKeilmuan = BidangKeilmuan::all();
        $dosenPembimbing = Dosen::all();

        return view('mahasiswa.pengajuan_sempro.index', compact('pengajuan', 'canSubmit', 'bidangKeilmuan', 'dosenPembimbing'));
    }

    public function pengajuanSemproCreate()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $bidangKeilmuan = BidangKeilmuan::all();
        $dosenPembimbing = Dosen::with('pembimbing')->has('pembimbing')->get();
        $canSubmit = $this->canSubmitNewProposal($mahasiswa->id);
        return view('mahasiswa.pengajuan_sempro.create', compact('mahasiswa', 'bidangKeilmuan', 'dosenPembimbing', 'canSubmit'));
    }

    public function pengajuanSemproStore(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        if (PengajuanSempro::where('mahasiswa_id', $mahasiswa->id)->whereIn('status', ['pending', 'diterima'])->exists()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengajukan proposal baru saat status masih pending atau diterima.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
        ]);

        PengajuanSempro::create([
            'mahasiswa_id' => $mahasiswa->id,
            'judul' => $validated['judul'],
            'abstrak' => $validated['abstrak'],
            'jurusan' => $validated['jurusan'],
            'fakultas' => $validated['fakultas'],
            'bidang_keilmuan_id' => $validated['bidang_keilmuan_id'],
            'dosen_pembimbing_id' => $validated['dosen_pembimbing_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.pengajuan_sempro.index')->with('success', 'Pengajuan berhasil disimpan.');
    }

    public function pengajuanSemproEdit($id)
    {
        $pengajuan = PengajuanSempro::with(['bidangKeilmuan', 'dosenPembimbing'])->findOrFail($id);
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $bidangKeilmuan = BidangKeilmuan::all();
        $dosenPembimbing = Dosen::with('pembimbing')->has('pembimbing')->get();
        $canEdit = $this->canEditProposal($pengajuan, $mahasiswa->id);
        return view('mahasiswa.pengajuan_sempro.edit', compact('pengajuan', 'mahasiswa', 'bidangKeilmuan', 'dosenPembimbing', 'canEdit'));
    }

    public function pengajuanSemproUpdate(Request $request, $id)
    {
        $pengajuan = PengajuanSempro::findOrFail($id);
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        if ($pengajuan->mahasiswa_id !== $mahasiswa->id || $pengajuan->status !== 'pending') {
            return redirect()->back()->with('error', 'Anda tidak dapat mengedit pengajuan ini.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'abstrak' => 'required',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
        ]);

        $pengajuan->update($validated);

        return redirect()->route('mahasiswa.pengajuan_sempro.index')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    private function canSubmitNewProposal($mahasiswaId)
    {
        $activeProposal = PengajuanSempro::where('mahasiswa_id', $mahasiswaId)
            ->whereIn('status', ['pending', 'diterima'])
            ->exists();
        return !$activeProposal;
    }

    private function canEditProposal($pengajuan, $mahasiswaId)
    {
        return $pengajuan->mahasiswa_id === $mahasiswaId && $pengajuan->status === 'pending' && !$pengajuan->jadwalSempro;
    }
}
