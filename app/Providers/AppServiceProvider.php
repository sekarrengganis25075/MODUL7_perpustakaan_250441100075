<?php

namespace App\Providers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);

        // Aturan pengelolaan buku dipusatkan di sini: hanya admin dan petugas.
        Gate::define('kelola-buku', fn (User $user): bool => $user->hasAnyRole(['admin', 'petugas']));
    }
}