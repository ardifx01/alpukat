<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\BerkasAdminController;
use App\Http\Controllers\Admin\SyaratController;

// User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\DokumenController;
use App\Http\Controllers\User\NotifikasiController;

// Public
Route::view('/', 'user.dashboard')->name('home');

// User atau koperasi
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Profil
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengajuan / Dokumen
    Route::get('/pengajuan', [DokumenController::class, 'create'])->name('user.create');
    Route::post('/pengajuan', [DokumenController::class, 'store'])->name('user.store');
    Route::get('/lihat-berkas', [DokumenController::class, 'lihatBerkas'])->name('user.lihat_berkas');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'notifikasiUser'])->name('user.notifikasi');
});

// Admin atau dinas koperasi
Route::prefix('admin')->name('admin.')->middleware(['auth','can:admin'])->group(function () {
    // Dashboard admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // ---- Syarat (admin.syarat.*)
    Route::prefix('syarat')->name('syarat.')->group(function () {
        Route::get('/', [SyaratController::class, 'lihatSyarat'])->name('lihat_syarat');
        Route::get('/tambah', [SyaratController::class, 'tambahSyarat'])->name('tambah_syarat');
        Route::post('/tambah', [SyaratController::class, 'postTambahSyarat'])->name('post_tambah_syarat');
        Route::get('/{id}/edit', [SyaratController::class, 'editSyarat'])->name('edit_syarat');
        Route::post('/{id}/edit', [SyaratController::class, 'postEditSyarat'])->name('post_edit_syarat');
        Route::get('/{id}/hapus', [SyaratController::class, 'hapusSyarat'])->name('hapus_syarat'); // idealnya DELETE
    });

    // ---- Verifikasi (admin.verif.*)
    Route::prefix('verifikasi')->name('verif.')->group(function () {
        Route::get('/daftar-pengajuan', [DokumenController::class, 'daftarPengajuan'])->name('daftar_pengajuan');
        Route::get('/berkas/{id}', [VerifikasiController::class, 'verifBerkas'])->name('verif_berkas');
        Route::post('/berkas/{id}', [VerifikasiController::class, 'postVerifBerkas'])->name('post_verif_berkas');
        Route::get('/hasil', [VerifikasiController::class, 'hasilVerifikasi'])->name('hasil_verifikasi');
    });

    // ---- Berkas Admin
    Route::resource('berkas-admin', BerkasAdminController::class)->only(['index','create','store','show']);
    Route::get('berkas-admin/{id}/download', [BerkasAdminController::class, 'download'])->name('berkas-admin.download');
});

require __DIR__ . '/auth.php';