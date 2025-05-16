<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DosenProfileController extends Controller
{
    public function profile($id = null)
    {
        $dosen = $id ? Dosen::with('user')->findOrFail($id) : Dosen::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('dosen.profile.index', compact('dosen'));
    }

    public function profileUpdate(Request $request)
    {
        $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();
        $user = $dosen->user;

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|ends_with:@universitas.com|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('dosen.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
