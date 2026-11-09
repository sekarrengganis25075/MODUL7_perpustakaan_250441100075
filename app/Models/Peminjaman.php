<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 'anggota_id', 'buku_id', 'status', 'tanggal_pinjam', 'tanggal_kembali',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
    ];

    public const DIAJUKAN     = 'diajukan';
    public const DISETUJUI    = 'disetujui';
    public const DITOLAK      = 'ditolak';
    public const DIKEMBALIKAN = 'dikembalikan';

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function namaPeminjam(): string
    {
        return $this->user?->name ?? $this->anggota?->nama ?? '-';
    }
}