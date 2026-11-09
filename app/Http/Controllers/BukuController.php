<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
{
    protected string $deskripsiDefault = 'Sinopsis untuk buku ini belum tersedia.';

    public function index(): View
    {
        return view('buku.index', [
            'kategoriList' => Kategori::orderBy('nama')->get(['id', 'nama']),
        ]);
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