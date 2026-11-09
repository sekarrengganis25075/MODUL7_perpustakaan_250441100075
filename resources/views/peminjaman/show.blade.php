@extends('layouts.lunaria')
@section('title', 'Detail Peminjaman - Lunaria Library')
@section('content')
    <h2 class="page-title">Detail Peminjaman #{{ $peminjaman->id }}</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <tbody>
                <tr><th>Peminjam</th><td>{{ $peminjaman->namaPeminjam() }}</td></tr>
                <tr><th>Buku</th><td>{{ $peminjaman->buku?->judul ?? '-' }}</td></tr>
                <tr><th>Status</th><td><span class="badge-status">{{ $peminjaman->status }}</span></td></tr>
                <tr><th>Tanggal Pinjam</th><td>{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}</td></tr>
                <tr><th>Tanggal Kembali</th><td>{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}</td></tr>
            </tbody>
        </table>
    </div>
@endsection