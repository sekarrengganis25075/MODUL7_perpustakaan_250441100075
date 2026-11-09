@extends('layouts.lunaria')
@section('title', 'Beranda Siswa - Lunaria Library')
@section('content')
    <h2 class="page-title">Halo, {{ auth()->user()->name }}</h2>
    <p class="page-subtitle">Peminjaman aktif Anda</p>
    <div class="panel">
        <ul>
            @forelse ($aktif as $p)
                <li>{{ $p->buku->judul }} <span class="badge-status">{{ ucfirst($p->status) }}</span></li>
            @empty
                <li style="list-style:none">Belum ada peminjaman aktif.</li>
            @endforelse
        </ul>
        <p style="margin-top:12px"><a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Daftar Buku</a></p>
    </div>
@endsection