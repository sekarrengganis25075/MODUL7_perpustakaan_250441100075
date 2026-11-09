@extends('layouts.lunaria')

@section('title', $buku ? 'Detail ' . $buku['judul'] : 'Buku Tidak Ditemukan')

@section('content')
    @if ($buku)
        <div class="detail-buku">
            <a href="{{ route('buku.index') }}" class="back-link">&larr; Kembali ke Daftar Buku</a>

            <h2 class="page-title">{{ $buku['judul'] }}</h2>
            <span class="badge">{{ $buku['kategori'] }}</span>

            <table class="detail-table">
                <tr>
                    <th>ID Buku</th>
                    <td>{{ $buku['id'] }}</td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td>{{ $buku['judul'] }}</td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>{{ $buku['penulis'] }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>{{ $buku['tahun'] }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $buku['kategori'] }}</td>
                </tr>
            </table>

            <div class="detail-deskripsi">
                <h3>Sinopsis</h3>
                <p>{{ $buku['deskripsi'] }}</p>
            </div>
        </div>
    @else
        <div class="empty-state">
            <h2>Buku Tidak Ditemukan</h2>
            <p>Maaf, data buku dengan ID tersebut tidak tersedia di perpustakaan.</p>
            <a href="{{ route('buku.index') }}" class="btn btn-primary">Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection