@extends('layouts.lunaria')
@section('title', 'Pinjaman Saya - Lunaria Library')
@section('content')
    <h2 class="page-title">Status Peminjaman Saya</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Buku</th><th>Status</th><th>Tanggal Pinjam</th></tr></thead>
            <tbody>
            @forelse ($list as $p)
                <tr>
                    <td>{{ $p->buku->judul }}</td>
                    <td><span class="badge-status">{{ $p->status }}</span></td>
                    <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center">Tidak ada peminjaman aktif.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
