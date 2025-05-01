<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard (contoh, akan diperluas nanti)
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Redirect root ke login
Route::get('/', fn() => redirect('/login'));
