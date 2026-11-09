<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $kembali = fake()->optional()->dateTimeBetween('-9 days', 'now')?->format('Y-m-d');

        return [
            'anggota_id' => Anggota::inRandomOrder()->value('id'),
            'buku_id' => Buku::inRandomOrder()->value('id'),
            'status' => $kembali ? 'dikembalikan' : 'disetujui',
            'tanggal_pinjam' => fake()->dateTimeBetween('-30 days', '-10 days')->format('Y-m-d'),
            'tanggal_kembali' => $kembali,
        ];
    }
}
