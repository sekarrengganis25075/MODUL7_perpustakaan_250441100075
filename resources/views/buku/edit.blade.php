@extends('layouts.lunaria')

@section('title', 'Ubah Buku - Lunaria Library')

@push('styles')
<style>
    .alert { display: none; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; }
    .alert.sukses { display: block; background: #e6f7ec; color: #1e7a3c; }
    .alert.info { display: block; background: #e3f3ff; color: #2c6fa3; }
    .alert.error { display: block; background: #fde8ee; color: #b3264f; }
    .alert ul { margin: 6px 0 0 18px; padding: 0; font-weight: 400; }

    .form-buku { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;
        background: var(--color-white); padding: 26px; border-radius: var(--radius); box-shadow: var(--shadow); }
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
</style>
@endpush

@section('content')
    <a href="{{ route('buku.index') }}" class="back-link">&larr; Kembali ke Daftar Buku</a>

    <h2 class="page-title">Ubah Buku</h2>
    <p class="page-subtitle" id="info">Memuat data buku...</p>

    <div id="pesan" class="alert" role="alert"></div>

    <form id="form-buku" class="form-buku" novalidate style="display:none"
          data-id="{{ $id }}" data-kembali="{{ route('buku.index') }}">
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
            <input type="text" id="judul">
        </div>
        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis">
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit">
        </div>
        <div style="grid-column: 1 / -1">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea id="deskripsi" rows="4"></textarea>
        </div>
        <div class="form-aksi">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    <script>
        const FORM = document.getElementById('form-buku');
        const BUKU_ID = FORM.dataset.id;
        const API_URL = '/api/buku/' + BUKU_ID;
        const HEADERS = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        };

        const el = (id) => document.getElementById(id);
        const pesanEl = el('pesan');
        let timerPesan = null;

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

        let dataAsli = null;

        function ambilIsiForm() {
            return {
                kategori_id: String(el('kategori_id').value),
                judul: el('judul').value.trim(),
                penulis: el('penulis').value.trim(),
                tahun_terbit: String(el('tahun_terbit').value),
                deskripsi: el('deskripsi').value.trim(),
            };
        }

        async function muatBuku() {
            try {
                const response = await fetch(API_URL, { headers: HEADERS });
                if (!response.ok) throw await buatError(response);

                const { data: b } = await response.json();
                el('kategori_id').value = b.kategori_id;
                el('judul').value = b.judul_buku;
                el('penulis').value = b.penulis;
                el('tahun_terbit').value = b.tahun;
                el('deskripsi').value = b.deskripsi ?? '';
                dataAsli = ambilIsiForm();

                el('info').textContent = `Mengubah data buku: ${b.judul_buku}`;
                el('form-buku').style.display = 'grid';
            } catch (err) {
                el('info').textContent = 'Data buku tidak dapat ditampilkan.';
                tampilError('Gagal memuat data buku', err);
            }
        }

        el('form-buku').addEventListener('submit', async (e) => {
            e.preventDefault();
            sembunyikanPesan();

            if (dataAsli && JSON.stringify(ambilIsiForm()) === JSON.stringify(dataAsli)) {
                tampilPesan('Tidak ada perubahan data.', 'info');
                return;
            }

            const payload = {
                kategori_id: el('kategori_id').value,
                judul: el('judul').value,
                penulis: el('penulis').value,
                tahun_terbit: el('tahun_terbit').value,
                deskripsi: el('deskripsi').value,
            };

            try {
                const response = await fetch(API_URL, {
                    method: 'PUT',
                    headers: HEADERS,
                    body: JSON.stringify(payload),
                });
                if (!response.ok) throw await buatError(response);

                try { sessionStorage.setItem('pesan_sukses', 'Buku berhasil diperbarui.'); } catch (_) {}
                window.location.href = FORM.dataset.kembali;
            } catch (err) {
                tampilError('Gagal memperbarui buku', err);
            }
        });

        el('tahun_terbit').addEventListener('wheel', (e) => e.target.blur(), { passive: true });

        muatBuku();
    </script>
@endsection