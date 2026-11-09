<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('permission:lihat-daftar-buku')->group(function () {
        Route::get('buku', [BukuController::class, 'index'])->name('api.buku.index');
        Route::get('buku/{buku}', [BukuController::class, 'show'])->name('api.buku.show');
    });

    Route::middleware('can:kelola-buku')->group(function () {
        Route::post('buku', [BukuController::class, 'store'])->name('api.buku.store');
        Route::match(['put', 'patch'], 'buku/{buku}', [BukuController::class, 'update'])->name('api.buku.update');
        Route::delete('buku/{buku}', [BukuController::class, 'destroy'])->name('api.buku.destroy');
    });

    Route::prefix('rekap')->middleware('permission:lihat-laporan-perpustakaan')->group(function () {
        Route::get('buku-per-kategori', [RekapController::class, 'bukuPerKategori'])
            ->name('api.rekap.buku-per-kategori');

        Route::get('pemminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku'])
            ->name('api.rekap.peminjaman-per-buku');

        Route::get('peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
    });
});
