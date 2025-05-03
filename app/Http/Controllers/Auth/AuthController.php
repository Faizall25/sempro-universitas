<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil role pengguna setelah autentikasi berhasil
            $role = Auth::user()->role;

            // Validasi domain email berdasarkan role
            if (str_ends_with($request->email, '@student.com') && $role !== 'mahasiswa') {
                Auth::logout();
                return back()->withErrors(['email' => 'Email ini hanya untuk mahasiswa.']);
            }

            if (str_ends_with($request->email, '@universitas.com') && !in_array($role, ['dosen', 'admin'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Email ini hanya untuk dosen atau admin.']);
            }

            // Redirect berdasarkan role
            switch ($role) {
                case 'mahasiswa':
                    return redirect()->intended('/mahasiswa/home');
                case 'dosen':
                    return redirect()->intended('/dosen/dashboard');
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                    // return view('admin.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        // Jika autentikasi gagal
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
