<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $mahasiswa = Mahasiswa::with(['user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nim', 'like', "%{$search}%")
                        ->orWhere('program_studi', 'like', "%{$search}%")
                        ->orWhere('fakultas', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->withTrashed()->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhere(function ($q) use ($search) {
                            if (stripos('Mahasiswa Tidak Tersedia', $search) !== false) {
                                $q->whereNotNull('deleted_at');
                            }
                        });
                });
            })
            ->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswa', 'search'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|max:30|unique:mahasiswa',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        // Create Mahasiswa
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

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = $mahasiswa->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'nim' => 'required|string|max:30|unique:mahasiswa,nim,' . $mahasiswa->id,
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'asal_kota' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Update User
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        // Update Mahasiswa
        $mahasiswa->update([
            'nim' => $validated['nim'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'asal_kota' => $validated['asal_kota'],
            'program_studi' => $validated['program_studi'],
            'fakultas' => $validated['fakultas'],
            'tahun_masuk' => $validated['tahun_masuk'],
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete(); // Soft delete (will cascade to user due to onDelete('cascade'))
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
