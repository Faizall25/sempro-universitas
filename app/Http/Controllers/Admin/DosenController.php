<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenPembimbing;
use App\Models\DosenPenguji;
use App\Models\BidangKeilmuan;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function pembimbingIndex()
    {
        $dosen = Dosen::with('pembimbing')->has('pembimbing')->get();
        return view('admin.dosen.pembimbing.index', compact('dosen'));
    }

    public function pembimbingCreate()
    {
        $dosenList = Dosen::doesntHave('pembimbing')->doesntHave('penguji')->get();
        return view('admin.dosen.pembimbing.create', compact('dosenList'));
    }

    public function pembimbingStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $dosen = Dosen::findOrFail($request->dosen_id);
        if ($dosen->pembimbing || $dosen->penguji) {
            return back()->withErrors(['dosen_id' => 'Dosen ini sudah menjadi pembimbing atau penguji.']);
        }

        DosenPembimbing::create([
            'dosen_id' => $dosen->id,
            'kapasitas_maksimum' => 5,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.dosen.pembimbing.index')
            ->with('success', 'Dosen berhasil ditambahkan sebagai pembimbing.');
    }

    public function pembimbingEdit($id)
    {
        $dosen = Dosen::with('pembimbing')->findOrFail($id);
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.pembimbing.edit', compact('dosen', 'bidangKeilmuan'));
    }

    public function pembimbingUpdate(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $pembimbing = $dosen->pembimbing;

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->user->id,
            'nip' => 'required|string|max:30|unique:dosen,nip,' . $dosen->id,
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'kapasitas_maksimum' => 'required|integer',
            'status_aktif' => 'required|boolean',
        ]);

        $dosen->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $dosen->update([
            'nip' => $request->nip,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'asal_kota' => $request->asal_kota,
            'bidang_keilmuan_id' => $request->bidang_keilmuan_id,
        ]);

        $pembimbing->update([
            'kapasitas_maksimum' => $request->kapasitas_maksimum,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.dosen.pembimbing.index')
            ->with('success', 'Dosen pembimbing berhasil diperbarui.');
    }

    public function pembimbingDestroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->pembimbing()->delete();

        return redirect()->route('admin.dosen.pembimbing.index')
            ->with('success', 'Dosen pembimbing berhasil dihapus dari daftar.');
    }

    public function pengujiIndex()
    {
        $dosen = Dosen::with('penguji')->has('penguji')->get();
        return view('admin.dosen.penguji.index', compact('dosen'));
    }

    public function pengujiCreate()
    {
        $dosenList = Dosen::doesntHave('pembimbing')->doesntHave('penguji')->get();
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.penguji.create', compact('dosenList', 'bidangKeilmuan'));
    }

    public function pengujiStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $dosen = Dosen::findOrFail($request->dosen_id);
        if ($dosen->pembimbing || $dosen->penguji) {
            return back()->withErrors(['dosen_id' => 'Dosen ini sudah menjadi pembimbing atau penguji.']);
        }

        DosenPenguji::create([
            'dosen_id' => $dosen->id,
            'pengalaman_jadi_penguji' => 0,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.dosen.penguji.index')
            ->with('success', 'Dosen berhasil ditambahkan sebagai penguji.');
    }

    public function pengujiEdit($id)
    {
        $dosen = Dosen::with('penguji')->findOrFail($id);
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.penguji.edit', compact('dosen', 'bidangKeilmuan'));
    }

    public function pengujiUpdate(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $penguji = $dosen->penguji;

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->user->id,
            'nip' => 'required|string|max:30|unique:dosen,nip,' . $dosen->id,
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            'pengalaman_jadi_penguji' => 'required|integer',
            'status_aktif' => 'required|boolean',
        ]);

        $dosen->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $dosen->update([
            'nip' => $request->nip,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'asal_kota' => $request->asal_kota,
            'bidang_keilmuan_id' => $request->bidang_keilmuan_id,
        ]);

        $penguji->update([
            'pengalaman_jadi_penguji' => $request->pengalaman_jadi_penguji,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.dosen.penguji.index')
            ->with('success', 'Dosen penguji berhasil diperbarui.');
    }

    public function pengujiDestroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->penguji()->delete();

        return redirect()->route('admin.dosen.penguji.index')
            ->with('success', 'Dosen penguji berhasil dihapus dari daftar.');
    }
}
