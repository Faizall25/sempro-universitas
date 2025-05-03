<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\HasilController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rute untuk Semua Dosen
    Route::get('/dosen/all', [DosenController::class, 'allIndex'])->name('admin.dosen.all.index');
    Route::get('/dosen/all/create', [DosenController::class, 'allCreate'])->name('admin.dosen.all.create');
    Route::post('/dosen/all', [DosenController::class, 'allStore'])->name('admin.dosen.all.store');
    Route::get('/dosen/all/{id}/edit', [DosenController::class, 'allEdit'])->name('admin.dosen.all.edit');
    Route::put('/dosen/all/{id}', [DosenController::class, 'allUpdate'])->name('admin.dosen.all.update');
    Route::delete('/dosen/all/{id}', [DosenController::class, 'allDestroy'])->name('admin.dosen.all.destroy');

    // Rute untuk Dosen Pembimbing
    Route::get('/dosen/pembimbing', [DosenController::class, 'pembimbingIndex'])->name('admin.dosen.pembimbing.index');
    Route::get('/dosen/pembimbing/create', [DosenController::class, 'pembimbingCreate'])->name('admin.dosen.pembimbing.create');
    Route::post('/dosen/pembimbing', [DosenController::class, 'pembimbingStore'])->name('admin.dosen.pembimbing.store');
    Route::get('/dosen/pembimbing/{id}/edit', [DosenController::class, 'pembimbingEdit'])->name('admin.dosen.pembimbing.edit');
    Route::put('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingUpdate'])->name('admin.dosen.pembimbing.update');
    Route::delete('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingDestroy'])->name('admin.dosen.pembimbing.destroy');

    // Rute untuk Dosen Penguji
    Route::get('/dosen/penguji', [DosenController::class, 'pengujiIndex'])->name('admin.dosen.penguji.index');
    Route::get('/dosen/penguji/create', [DosenController::class, 'pengujiCreate'])->name('admin.dosen.penguji.create');
    Route::post('/dosen/penguji', [DosenController::class, 'pengujiStore'])->name('admin.dosen.penguji.store');
    Route::get('/dosen/penguji/{id}/edit', [DosenController::class, 'pengujiEdit'])->name('admin.dosen.penguji.edit');
    Route::put('/dosen/penguji/{id}', [DosenController::class, 'pengujiUpdate'])->name('admin.dosen.penguji.update');
    Route::patch('/dosen/penguji/{id}/toggle', [DosenController::class, 'pengujiToggleStatus'])->name('admin.dosen.penguji.toggle');
    Route::delete('/dosen/penguji/{id}', [DosenController::class, 'pengujiDestroy'])->name('admin.dosen.penguji.destroy');

    // Rute untuk Jadwal Mata Kuliah
    Route::get('/jadwal/mata-kuliah', [JadwalController::class, 'mataKuliahIndex'])->name('admin.jadwal.mata-kuliah.index');
    Route::get('/jadwal/mata-kuliah/create', [JadwalController::class, 'mataKuliahCreate'])->name('admin.jadwal.mata-kuliah.create');
    Route::post('/jadwal/mata-kuliah', [JadwalController::class, 'mataKuliahStore'])->name('admin.jadwal.mata-kuliah.store');
    Route::get('/jadwal/mata-kuliah/{id}/edit', [JadwalController::class, 'mataKuliahEdit'])->name('admin.jadwal.mata-kuliah.edit');
    Route::put('/jadwal/mata-kuliah/{id}', [JadwalController::class, 'mataKuliahUpdate'])->name('admin.jadwal.mata-kuliah.update');
    Route::delete('/jadwal/mata-kuliah/{id}', [JadwalController::class, 'mataKuliahDestroy'])->name('admin.jadwal.mata-kuliah.destroy');

    // Rute untuk Jadwal Sempro
    Route::get('/jadwal/sempro', [JadwalController::class, 'semproIndex'])->name('admin.jadwal.sempro.index');
    Route::get('/jadwal/sempro/create', [JadwalController::class, 'semproCreate'])->name('admin.jadwal.sempro.create');
    Route::post('/jadwal/sempro', [JadwalController::class, 'semproStore'])->name('admin.jadwal.sempro.store');
    Route::get('/jadwal/sempro/{id}/edit', [JadwalController::class, 'semproEdit'])->name('admin.jadwal.sempro.edit');
    Route::put('/jadwal/sempro/{id}', [JadwalController::class, 'semproUpdate'])->name('admin.jadwal.sempro.update');
    Route::delete('/jadwal/sempro/{id}', [JadwalController::class, 'semproDestroy'])->name('admin.jadwal.sempro.destroy');

    // Rute untuk Hasil Sempro
    Route::get('/hasil/sempro', [HasilController::class, 'index'])->name('admin.hasil.sempro.index');
    Route::get('/hasil/sempro/create', [HasilController::class, 'create'])->name('admin.hasil.sempro.create');
    Route::post('/hasil/sempro', [HasilController::class, 'store'])->name('admin.hasil.sempro.store');
    Route::get('/hasil/sempro/{id}/edit', [HasilController::class, 'edit'])->name('admin.hasil.sempro.edit');
    Route::put('/hasil/sempro/{id}', [HasilController::class, 'update'])->name('admin.hasil.sempro.update');
    Route::delete('/hasil/sempro/{id}', [HasilController::class, 'destroy'])->name('admin.hasil.sempro.destroy');
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
