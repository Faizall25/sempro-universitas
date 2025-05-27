<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\SemproController;
use App\Http\Controllers\All\JadwalPerkuliahan;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\DosenHomeController;
use App\Http\Controllers\Dosen\InformasiPengajuan;
use App\Http\Controllers\Dosen\DosenProfileController;
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

    // Route untuk CRUD User
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Rute untuk CRUD Mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
    
    // Rute untuk CRUD Semua Dosen
    Route::get('/dosen/all', [DosenController::class, 'allIndex'])->name('admin.dosen.all.index');
    Route::get('/dosen/all/create', [DosenController::class, 'allCreate'])->name('admin.dosen.all.create');
    Route::post('/dosen/all', [DosenController::class, 'allStore'])->name('admin.dosen.all.store');
    Route::get('/dosen/all/{id}/edit', [DosenController::class, 'allEdit'])->name('admin.dosen.all.edit');
    Route::put('/dosen/all/{id}', [DosenController::class, 'allUpdate'])->name('admin.dosen.all.update');
    Route::delete('/dosen/all/{id}', [DosenController::class, 'allDestroy'])->name('admin.dosen.all.destroy');

    // Rute untuk CRUD Dosen Pembimbing
    Route::get('/dosen/pembimbing', [DosenController::class, 'pembimbingIndex'])->name('admin.dosen.pembimbing.index');
    Route::get('/dosen/pembimbing/create', [DosenController::class, 'pembimbingCreate'])->name('admin.dosen.pembimbing.create');
    Route::post('/dosen/pembimbing', [DosenController::class, 'pembimbingStore'])->name('admin.dosen.pembimbing.store');
    Route::get('/dosen/pembimbing/{id}/edit', [DosenController::class, 'pembimbingEdit'])->name('admin.dosen.pembimbing.edit');
    Route::put('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingUpdate'])->name('admin.dosen.pembimbing.update');
    Route::delete('/dosen/pembimbing/{id}', [DosenController::class, 'pembimbingDestroy'])->name('admin.dosen.pembimbing.destroy');

    // Rute untuk CRUD Dosen Penguji
    Route::get('/dosen/penguji', [DosenController::class, 'pengujiIndex'])->name('admin.dosen.penguji.index');
    Route::get('/dosen/penguji/create', [DosenController::class, 'pengujiCreate'])->name('admin.dosen.penguji.create');
    Route::post('/dosen/penguji', [DosenController::class, 'pengujiStore'])->name('admin.dosen.penguji.store');
    Route::get('/dosen/penguji/{id}/edit', [DosenController::class, 'pengujiEdit'])->name('admin.dosen.penguji.edit');
    Route::put('/dosen/penguji/{id}', [DosenController::class, 'pengujiUpdate'])->name('admin.dosen.penguji.update');
    Route::patch('/dosen/penguji/{id}/toggle', [DosenController::class, 'pengujiToggleStatus'])->name('admin.dosen.penguji.toggle');
    Route::delete('/dosen/penguji/{id}', [DosenController::class, 'pengujiDestroy'])->name('admin.dosen.penguji.destroy');

    // Rute untuk CRUD Jadwal Mata Kuliah
    Route::get('/jadwal/mata-kuliah', [JadwalController::class, 'mataKuliahIndex'])->name('admin.jadwal.mata-kuliah.index');
    Route::get('/jadwal/mata-kuliah/create', [JadwalController::class, 'mataKuliahCreate'])->name('admin.jadwal.mata-kuliah.create');
    Route::post('/jadwal/mata-kuliah', [JadwalController::class, 'mataKuliahStore'])->name('admin.jadwal.mata-kuliah.store');
    Route::get('/jadwal/mata-kuliah/{id}/edit', [JadwalController::class, 'mataKuliahEdit'])->name('admin.jadwal.mata-kuliah.edit');
    Route::put('/jadwal/mata-kuliah/{id}', [JadwalController::class, 'mataKuliahUpdate'])->name('admin.jadwal.mata-kuliah.update');
    Route::delete('/jadwal/mata-kuliah/{id}', [JadwalController::class, 'mataKuliahDestroy'])->name('admin.jadwal.mata-kuliah.destroy');

    // Rute untuk CRUD Jadwal Sempro
    Route::get('jadwal/sempro/export/form', [JadwalController::class, 'semproExportForm'])->name('admin.jadwal.sempro.export.form');
    Route::post('jadwal/sempro/export', [JadwalController::class, 'semproExport'])->name('admin.jadwal.sempro.export');
    Route::get('/jadwal/sempro', [JadwalController::class, 'semproIndex'])->name('admin.jadwal.sempro.index');
    Route::get('/jadwal/sempro/create', [JadwalController::class, 'semproCreate'])->name('admin.jadwal.sempro.create');
    Route::post('/jadwal/sempro', [JadwalController::class, 'semproStore'])->name('admin.jadwal.sempro.store');
    Route::get('/jadwal/sempro/{id}/edit', [JadwalController::class, 'semproEdit'])->name('admin.jadwal.sempro.edit');
    Route::put('/jadwal/sempro/{id}', [JadwalController::class, 'semproUpdate'])->name('admin.jadwal.sempro.update');
    Route::delete('/jadwal/sempro/{id}', [JadwalController::class, 'semproDestroy'])->name('admin.jadwal.sempro.destroy');
    Route::patch('/jadwal/sempro/{id}/change-status', [JadwalController::class, 'semproChangeStatus'])->name('admin.jadwal.sempro.change-status');
    Route::get('jadwal/dosen/{dosenId}/jadwal', [JadwalController::class, 'getDosenJadwal'])->name('admin.jadwal.dosen.jadwal');

    // Rute untuk CRUD approval penguji
    Route::get('/jadwal/sempro/approval/create', [JadwalController::class, 'approvalCreate'])->name('admin.jadwal.sempro.approval.create');
    Route::post('/jadwal/sempro/approval', [JadwalController::class, 'approvalStore'])->name('admin.jadwal.sempro.approval.store');
    Route::get('/jadwal/sempro/approval/{id}/edit', [JadwalController::class, 'approvalEdit'])->name('admin.jadwal.sempro.approval.edit');
    Route::put('/jadwal/sempro/approval/{id}', [JadwalController::class, 'approvalUpdate'])->name('admin.jadwal.sempro.approval.update');
    Route::delete('/jadwal/sempro/approval/{id}', [JadwalController::class, 'approvalDestroy'])->name('admin.jadwal.sempro.approval.destroy');
    Route::get('/jadwal/sempro/{jadwal}/penguji/{penguji}/edit', [JadwalController::class, 'editPenguji'])->name('admin.jadwal.sempro.approval.edit.penguji');
    Route::put('/jadwal/sempro/{jadwal}/penguji/{penguji}', [JadwalController::class, 'updatePenguji'])->name('admin.jadwal.sempro.approval.update.penguji');

    // Rute untuk CRUD Hasil Sempro
    Route::get('/hasil/sempro', [HasilController::class, 'index'])->name('admin.hasil.sempro.index');
    Route::get('/hasil/sempro/create', [HasilController::class, 'create'])->name('admin.hasil.sempro.create');
    Route::post('/hasil/sempro', [HasilController::class, 'store'])->name('admin.hasil.sempro.store');
    Route::get('/hasil/sempro/{id}/edit', [HasilController::class, 'edit'])->name('admin.hasil.sempro.edit');
    Route::put('/hasil/sempro/{id}', [HasilController::class, 'update'])->name('admin.hasil.sempro.update');
    Route::delete('/hasil/sempro/{id}', [HasilController::class, 'destroy'])->name('admin.hasil.sempro.destroy');

    // Rute untuk CRUD Pengajuan Sempro
    Route::get('pengajuan-sempro', [SemproController::class, 'index'])->name('admin.pengajuan-sempro.index');
    Route::get('pengajuan-sempro/create', [SemproController::class, 'create'])->name('admin.pengajuan-sempro.create');
    Route::post('pengajuan-sempro', [SemproController::class, 'store'])->name('admin.pengajuan-sempro.store');
    Route::get('pengajuan-sempro/{id}/edit', [SemproController::class, 'edit'])->name('admin.pengajuan-sempro.edit');
    Route::put('pengajuan-sempro/{id}', [SemproController::class, 'update'])->name('admin.pengajuan-sempro.update');
    Route::delete('pengajuan-sempro/{id}', [SemproController::class, 'destroy'])->name('admin.pengajuan-sempro.destroy');
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
    Route::get('/dosen/home', [DosenHomeController::class, 'home'])->name('dosen.home');
    Route::get('/dosen/profile', [DosenProfileController::class, 'profile'])->name('dosen.profile');
    Route::put('/dosen/profile', [DosenProfileController::class, 'profileUpdate'])->name('dosen.profile.update');
    Route::get('/jadwal-perkuliahan', [JadwalPerkuliahan::class, 'index'])->name('dosen.jadwal_perkuliahan.index');
    Route::get('/informasi-pengajuan', [InformasiPengajuan::class, 'index'])->name('dosen.informasi_pengajuan.index');
    Route::get('/approve-jadwal-sempro/{jadwalId}', [InformasiPengajuan::class, 'approveJadwalSempro'])->name('dosen.approve-jadwal-sempro');
    Route::get('/reject-jadwal-sempro/{jadwalId}', [InformasiPengajuan::class, 'rejectJadwalSempro'])->name('dosen.reject-jadwal-sempro');
});

// Redirect root ke login
Route::get('/', fn() => redirect('/login'));
