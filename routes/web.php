<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/uji-error', fn () => throw new \RuntimeException('Uji error'));
Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses-dashboard-admin')->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses-dashboard-petugas')->name('petugas.dashboard');

    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat-daftar-buku')->name('buku.index');
    
    Route::get('/buku/create', [BukuController::class, 'create'])
        ->middleware('can:kelola-buku')->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])
        ->middleware('can:kelola-buku')->name('buku.store'); 

    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('permission:kelola-data-buku')->name('buku.destroy');

    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])
        ->middleware('permission:kelola-data-buku')->name('buku.edit');
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat-daftar-buku')->name('buku.show');

    Route::middleware('permission:kelola-data-pengguna')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:kelola-role-pengguna')->name('users.role');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:ajukan-peminjaman-buku')->name('peminjaman.store');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman-saya', [PeminjamanController::class, 'saya'])
        ->middleware('permission:lihat-status-peminjaman-sendiri')->name('peminjaman.saya');

    Route::get('/riwayat/{user?}', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:lihat-riwayat-peminjaman-sendiri')->name('riwayat');

    Route::get('/kelola/peminjaman', [PeminjamanController::class, 'kelola'])
        ->middleware('permission:kelola-peminjaman')->name('kelola.peminjaman');
    Route::post('/kelola/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
        ->middleware('permission:proses-persetujuan-peminjaman')->name('kelola.setujui');
    Route::post('/kelola/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
        ->middleware('permission:proses-persetujuan-peminjaman')->name('kelola.tolak');
    Route::get('/kelola/pengembalian', [PeminjamanController::class, 'pengembalian'])
        ->middleware('permission:kelola-pengembalian')->name('kelola.pengembalian');
    Route::post('/kelola/pengembalian/{peminjaman}', [PeminjamanController::class, 'kembalikan'])
        ->middleware('permission:catat-pengembalian-buku')->name('kelola.kembalikan');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat-laporan-perpustakaan')->name('laporan');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat-profil-sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah-profil-sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah-profil-sendiri')->name('profile.destroy');
});

require __DIR__.'/auth.php';