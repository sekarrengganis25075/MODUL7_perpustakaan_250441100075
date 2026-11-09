@extends('layouts.lunaria')

@section('title', 'Tambah Buku - Lunaria Library')

@push('styles')
<style>
    .form-buku { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;
        background: var(--color-white); padding: 26px; border-radius: var(--radius); box-shadow: var(--shadow); }
    .form-buku label { display: block; font-size: .85rem; font-weight: 600; color: var(--color-muted); margin-bottom: 4px; }
    .form-buku input, .form-buku select, .form-buku textarea { width: 100%; padding: 10px 14px; border: 2px solid var(--color-pink-soft);
        border-radius: 12px; font-family: inherit; font-size: .95rem; color: var(--color-text); background: #fff; }
    .pesan-field { color: #b3264f; font-size: .8rem; margin: 4px 0 0; }
    .form-aksi { grid-column: 1 / -1; display: flex; gap: 10px; }
</style>
@endpush

@section('content')
    <a href="{{ route('buku.index') }}" class="back-link">&larr; Kembali ke Daftar Buku</a>
    <h2 class="page-title">Tambah Buku</h2>

    <form method="POST" action="{{ route('buku.store') }}" class="form-buku">
        @csrf
        <div>
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id">
                <option value="">-- Pilih kategori --</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                @endforeach
            </select>
            @error('kategori_id') <p class="pesan-field">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}">
            @error('judul') <p class="pesan-field">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}">
            @error('penulis') <p class="pesan-field">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}">
            @error('tahun_terbit') <p class="pesan-field">{{ $message }}</p> @enderror
        </div>
        <div style="grid-column: 1 / -1">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <p class="pesan-field">{{ $message }}</p> @enderror
        </div>
        <div class="form-aksi">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection