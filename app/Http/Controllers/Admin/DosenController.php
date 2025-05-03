<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenPembimbing;
use App\Models\DosenPenguji;
use App\Models\BidangKeilmuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    // CRUD untuk Semua Dosen
    public function allIndex()
    {
        $dosen = Dosen::with(['user', 'bidangKeilmuan'])->get();
        return view('admin.dosen.all.index', compact('dosen'));
    }

    public function allCreate()
    {
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.all.create', compact('bidangKeilmuan'));
    }

    public function allStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:30|unique:dosen,nip',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'), // Password default, bisa diubah oleh dosen
            'role' => 'dosen',
        ]);

        // Buat dosen baru
        Dosen::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'asal_kota' => $request->asal_kota,
            'bidang_keilmuan_id' => $request->bidang_keilmuan_id,
        ]);

        return redirect()->route('admin.dosen.all.index')
            ->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function allEdit($id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.all.edit', compact('dosen', 'bidangKeilmuan'));
    }

    public function allUpdate(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->user->id,
            'nip' => 'required|string|max:30|unique:dosen,nip,' . $dosen->id,
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
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

        return redirect()->route('admin.dosen.all.index')
            ->with('success', 'Dosen berhasil diperbarui.');
    }

    public function allDestroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        // Hapus relasi pembimbing dan penguji
        $dosen->pembimbing()->delete();
        $dosen->penguji()->delete();

        // Hapus user terkait
        $dosen->user()->delete();

        $dosen->delete();

        return redirect()->route('admin.dosen.all.index')
            ->with('success', 'Dosen berhasil dihapus.');
    }

    // CRUD untuk Dosen Pembimbing
    public function pembimbingIndex()
    {
        $dosen = Dosen::with('pembimbing')->has('pembimbing')->get();
        return view('admin.dosen.pembimbing.index', compact('dosen'));
    }

    public function pembimbingCreate()
    {
        $dosenList = Dosen::with(['pembimbing', 'penguji'])->get();
        return view('admin.dosen.pembimbing.create', compact('dosenList'));
    }

    public function pembimbingStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'kapasitas_maksimum' => 'required|integer|min:1',
        ]);

        $dosen = Dosen::findOrFail($request->dosen_id);
        if ($dosen->pembimbing) {
            return back()->withErrors(['dosen_id' => 'Dosen ini sudah menjadi pembimbing.']);
        }

        DosenPembimbing::create([
            'dosen_id' => $dosen->id,
            'kapasitas_maksimum' => $request->kapasitas_maksimum,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.dosen.pembimbing.index')
            ->with('success', 'Dosen berhasil ditambahkan sebagai pembimbing.');
    }

    public function pembimbingEdit($id)
    {
        $dosen = Dosen::with('pembimbing')->findOrFail($id);
        return view('admin.dosen.pembimbing.edit', compact('dosen'));
    }

    public function pembimbingUpdate(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $pembimbing = $dosen->pembimbing;

        $request->validate([
            'kapasitas_maksimum' => 'required|integer|min:1',
            'status_aktif' => 'required|boolean',
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

    // CRUD untuk Dosen Penguji
    public function pengujiIndex()
    {
        $dosen = Dosen::with('penguji')->has('penguji')->get();
        return view('admin.dosen.penguji.index', compact('dosen'));
    }

    public function pengujiCreate()
    {
        $dosenList = Dosen::with(['pembimbing', 'penguji'])->get();
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.dosen.penguji.create', compact('dosenList', 'bidangKeilmuan'));
    }

    public function pengujiStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $dosen = Dosen::findOrFail($request->dosen_id);
        if ($dosen->penguji) {
            return back()->withErrors(['dosen_id' => 'Dosen ini sudah menjadi penguji.']);
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

    public function pengujiToggleStatus(Request $request, $id)
    {
        $dosen = Dosen::with('penguji')->findOrFail($id);
        $penguji = $dosen->penguji;

        $penguji->update([
            'status_aktif' => !$penguji->status_aktif,
        ]);

        return redirect()->route('admin.dosen.penguji.index')
            ->with('success', 'Status dosen penguji berhasil diubah.');
    }

    public function pengujiDestroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->penguji()->delete();

        return redirect()->route('admin.dosen.penguji.index')
            ->with('success', 'Dosen penguji berhasil dihapus dari daftar.');
    }
}
