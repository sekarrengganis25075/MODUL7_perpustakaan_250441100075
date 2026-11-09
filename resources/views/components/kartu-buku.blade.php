@props(['judul', 'penulis', 'tahun', 'url' => '#'])

<div class="kartu-buku">
    <div class="kartu-buku-body">
        <h3 class="kartu-buku-judul">{{ $judul }}</h3>
        <p class="kartu-buku-penulis">{{ $penulis }}</p>
        <p class="kartu-buku-tahun">Terbit: {{ $tahun }}</p>

        @isset($meta)
            <div class="kartu-buku-meta">
                {{ $meta }}
            </div>
        @endisset

        <a href="{{ $url }}" class="btn btn-secondary">Lihat Detail</a>
    </div>

    {{ $slot ?? '' }}
</div>
