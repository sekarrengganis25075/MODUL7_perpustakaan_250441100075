@extends('layouts.lunaria')
@section('title', 'Kelola Pengembalian - Lunaria Library')
@section('content')
    <h2 class="page-title">Kelola Pengembalian</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Peminjam</th><th>Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($list as $p)
                <tr>
                    <td>{{ $p->namaPeminjam() }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                    <td>{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                    <td><span class="badge-status">{{ $p->status }}</span></td>
                    <td>
                        @if ($p->status === 'disetujui')
                            @can('catat-pengembalian-buku')
                                <form method="POST" action="{{ route('kelola.kembalikan', $p) }}">@csrf<button class="btn btn-primary btn-sm">Catat Kembali</button></form>
                            @endcan
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Belum ada data pengembalian.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $list->links() }}</div>
@endsection