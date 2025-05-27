<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangKeilmuan;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        $bidangKeilmuan = BidangKeilmuan::all();
        return view('admin.users.create', compact('bidangKeilmuan'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,dosen',
        ];

        if ($request->role === 'mahasiswa') {
            $rules = array_merge($rules, [
                'nim' => 'required|string|max:30|unique:mahasiswa',
                'tempat_lahir' => 'required|string|max:50',
                'tanggal_lahir' => 'required|date',
                'asal_kota' => 'required|string|max:100',
                'program_studi' => 'required|string|max:100',
                'fakultas' => 'required|string|max:100',
                'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
            ]);
        } elseif ($request->role === 'dosen') {
            $rules = array_merge($rules, [
                'nip' => 'required|string|max:30|unique:dosen',
                'tempat_lahir' => 'required|string|max:50',
                'tanggal_lahir' => 'required|date',
                'asal_kota' => 'required|string|max:100',
                'bidang_keilmuan_id' => 'required|exists:bidang_keilmuan,id',
            ]);
        }

        $validated = $request->validate($rules);

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create Mahasiswa or Dosen
        if ($validated['role'] === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'asal_kota' => $validated['asal_kota'],
                'program_studi' => $validated['program_studi'],
                'fakultas' => $validated['fakultas'],
                'tahun_masuk' => $validated['tahun_masuk'],
            ]);
        } elseif ($validated['role'] === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'asal_kota' => $validated['asal_kota'],
                'bidang_keilmuan_id' => $validated['bidang_keilmuan_id'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,dosen,mahasiswa',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jika role adalah dosen, soft delete dosen dan relasi
        if ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen) {
                $dosen->pembimbing()->delete();
                $dosen->penguji()->delete();
                $dosen->delete(); // Soft delete dosen
            }
        } elseif ($user->role == 'mahasiswa') {
            Mahasiswa::where('user_id', $user->id)->delete();
        }

        // Soft delete user (jika user juga menggunakan soft delete, lihat langkah tambahan)
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
