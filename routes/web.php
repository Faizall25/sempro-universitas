<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mahasiswa\HomeController;
use App\Http\Controllers\Mahasiswa\PengajuanSemproController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/dosen/pembimbing', [DosenController::class, 'pembimbingIndex'])->name('admin.dosen.pembimbing.index');
    Route::get('/dosen/pembimbing/create', [DosenController::class, 'pembimbingCreate'])->name('admin.dosen.pembimbing.create');
    Route::post('/dosen/pembimbing', [DosenController::class, 'pembimbingStore'])->name('admin.dosen.pembimbing.store');
    Route::get('/dosen/pembimbing/{id}/edit', [DosenController::class, 'pembimbingEdit'])->name('admin.dosen.pembimbing.edit');
    Route::put('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingUpdate'])->name('admin.dosen.pembimbing.update');
    Route::delete('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingDestroy'])->name('admin.dosen.pembimbing.destroy');

    Route::get('/dosen/penguji', [DosenController::class, 'pengujiIndex'])->name('admin.dosen.penguji.index');
    Route::get('/dosen/penguji/create', [DosenController::class, 'pengujiCreate'])->name('admin.dosen.penguji.create');
    Route::post('/dosen/penguji', [DosenController::class, 'pengujiStore'])->name('admin.dosen.penguji.store');
    Route::get('/dosen/penguji/{id}/edit', [DosenController::class, 'pengujiEdit'])->name('admin.dosen.penguji.edit');
    Route::put('/dosen/penguji/{id}', [DosenController::class, 'pengujiUpdate'])->name('admin.dosen.penguji.update');
    Route::delete('/dosen/penguji/{id}', [DosenController::class, 'pengujiDestroy'])->name('admin.dosen.penguji.destroy');
});

// Rute Dashboard Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/home', [HomeController::class, 'home'])->name('mahasiswa.home');

    Route::get('/mahasiswa/profile', [ProfileController::class, 'profile'])->name('mahasiswa.profile');
    Route::put('/mahasiswa/profile', [ProfileController::class, 'profileUpdate'])->name('mahasiswa.profile.update');

    Route::get('/mahasiswa/pengajuan-sempro', [PengajuanSemproController::class, 'pengajuanSemproIndex'])->name('mahasiswa.pengajuan_sempro.index');
    Route::get('/mahasiswa/pengajuan-sempro/create', [PengajuanSemproController::class, 'pengajuanSemproCreate'])->name('mahasiswa.pengajuan_sempro.create');
    Route::post('/mahasiswa/pengajuan-sempro', [PengajuanSemproController::class, 'pengajuanSemproStore'])->name('mahasiswa.pengajuan_sempro.store');
    Route::get('/mahasiswa/pengajuan-sempro/{id}/edit', [PengajuanSemproController::class, 'pengajuanSemproEdit'])->name('mahasiswa.pengajuan_sempro.edit');
    Route::put('/mahasiswa/pengajuan-sempro/{id}', [PengajuanSemproController::class, 'pengajuanSemproUpdate'])->name('mahasiswa.pengajuan_sempro.update');
});

// Rute Dashboard Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
});

// Redirect root ke login
Route::get('/', fn() => redirect('/login'));
