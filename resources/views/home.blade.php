@extends('layouts.lunaria')

@section('title', 'Beranda - Lunaria Library')

@section('content')
<section class="hero">
    <h2>Selamat Datang di Lunaria Library</h2>
    <p>
        Platform sederhana untuk menjelajahi koleksi buku secara online.
        Cari judul, penulis, dan kategori favoritmu dengan mudah.
    </p>
    <a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Daftar Buku</a>
</section>

<section class="info-grid">
    <div class="info-card">
        <h3>Koleksi Lengkap</h3>
        <p>Berbagai judul dari novel, non-fiksi, hingga pengembangan diri.</p>
    </div>
    <div class="info-card">
        <h3>Detail Buku</h3>
        <p>Lihat informasi penulis, tahun terbit, dan kategori tiap buku.</p>
    </div>
    <div class="info-card">
        <h3>Pencarian Mudah</h3>
        <p>Cari buku favoritmu berdasarkan judul, penulis, atau kategori.</p>
    </div>
</section>
@endsection