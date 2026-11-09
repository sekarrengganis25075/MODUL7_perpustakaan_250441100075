@extends('layouts.lunaria')
@section('title', 'Dasbor Admin - Lunaria Library')
@section('content')
    <h2 class="page-title">Dasbor Admin</h2>
    <div class="kartu-statistik">
        <div class="kartu"><small>Total Buku</small><strong>{{ $totalBuku }}</strong></div>
        <div class="kartu"><small>Total Pengguna</small><strong>{{ $totalUser }}</strong></div>
        <div class="kartu"><small>Menunggu Persetujuan</small><strong>{{ $menunggu }}</strong></div>
        <div class="kartu"><small>Sedang Dipinjam</small><strong>{{ $dipinjam }}</strong></div>
    </div>
@endsection