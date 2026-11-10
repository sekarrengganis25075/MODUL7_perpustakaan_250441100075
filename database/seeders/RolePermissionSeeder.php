<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'akses-dashboard-admin',
            'akses-dashboard-petugas',
            'lihat-daftar-buku',
            'kelola-data-buku',
            'kelola-data-pengguna',
            'kelola-role-pengguna',
            'kelola-peminjaman',
            'kelola-pengembalian',
            'ajukan-peminjaman-buku',
            'proses-persetujuan-peminjaman',
            'catat-pengembalian-buku',
            'lihat-status-peminjaman-sendiri',
            'lihat-riwayat-peminjaman-sendiri',
            'lihat-laporan-perpustakaan',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ];

        foreach ($permissions as $p) {
            Permission::findOrCreate($p, 'web');
        }

        $umum = [
            'lihat-daftar-buku', 'ajukan-peminjaman-buku',
            'lihat-status-peminjaman-sendiri', 'lihat-riwayat-peminjaman-sendiri',
            'lihat-profil-sendiri', 'ubah-profil-sendiri',
        ];

        $operasional = [
            'kelola-data-buku', 'kelola-peminjaman', 'kelola-pengembalian',
            'proses-persetujuan-peminjaman', 'catat-pengembalian-buku', 'lihat-laporan-perpustakaan',
        ];

        Role::findOrCreate('admin', 'web')->syncPermissions(array_merge($umum, $operasional, [
            'akses-dashboard-admin', 'kelola-data-pengguna', 'kelola-role-pengguna',
        ]));
        Role::findOrCreate('petugas', 'web')->syncPermissions(array_merge($umum, $operasional, [
            'akses-dashboard-petugas',
        ]));
        Role::findOrCreate('siswa', 'web')->syncPermissions($umum);

        $passwordAdmin = env('ADMIN_PASSWORD');
        if (! $passwordAdmin) {
            $passwordAdmin = Str::password(20, symbols: false);
            $this->command?->warn("ADMIN_PASSWORD kosong. Password admin acak: {$passwordAdmin}");
        }

        foreach ([
            ['Admin Perpustakaan', 'admin@perpus.test', 'admin'],
            ['Petugas Perpustakaan', 'petugas@perpus.test', 'petugas'],
            ['Siswa Contoh', 'siswa@perpus.test', 'siswa'],
            ['Siswa Lain', 'siswa2@perpus.test', 'siswa'],
        ] as [$nama, $email, $role]) {
            $password = $role === 'admin' ? $passwordAdmin : 'password';

            $u = User::firstOrCreate(['email' => $email], [
                'name' => $nama,
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            if ($role === 'admin') {
                $u->forceFill(['password' => $password])->save();
            }
            $u->syncRoles([$role]);
        }
    }
}