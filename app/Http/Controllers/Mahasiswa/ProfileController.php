<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile($id = null)
    {
        $mahasiswa = $id ? Mahasiswa::with('user')->findOrFail($id) : Mahasiswa::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('mahasiswa.profile.index', compact('mahasiswa'));
    }

    // Update Profile: Mengupdate nama, email, dan password melalui modal
    public function profileUpdate(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $user = $mahasiswa->user;

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|ends_with:@student.com|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
