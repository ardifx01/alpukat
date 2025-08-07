<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/admin', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Supaya halaman hanya dapat diakses oleh user saja
Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/pengajuan', [DokumenController::class, 'create'])->name('dokumen.create');

    Route::post('/pengajuan', [DokumenController::class, 'store'])->name('dokumen.store');

    Route::get('/lihat-berkas', [DokumenController::class, 'lihatBerkas'])->name('dokumen.lihat_berkas');

    Route::get('/notifikasi', [UserController::class, 'notifikasi'])->middleware('auth')->name('notifikasi');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Tambah persyaratan
    Route::get('/tambah-syarat', [AdminController::class, 'tambahSyarat'])->name('admin.tambah_syarat');
    Route::post('/tambah-syarat', [AdminController::class, 'postTambahSyarat'])->name('admin.post_tambah_syarat');
    // Lihat persyaratan
    Route::get('/lihat-syarat', [AdminController::class, 'lihatSyarat'])->name('admin.lihat_syarat');
    
    // Hapus persyaratan
    Route::get('/hapus-syarat/{id}', [AdminController::class, 'hapusSyarat'])->name('admin.hapus_syarat');

    // Edit persyaratan
    Route::get('/edit-syarat/{id}', [AdminController::class, 'editSyarat'])->name('admin.edit_syarat');
    Route::post('/edit-syarat/{id}', [AdminController::class, 'postEditSyarat'])->name('admin.post_edit_syarat');

    // Lihat berkas atau dokumen user
    Route::get('/daftar-pengajuan', [DokumenController::class, 'daftarPengajuan'])->name('admin.daftar_pengajuan');

    // Tampilkan halaman verifikasi
    Route::get('/verifikasi-berkas/{id}', [VerifikasiController::class, 'verifBerkas'])->name('admin.verif_berkas');

    // Simpan hasil verifikasi
    Route::post('/verifikasi-berkas/{id}', [VerifikasiController::class, 'postVerifBerkas'])->name('admin.verif_berkas');
    
    // Tampilkan halaman hasil verifikasi
    Route::get('/hasil-verifikasi', [VerifikasiController::class, 'hasilVerifikasi'])->name('admin.hasil_verifikasi');
});

require __DIR__ . '/auth.php';
