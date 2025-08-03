<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\Route;
// arinda
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Jalur untuk user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dokumen_user', [DokumenController::class, 'indexUser'])->name('dokumen.user');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/dokumen/pengajuan', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen/pengajuan', [DokumenController::class, 'store'])->name('dokumen.store');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/tambah_syarat', [AdminController::class, 'tambahSyarat'])->name('admin.tambahsyarat');
    Route::post('/tambah_syarat', [AdminController::class, 'postTambahSyarat'])->name('admin.posttambahsyarat');
    Route::get('/lihat_syarat', [AdminController::class, 'lihatSyarat'])->name('admin.lihatsyarat');
    Route::get('/hapus_syarat/{id}', [AdminController::class, 'hapusSyarat'])->name('admin.hapussyarat');
    Route::get('/edit_syarat/{id}', [AdminController::class, 'editSyarat'])->name('admin.editsyarat');
    Route::post('/edit_syarat/{id}', [AdminController::class, 'postEditSyarat'])->name('admin.posteditsyarat');
});

require __DIR__ . '/auth.php';
