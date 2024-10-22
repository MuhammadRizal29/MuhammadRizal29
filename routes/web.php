<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;

// Halaman Utama
Route::get('/', function () {
    return redirect()->route('login');
});


// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Rute Santri
    Route::get('/admin/santri', [AdminController::class, 'santri'])->name('admin.santri');
    Route::get('/admin/santri/create', [AdminController::class, 'santriCreate'])->name('admin.santri.create');
    Route::post('/admin/santri', [AdminController::class, 'santriStore'])->name('admin.santri.store');
    Route::get('/admin/santri/{id}/edit', [AdminController::class, 'santriEdit'])->name('admin.santri.edit');
    Route::put('/admin/santri/{id}', [AdminController::class, 'santriUpdate'])->name('admin.santri.update');
    Route::delete('/admin/santri/{id}', [AdminController::class, 'santriDestroy'])->name('admin.santri.destroy');

    // Rute Guru
    Route::get('/admin/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/admin/guru/create', [AdminController::class, 'guruCreate'])->name('admin.guru.create');
    Route::post('/admin/guru', [AdminController::class, 'guruStore'])->name('admin.guru.store');
    Route::get('/admin/guru/{c_guru}/edit', [AdminController::class, 'guruEdit'])->name('admin.guru.edit');
    Route::put('/admin/guru/{c_guru}', [AdminController::class, 'guruUpdate'])->name('admin.guru.update');
    Route::delete('/admin/guru/{c_guru}', [AdminController::class, 'guruDestroy'])->name('admin.guru.destroy');

    // Rute Orang Tua
    Route::get('/admin/orangtua', [AdminController::class, 'orangtua'])->name('admin.orangtua');
    Route::get('/admin/orangtua/create', [AdminController::class, 'orangtuaCreate'])->name('admin.orangtua.create');
    Route::post('/admin/orangtua', [AdminController::class, 'orangtuaStore'])->name('admin.orangtua.store');
    Route::get('/admin/orangtua/{c_orangtua}/edit', [AdminController::class, 'orangtuaEdit'])->name('admin.orangtua.edit');
    Route::put('/admin/orangtua/{c_orangtua}', [AdminController::class, 'orangtuaUpdate'])->name('admin.orangtua.update');
    Route::delete('/admin/orangtua/{c_orangtua}', [AdminController::class, 'orangtuaDestroy'])->name('admin.orangtua.destroy');

    // Rute Kelas
    Route::get('/admin/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::get('/admin/kelas/create', [AdminController::class, 'kelasCreate'])->name('admin.kelas.create');
    Route::post('/admin/kelas', [AdminController::class, 'kelasStore'])->name('admin.kelas.store');
    Route::get('/admin/kelas/{c_kelas}/edit', [AdminController::class, 'kelasEdit'])->name('admin.kelas.edit');
    Route::put('/admin/kelas/{c_kelas}', [AdminController::class, 'kelasUpdate'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{c_kelas}', [AdminController::class, 'kelasDestroy'])->name('admin.kelas.destroy');
    Route::get('/admin/kelas/{c_kelas}', [AdminController::class, 'kelasView'])->name('admin.kelas.view');
    Route::get('/admin/kelas/{c_kelas}/santri', [AdminController::class, 'getSantri'])->name('admin.kelas.santri');
    
    // Rute Hafalan, Prestasi, Kegiatan, Pelanggaran untuk Admin
    Route::get('/admin/hafalan', [AdminController::class, 'hafalan'])->name('admin.hafalan');
    Route::get('/admin/prestasi', [AdminController::class, 'prestasi'])->name('admin.prestasi');
    Route::get('/admin/kegiatan', [AdminController::class, 'kegiatan'])->name('admin.kegiatan');
    Route::get('/admin/pelanggaran', [AdminController::class, 'pelanggaran'])->name('admin.pelanggaran');
});

// Rute Guru
Route::middleware(['auth:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    
    // Rute Hafalan
    Route::get('/guru/hafalan', [GuruController::class, 'hafalanIndex'])->name('guru.hafalan.index');
    Route::get('/guru/hafalan/create', [GuruController::class, 'hafalanCreate'])->name('guru.hafalan.create');
    Route::post('/guru/hafalan', [GuruController::class, 'hafalanStore'])->name('guru.hafalan.store');
    Route::get('/guru/hafalan/{id}/edit', [GuruController::class, 'hafalanEdit'])->name('guru.hafalan.edit');
    Route::put('/guru/hafalan/{id}', [GuruController::class, 'hafalanUpdate'])->name('guru.hafalan.update');
    Route::delete('/guru/hafalan/{id}', [GuruController::class, 'hafalanDestroy'])->name('guru.hafalan.destroy');

    // Rute Prestasi
    Route::get('/guru/prestasi', [GuruController::class, 'prestasiIndex'])->name('guru.prestasi.index');
    Route::get('/guru/prestasi/create', [GuruController::class, 'prestasiCreate'])->name('guru.prestasi.create');
    Route::post('/guru/prestasi', [GuruController::class, 'prestasiStore'])->name('guru.prestasi.store');
    Route::get('/guru/prestasi/{id}/edit', [GuruController::class, 'prestasiEdit'])->name('guru.prestasi.edit');
    Route::put('/guru/prestasi/{id}', [GuruController::class, 'prestasiUpdate'])->name('guru.prestasi.update');
    Route::delete('/guru/prestasi/{id}', [GuruController::class, 'prestasiDestroy'])->name('guru.prestasi.destroy');

    // Rute Pelanggaran
    Route::get('/guru/pelanggaran', [GuruController::class, 'pelanggaranIndex'])->name('guru.pelanggaran.index');
    Route::get('/guru/pelanggaran/create', [GuruController::class, 'pelanggaranCreate'])->name('guru.pelanggaran.create');
    Route::post('/guru/pelanggaran', [GuruController::class, 'pelanggaranStore'])->name('guru.pelanggaran.store');
    Route::get('/guru/pelanggaran/{id}/edit', [GuruController::class, 'pelanggaranEdit'])->name('guru.pelanggaran.edit');
    Route::put('/guru/pelanggaran/{id}', [GuruController::class, 'pelanggaranUpdate'])->name('guru.pelanggaran.update');
    Route::delete('/guru/pelanggaran/{id}', [GuruController::class, 'pelanggaranDestroy'])->name('guru.pelanggaran.destroy');

    // Rute Kegiatan
    Route::get('/guru/kegiatan', [GuruController::class, 'kegiatanIndex'])->name('guru.kegiatan.index');
    Route::get('/guru/kegiatan/create', [GuruController::class, 'kegiatanCreate'])->name('guru.kegiatan.create');
    Route::post('/guru/kegiatan', [GuruController::class, 'kegiatanStore'])->name('guru.kegiatan.store');
    Route::get('/guru/kegiatan/{id}/edit', [GuruController::class, 'kegiatanEdit'])->name('guru.kegiatan.edit');
    Route::put('/guru/kegiatan/{id}', [GuruController::class, 'kegiatanUpdate'])->name('guru.kegiatan.update');
    Route::delete('/guru/kegiatan/{id}', [GuruController::class, 'kegiatanDestroy'])->name('guru.kegiatan.destroy');

    // Rute Kelas untuk Guru
    Route::get('/guru/kelas', [GuruController::class, 'kelasIndex'])->name('guru.kelas.index');
    Route::get('/guru/kelas/{id}', [GuruController::class, 'kelasShow'])->name('guru.kelas.show');
    
    //PENGATURAN
    Route::get('/guru/pengaturan', [GuruController::class, 'showPengaturan'])->name('guru.pengaturan');
    Route::put('/guru/pengaturan', [GuruController::class, 'updatePengaturan'])->name('guru.pengaturan.update');
    
    // Rute Santri untuk Guru
    Route::get('/guru/santri/{nis}', [GuruController::class, 'santriShow'])->name('guru.santri.show');
});

// Rute Orang Tua
Route::middleware(['auth:orangtua'])->group(function () {
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
    Route::get('/orangtua/biodata', [OrangTuaController::class, 'showBiodata'])->name('orangtua.biodata');
    Route::get('/orangtua/prestasi', [OrangTuaController::class, 'showPrestasi'])->name('orangtua.prestasi');   
    Route::get('/orangtua/pelanggaran', [OrangTuaController::class, 'showPelanggaran'])->name('orangtua.pelanggaran');
    Route::get('/orangtua/hafalan/{nis}', [OrangTuaController::class, 'showHafalan'])->name('orangtua.hafalan');
});

