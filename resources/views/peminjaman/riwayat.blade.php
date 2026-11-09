@extends('layouts.lunaria')
@section('title', 'Riwayat Peminjaman - Lunaria Library')
@section('content')
    <h2 class="page-title">Riwayat Peminjaman — {{ $target->name }}</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Buku</th><th>Status</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th></tr></thead>
            <tbody>
            @forelse ($list as $p)
                <tr>
                    <td>{{ $p->buku->judul }}</td>
                    <td><span class="badge-status">{{ $p->status }}</span></td>
                    <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                    <td>{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center">Belum ada riwayat peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $list->links() }}</div>
@endsection
