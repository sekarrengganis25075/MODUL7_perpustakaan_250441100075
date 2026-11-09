@extends('layouts.lunaria')
@section('title', 'Kelola Peminjaman - Lunaria Library')
@section('content')
    <h2 class="page-title">Kelola Peminjaman</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Peminjam</th><th>Buku</th><th>Status</th><th>Tanggal Pinjam</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($list as $p)
                <tr>
                    <td>{{ $p->namaPeminjam() }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td><span class="badge-status">{{ $p->status }}</span></td>
                    <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                    <td>
                        @if ($p->status === 'diajukan')
                            @can('proses-persetujuan-peminjaman')
                                <div class="aksi-baris">
                                    <form method="POST" action="{{ route('kelola.setujui', $p) }}">@csrf<button class="btn btn-primary btn-sm">Setujui</button></form>
                                    <form method="POST" action="{{ route('kelola.tolak', $p) }}">@csrf<button class="btn btn-secondary btn-sm">Tolak</button></form>
                                </div>
                            @endcan
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center">Belum ada data peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $list->links() }}</div>
@endsection