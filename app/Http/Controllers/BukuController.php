<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BukuController extends Controller
{
    protected string $deskripsiDefault = 'Sinopsis untuk buku ini belum tersedia.';

    public function index(): View
    {
        return view('buku.index', [
            'kategoriList' => Kategori::orderBy('nama')->get(['id', 'nama']),
            'bukuTerbaru'  => Buku::latest('id')->take(5)->get(['id', 'judul']),
        ]);
    }

    // [A2 - RENTAN] Input 'judul' digabung langsung ke string SQL (SQL Injection).
    public function cari(Request $request): JsonResponse
    {
        $judul = $request->query('judul');

        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }

    public function edit(int $id): View
    {
        return view('buku.edit', [
            'id'           => $id,
            'kategoriList' => Kategori::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    public function show(int $id): View
    {
        $buku = Buku::with('kategori')->find($id);

        return view('buku.show', [
            'buku' => $buku ? $this->keArray($buku) : null,
        ]);
    }

    protected function keArray(Buku $buku): array
    {
        return [
            'id'        => $buku->id,
            'judul'     => $buku->judul,
            'penulis'   => $buku->penulis,
            'tahun'     => $buku->tahun_terbit,
            'kategori'  => $buku->kategori?->nama ?? '-',
            'deskripsi' => $buku->deskripsi ?? $this->deskripsiDefault,
        ];
    }
}