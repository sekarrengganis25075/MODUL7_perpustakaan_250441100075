<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'totalBuku'   => Buku::count(),
            'perStatus'   => Peminjaman::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'perKategori' => Kategori::withCount('bukus')->orderByDesc('bukus_count')->get(),
            'terpopuler'  => Buku::withCount('peminjamans')->orderByDesc('peminjamans_count')->limit(5)->get(),
            'terlambat'   => Peminjaman::with(['user', 'anggota', 'buku'])
                ->where('status', Peminjaman::DISETUJUI)
                ->whereDate('tanggal_pinjam', '<', now()->subDays(7))->get(),
        ]);
    }
}