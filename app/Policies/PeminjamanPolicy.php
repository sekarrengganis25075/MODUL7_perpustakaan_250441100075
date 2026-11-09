<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        return $peminjaman->user_id !== null && $user->id === $peminjaman->user_id;
    }

    public function viewRiwayat(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->can('kelola-peminjaman');
    }
}