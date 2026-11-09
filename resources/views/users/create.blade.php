@extends('layouts.lunaria')
@section('title', 'Tambah Pengguna - Lunaria Library')
@section('content')
    <h2 class="page-title">Tambah Pengguna</h2>
    <form method="POST" action="{{ route('users.store') }}" class="form-tampah" style="margin-top:16px">
        @csrf
        <div><label>Nama</label><input name="name" value="{{ old('name') }}" required></div>
        <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div><label>Kata Sandi</label><input type="password" name="password" required></div>
        <div><label>Konfirmasi Kata Sandi</label><input type="password" name="password_confirmation" required></div>
        <div>
            <label>Role</label>
            <select name="role">
                @foreach ($roles as $r)<option value="{{ $r }}" @selected(old('role') === $r)>{{ $r }}</option>@endforeach
            </select>
        </div>
        <div class="aksi-baris">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection
