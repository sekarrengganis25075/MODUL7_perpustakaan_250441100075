@extends('layouts.lunaria')
@section('title', 'Laporan - Lunaria Library')
@section('content')
    <h2 class="page-title">Laporan Perpustakaan</h2>
    <div class="kartu-statistik">
        <div class="kartu"><small>Total Judul Buku</small><strong>{{ $totalBuku }}</strong></div>
        @foreach (['diajukan' => 'Diajukan', 'disetujui' => 'Sedang Dipinjam', 'ditolak' => 'Ditolak', 'dikembalikan' => 'Dikembalikan'] as $k => $label)
            <div class="kartu"><small>{{ $label }}</small><strong>{{ $perStatus[$k] ?? 0 }}</strong></div>
        @endforeach
    </div>

    <div class="panel">
        <h3>Buku per Kategori</h3>
        <ul>@forelse ($perKategori as $k)<li>{{ $k->nama }}: {{ $k->bukus_count }} buku</li>@empty<li style="list-style:none">Belum ada data.</li>@endforelse</ul>
    </div>
    <div class="panel">
        <h3>5 Buku Terpopuler</h3>
        <ol>@forelse ($terpopuler as $b)<li>{{ $b->judul }} ({{ $b->peminjamans_count }}x dipinjam)</li>@empty<li style="list-style:none">Belum ada data.</li>@endforelse</ol>
    </div>
    <div class="panel">
        <h3>Peminjaman Terlambat (lebih dari 7 hari)</h3>
        <ul>@forelse ($terlambat as $t)<li>{{ $t->namaPeminjam() }} — {{ $t->buku->judul }} (sejak {{ $t->tanggal_pinjam->format('d M Y') }})</li>@empty<li style="list-style:none">Tidak ada.</li>@endforelse</ul>
    </div>
@endsection