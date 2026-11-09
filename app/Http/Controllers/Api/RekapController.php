<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    public function bukuPerKategori(): JsonResponse
    {
        $data = Kategori::withCount('bukus')
            ->orderByDesc('bukus_count')
            ->get()
            ->map(fn(Kategori $k) => [
                'kategori_id'   => $k->id,
                'nama_kategori' => $k->nama,
                'jumlah_buku'   => $k->bukus_count,
            ]);

        return response()->json([
            'message' => 'Rekap jumlah buku per kategori',
            'data'    => $data,
        ], 200);
    }

    public function peminjamanPerBuku(): JsonResponse
    {
        $data = Buku::withCount('peminjamans')
            ->orderByDesc('peminjamans_count')
            ->get()
            ->map(fn(Buku $b) => [
                'buku_id'          => $b->id,
                'judul'            => $b->judul,
                'total_peminjaman' => $b->peminjamans_count,
            ]);

        return response()->json([
            'message' => 'Rekap total peminjaman per buku',
            'data'    => $data,
        ], 200);
    }
}