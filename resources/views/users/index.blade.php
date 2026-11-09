@extends('layouts.lunaria')
@section('title', 'Kelola Pengguna - Lunaria Library')
@section('content')
    <h2 class="page-title">Kelola Pengguna & Role</h2>
    <p style="margin:12px 0"><a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah Pengguna</a></p>
    <div class="tabel-wrap">
        <table class="tabel-data">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @can('kelola-role-pengguna')
                            <form method="POST" action="{{ route('users.role', $u) }}">
                                @csrf @method('PUT')
                                <select name="role">
                                    @foreach ($roles as $r)
                                        <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-secondary btn-sm">Simpan</button>
                            </form>
                        @else
                            {{ $u->getRoleNames()->join(', ') }}
                        @endcan
                    </td>
                    <td>
                        <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-secondary btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $users->links() }}</div>
@endsection
