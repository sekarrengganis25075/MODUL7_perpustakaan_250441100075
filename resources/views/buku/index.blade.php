@extends('layouts.lunaria')

@section('title', 'Daftar Buku - Lunaria Library')

@push('styles')
<style>
    .alert { display: none; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; }
    .alert.sukses { display: block; background: #e6f7ec; color: #1e7a3c; }
    .alert.info { display: block; background: #e3f3ff; color: #2c6fa3; }
    .alert.error { display: block; background: #fde8ee; color: #b3264f; }
    .alert ul { margin: 6px 0 0 18px; padding: 0; font-weight: 400; }

    .form-buku { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;
        background: var(--color-white); padding: 22px; border-radius: var(--radius); box-shadow: var(--shadow); margin-bottom: 28px; }
    .form-buku label { display: block; font-size: .85rem; font-weight: 600; color: var(--color-muted); margin-bottom: 4px; }
    .form-buku input, .form-buku select, .form-buku textarea { width: 100%; padding: 10px 14px; border: 2px solid var(--color-pink-soft);
        border-radius: 12px; font-family: inherit; font-size: .95rem; color: var(--color-text); background: #fff; }
    .form-buku textarea { resize: vertical; line-height: 1.5; }
    .form-buku input:focus, .form-buku select:focus, .form-buku textarea:focus { outline: none; border-color: var(--color-pink); }
    .form-buku .invalid { border-color: #e85d94 !important; background: #fff5f8; }
    .pesan-field { color: #b3264f; font-size: .8rem; margin: 4px 0 0; }

    .form-buku input[type=number]::-webkit-outer-spin-button,
    .form-buku input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .form-buku input[type=number] { -moz-appearance: textfield; appearance: textfield; }
    .form-aksi { grid-column: 1 / -1; display: flex; gap: 10px; }

    .tabel-wrap { background: var(--color-white); border-radius: var(--radius); box-shadow: var(--shadow); overflow-x: auto; }
    .tabel-buku { width: 100%; border-collapse: collapse; }
    .tabel-buku th, .tabel-buku td { text-align: left; padding: 12px 16px; border-bottom: 1px solid var(--color-pink-soft); }
    .tabel-buku th { background: var(--color-pink-soft); color: var(--color-pink-dark); }
    .tabel-buku td.aksi { white-space: nowrap; }
    .btn-ikon { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px;
        border-radius: 999px; border: none; cursor: pointer; text-decoration: none; vertical-align: middle;
        background: var(--color-blue-soft); color: var(--color-blue-dark); transition: transform .15s ease; }
    .btn-ikon:hover { transform: translateY(-2px); background: var(--color-blue); color: #fff; }
    .btn-ikon.hapus { background: #fde8ee; color: #b3264f; }
    .btn-ikon.hapus:hover { background: #e85d94; color: #fff; }

    .modal-overlay { position: fixed; inset: 0; background: rgba(74, 59, 71, .45); display: none;
        align-items: center; justify-content: center; padding: 20px; z-index: 50; }
    .modal-overlay.tampil { display: flex; }
    .modal-kartu { background: var(--color-white); border-radius: var(--radius); box-shadow: 0 12px 40px rgba(232, 93, 148, .3);
        max-width: 420px; width: 100%; padding: 28px; text-align: center; }
    .modal-kartu h3 { margin: 0 0 8px; color: var(--color-pink-dark); }
    .modal-kartu p { margin: 0 0 22px; color: var(--color-text); }
    .modal-aksi { display: flex; gap: 10px; justify-content: center; }
    .btn-bahaya { background: #e85d94; color: #fff; box-shadow: 0 6px 16px rgba(232, 93, 148, .35); }
    .btn-bahaya:hover { background: #d44683; transform: translateY(-2px); }
    .btn-sm { padding: 6px 16px; font-size: .85rem; }
    .btn-hapus { background: #fde8ee; color: #b3264f; }
    .btn-hapus:hover { background: #e85d94; color: #fff; transform: translateY(-2px); }
    .paginasi { display: flex; align-items: center; justify-content: center; gap: 14px; margin: 22px 0; }
    .paginasi button:disabled { opacity: .45; cursor: not-allowed; transform: none; }
</style>
@endpush

@section('content')
    <h2 class="page-title">Daftar Buku</h2>
    <p class="page-subtitle" id="info-total">Memuat data...</p>

    <div id="pesan" class="alert" role="alert"></div>

    @can('kelola-data-buku')
    <form id="form-buku" class="form-buku" novalidate>
        <div>
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id">
                <option value="">-- Pilih kategori --</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul" placeholder="Judul buku">
        </div>
        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" placeholder="Nama penulis">
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" placeholder="mis. 2020">
        </div>
        <div style="grid-column: 1 / -1">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea id="deskripsi" rows="3" placeholder="Sinopsis singkat buku"></textarea>
        </div>
        <div class="form-aksi">
            <button type="submit" id="btn-simpan" class="btn btn-primary">Tambah</button>
            <button type="button" id="btn-batal-tambah" class="btn btn-secondary">Batal</button>
        </div>
    </form>
    @endcan

    <form id="form-cari" class="search-form">
        <span class="search-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </span>
        <input type="text" id="cari" class="search-input" placeholder="Cari judul, penulis, atau kategori...">
        <a href="#" id="reset-cari" class="search-reset" style="display:none">Atur Ulang</a>
        <button type="submit" class="search-btn">Cari</button>
    </form>

    <div class="tabel-wrap">
        <table class="tabel-buku">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-buku">
                <tr><td colspan="6">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="paginasi">
        <button type="button" id="btn-prev" class="btn btn-secondary">&laquo; Sebelumnya</button>
        <span id="info-halaman"></span>
        <button type="button" id="btn-next" class="btn btn-secondary">Berikutnya &raquo;</button>
    </div>
    
    <section class="buku-terbaru" style="margin-top:28px">
        <h3 class="page-title" style="font-size:1.2rem">Buku Terbaru</h3>
        <ul>
            @foreach ($bukuTerbaru as $b)
                {{-- [A1 - RENTAN] {!! !!} tidak melakukan escaping (Stored XSS) --}}
                <li><a href="{{ url('/buku/'.$b->id) }}">{!! $b->judul !!}</a></li>
            @endforeach
        </ul>
    </section>

    <div id="modal-hapus" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-judul">
        <div class="modal-kartu">
            <h3 id="modal-judul">Hapus Buku?</h3>
            <p id="modal-teks"></p>
            <div class="modal-aksi">
                <button type="button" id="modal-batal" class="btn btn-secondary">Batal</button>
                <button type="button" id="modal-ok" class="btn btn-bahaya">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api/buku';
        const BISA_KELOLA = document.body.dataset.kelola === '1';
        const BISA_PINJAM = document.body.dataset.pinjam === '1';
        const HEADERS = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        };

        const el = (id) => document.getElementById(id);
        const pesanEl = el('pesan');
        let timerPesan = null;
        const tbody = el('tabel-buku');

        let daftarBuku = [];
        let halaman = 1;
        let lastPage = 1;
        let kataCari = '';

        function konfirmasi(teks) {
            return new Promise((resolve) => {
                const modal = el('modal-hapus');
                el('modal-teks').textContent = teks;
                modal.classList.add('tampil');
                el('modal-batal').focus();

                const tutup = (hasil) => {
                    modal.classList.remove('tampil');
                    el('modal-ok').removeEventListener('click', ok);
                    el('modal-batal').removeEventListener('click', batal);
                    modal.removeEventListener('click', klikLuar);
                    document.removeEventListener('keydown', tombol);
                    resolve(hasil);
                };
                const ok = () => tutup(true);
                const batal = () => tutup(false);
                const klikLuar = (e) => { if (e.target === modal) tutup(false); };
                const tombol = (e) => { if (e.key === 'Escape') tutup(false); };

                el('modal-ok').addEventListener('click', ok);
                el('modal-batal').addEventListener('click', batal);
                modal.addEventListener('click', klikLuar);
                document.addEventListener('keydown', tombol);
            });
        }

        function tampilPesan(teks, jenis, daftar = []) {
            clearTimeout(timerPesan);
            pesanEl.className = 'alert ' + jenis;
            pesanEl.textContent = teks;
            if (daftar.length) {
                const ul = document.createElement('ul');
                daftar.forEach(m => { const li = document.createElement('li'); li.textContent = m; ul.appendChild(li); });
                pesanEl.appendChild(ul);
            }
            if (jenis !== 'error') timerPesan = setTimeout(sembunyikanPesan, 4000);
        }

        function sembunyikanPesan() {
            clearTimeout(timerPesan);
            pesanEl.className = 'alert';
            pesanEl.textContent = '';
            bersihkanErrorField();
        }

        async function buatError(response) {
            let body = null;
            try { body = await response.json(); } catch (_) {}

            const err = new Error(body?.message || `Terjadi kesalahan pada server (status ${response.status}).`);
            if (response.status === 422 && body?.errors) {
                err.message = 'Data yang dikirim tidak valid:';
                err.detail = Object.values(body.errors).flat();
                err.fields = body.errors;
            } else if (response.status === 404) {
                err.message = 'Data buku tidak ditemukan (mungkin sudah dihapus).';
            }
            return err;
        }

        function bersihkanErrorField() {
            document.querySelectorAll('.pesan-field').forEach(e => e.remove());
            document.querySelectorAll('.form-buku .invalid').forEach(e => e.classList.remove('invalid'));
        }

        function tampilkanErrorField(errors) {
            bersihkanErrorField();
            Object.entries(errors).forEach(([nama, daftar]) => {
                const input = el(nama);
                if (!input) return;
                input.classList.add('invalid');
                const p = document.createElement('p');
                p.className = 'pesan-field';
                p.textContent = daftar[0];
                input.parentElement.appendChild(p);
            });
        }

        function tampilError(judul, err) {
            console.error(judul, err);
            if (err.fields) {
                tampilPesan(`${judul}: periksa kembali isian yang bertanda merah.`, 'error');
                tampilkanErrorField(err.fields);
            } else if (err instanceof TypeError) {
                tampilPesan(`${judul}: API tidak dapat diakses. Periksa koneksi atau pastikan server berjalan.`, 'error');
            } else {
                tampilPesan(`${judul}: ${err.message}`, 'error', err.detail || []);
            }
        }

        const KUNCI_STATE = 'buku_state';

        let stateSiap = false;
        let scrollSudahDipulihkan = false;

        function simpanState() {
            try {
                sessionStorage.setItem(KUNCI_STATE, JSON.stringify({ halaman, kataCari, scrollY: window.scrollY }));
            } catch (_) {}
        }

        window.addEventListener('pagehide', () => { if (stateSiap) simpanState(); });

        function bacaState() {
            try { return JSON.parse(sessionStorage.getItem(KUNCI_STATE)) || {}; } catch (_) { return {}; }
        }

        function buatParams(page) {
            const params = new URLSearchParams({ page, urut: 'asc' });   // lama -> baru
            if (kataCari) params.set('cari', kataCari);
            return params;
        }

        async function cariHalamanAkhir() {
            const response = await fetch(`${API_URL}?${buatParams(1)}`, { headers: HEADERS });
            if (!response.ok) throw await buatError(response);
            return (await response.json()).meta.last_page;
        }

        let permintaanTerakhir = 0;

        async function muatBuku(page = halaman) {
            const nomorPermintaan = ++permintaanTerakhir;
            try {
                if (page === 'akhir') page = await cariHalamanAkhir();

                const response = await fetch(`${API_URL}?${buatParams(page)}`, { headers: HEADERS });
                if (!response.ok) throw await buatError(response);

                const hasil = await response.json();
                if (nomorPermintaan !== permintaanTerakhir) return;
                daftarBuku = hasil.data;
                halaman = hasil.meta.current_page;
                lastPage = hasil.meta.last_page;

                if (daftarBuku.length === 0 && halaman > lastPage && lastPage >= 1) {
                    return muatBuku(lastPage);
                }

                renderTabel(hasil.meta);
                stateSiap = true;
                simpanState();

                if (!scrollSudahDipulihkan) {
                    scrollSudahDipulihkan = true;
                    if (stateAwal.scrollY > 0) window.scrollTo(0, stateAwal.scrollY);
                }
            } catch (err) {
                tbody.innerHTML = '<tr><td colspan="6">Data buku tidak dapat ditampilkan.</td></tr>';
                tampilError('Gagal memuat data buku', err);
            }
        }

        function renderTabel(meta) {
            tbody.innerHTML = '';

            if (daftarBuku.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center">${
                    kataCari ? '<strong>Buku Tidak Ditemukan</strong>' : 'Belum ada data buku yang tersedia.'
                }</td></tr>`;
            }

            daftarBuku.forEach((b, i) => {
                const tr = document.createElement('tr');
                [(meta.per_page * (meta.current_page - 1)) + i + 1, b.kategori ?? '-', b.judul_buku, b.penulis, b.tahun]
                    .forEach(nilai => { const td = document.createElement('td'); td.textContent = nilai; tr.appendChild(td); });

                const aksi = document.createElement('td');
                aksi.className = 'aksi';
                aksi.innerHTML = `
                    <a href="{{ url('/buku') }}/${b.id}" class="btn btn-secondary btn-sm">Detail</a>
                    ${BISA_PINJAM ? `<form method="POST" action="{{ route('peminjaman.store') }}" style="display:inline">@csrf<input type="hidden" name="buku_id" value="${b.id}"><button type="submit" class="btn btn-primary btn-sm">Pinjam</button></form>` : ''}
                    ${BISA_KELOLA ? `<a href="{{ url('/buku') }}/${b.id}/edit" class="btn-ikon" title="Ubah" aria-label="Ubah buku">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </a>
                    <button type="button" class="btn-ikon hapus" title="Hapus" aria-label="Hapus buku" data-aksi="hapus" data-id="${b.id}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    </button>` : ''}`;
                tr.appendChild(aksi);
                tbody.appendChild(tr);
            });

            el('info-total').textContent = kataCari
                ? `Menampilkan ${meta.total} hasil untuk "${kataCari}".`
                : `Total ${meta.total} buku tersedia di perpustakaan.`;
            el('info-halaman').textContent = `Halaman ${meta.current_page} dari ${meta.last_page}`;
            el('btn-prev').disabled = meta.current_page <= 1;
            el('btn-next').disabled = meta.current_page >= meta.last_page;
        }

        if (BISA_KELOLA) {
        el('form-buku').addEventListener('submit', async (e) => {
            e.preventDefault();
            sembunyikanPesan();
            const payload = {
                kategori_id: el('kategori_id').value,
                judul: el('judul').value,
                penulis: el('penulis').value,
                tahun_terbit: el('tahun_terbit').value,
                deskripsi: el('deskripsi').value,
            };

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: HEADERS,
                    body: JSON.stringify(payload),
                });
                if (!response.ok) throw await buatError(response);

                tampilPesan('Buku berhasil ditambahkan.', 'sukses');
                el('form-buku').reset();
                await muatBuku('akhir');
            } catch (err) {
                tampilError('Gagal menambahkan buku', err);
            }
        });

        el('tahun_terbit').addEventListener('wheel', (e) => e.target.blur(), { passive: true });

        el('btn-batal-tambah').addEventListener('click', () => {
            el('form-buku').reset();
            sembunyikanPesan();
        });
        }

        tbody.addEventListener('click', async (e) => {
            const btn = e.target.closest('button[data-aksi]');
            if (!btn) return;
            const id = btn.dataset.id;

            const buku = daftarBuku.find(x => String(x.id) === id);
            const setuju = await konfirmasi(`Yakin ingin menghapus buku "${buku ? buku.judul_buku : 'ini'}"?`);
            if (!setuju) return;
            sembunyikanPesan();

            try {
                const response = await fetch(`${API_URL}/${id}`, { method: 'DELETE', headers: HEADERS });
                if (!response.ok) throw await buatError(response);

                tampilPesan('Buku berhasil dihapus.', 'sukses');
                await muatBuku(daftarBuku.length === 1 && halaman > 1 ? halaman - 1 : halaman);
            } catch (err) {
                tampilError('Gagal menghapus buku', err);
            }
        });

        let timerCari = null;

        function terapkanCari() {
            kataCari = el('cari').value.trim();
            el('reset-cari').style.display = kataCari ? 'inline-block' : 'none';
            muatBuku(1);
        }

        el('cari').addEventListener('input', () => {
            clearTimeout(timerCari);
            timerCari = setTimeout(terapkanCari, 300);
        });

        el('form-cari').addEventListener('submit', (e) => {
            e.preventDefault();
            clearTimeout(timerCari);
            terapkanCari();
        });

        el('reset-cari').addEventListener('click', (e) => {
            e.preventDefault();
            el('cari').value = '';
            clearTimeout(timerCari);
            terapkanCari();
        });
        el('btn-prev').addEventListener('click', () => halaman > 1 && muatBuku(halaman - 1));
        el('btn-next').addEventListener('click', () => halaman < lastPage && muatBuku(halaman + 1));

        try {
            const flash = sessionStorage.getItem('pesan_sukses');
            if (flash) { tampilPesan(flash, 'sukses'); sessionStorage.removeItem('pesan_sukses'); }
        } catch (_) {}

        function perluPulihkan() {
            const nav = performance.getEntriesByType('navigation')[0];
            if (nav && (nav.type === 'reload' || nav.type === 'back_forward')) return true;
            try {
                return /^\/buku\/\d+(\/edit)?$/.test(new URL(document.referrer).pathname);
            } catch (_) {
                return false;
            }
        }

        const stateAwal = perluPulihkan() ? bacaState() : {};
        kataCari = stateAwal.kataCari || '';
        el('cari').value = kataCari;
        el('reset-cari').style.display = kataCari ? 'inline-block' : 'none';

        muatBuku(stateAwal.halaman > 0 ? stateAwal.halaman : 1);
    </script>
@endsection