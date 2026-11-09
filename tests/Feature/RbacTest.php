<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function akun(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function buku(string $judul = 'Laravel Dasar'): Buku
    {
        $kategori = Kategori::firstOrCreate(['nama' => 'Teknologi']);

        return Buku::create([
            'kategori_id' => $kategori->id, 'judul' => $judul, 'penulis' => 'Taylor',
            'tahun_terbit' => 2024, 'deskripsi' => 'Contoh',
        ]);
    }

    private function dataBuku(array $ubah = []): array
    {
        $kategori = Kategori::firstOrCreate(['nama' => 'Teknologi']);

        return array_merge([
            'kategori_id' => $kategori->id, 'judul' => 'PHP Modern', 'penulis' => 'Rasmus',
            'tahun_terbit' => 2020, 'deskripsi' => 'Buku PHP',
        ], $ubah);
    }

    public function test_01_belum_login_ke_dashboard_admin_dialihkan_ke_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_02_admin_membuka_dashboard_admin(): void
    {
        $this->actingAs($this->akun('admin@perpus.test'))->get('/admin/dashboard')->assertOk();
    }

    public function test_03_admin_tambah_ubah_hapus_buku(): void
    {
        $admin = $this->akun('admin@perpus.test');

        $this->actingAs($admin)->postJson('/api/buku', $this->dataBuku())->assertCreated();
        $buku = Buku::where('judul', 'PHP Modern')->firstOrFail();

        $this->actingAs($admin)->putJson("/api/buku/{$buku->id}", $this->dataBuku(['judul' => 'PHP 8']))->assertOk();
        $this->assertDatabaseHas('bukus', ['id' => $buku->id, 'judul' => 'PHP 8']);

        $this->actingAs($admin)->deleteJson("/api/buku/{$buku->id}")->assertOk();
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_04_admin_mengelola_akun_dan_role(): void
    {
        $admin = $this->akun('admin@perpus.test');
        $siswa = $this->akun('siswa@perpus.test');

        $this->actingAs($admin)->get('/users')->assertOk();
        $this->actingAs($admin)->put("/users/{$siswa->id}/role", ['role' => 'petugas'])->assertSessionHasNoErrors();
        $this->assertTrue($siswa->fresh()->hasRole('petugas'));
        $this->assertFalse($siswa->fresh()->hasRole('siswa'));
    }

    public function test_05_admin_mengakses_peminjaman_pengembalian_dan_laporan(): void
    {
        $admin = $this->akun('admin@perpus.test');
        $this->actingAs($admin)->get('/kelola/peminjaman')->assertOk();
        $this->actingAs($admin)->get('/kelola/pengembalian')->assertOk();
        $this->actingAs($admin)->get('/laporan')->assertOk();
    }

    public function test_06_petugas_membuka_dashboard_petugas(): void
    {
        $this->actingAs($this->akun('petugas@perpus.test'))->get('/petugas/dashboard')->assertOk();
    }

    public function test_07_petugas_mengelola_data_buku(): void
    {
        $this->actingAs($this->akun('petugas@perpus.test'))
            ->postJson('/api/buku', $this->dataBuku(['judul' => 'Dari Petugas']))->assertCreated();
        $this->assertDatabaseHas('bukus', ['judul' => 'Dari Petugas']);
    }

    public function test_08_petugas_memproses_peminjaman_dan_pengembalian(): void
    {
        $petugas = $this->akun('petugas@perpus.test');
        $pinjam = Peminjaman::create([
            'user_id' => $this->akun('siswa@perpus.test')->id,
            'buku_id' => $this->buku()->id,
            'status' => 'diajukan',
        ]);

        $this->actingAs($petugas)->post("/kelola/peminjaman/{$pinjam->id}/setujui")->assertSessionHasNoErrors();
        $this->assertSame('disetujui', $pinjam->fresh()->status);
        $this->assertNotNull($pinjam->fresh()->tanggal_pinjam);

        $this->actingAs($petugas)->post("/kelola/pengembalian/{$pinjam->id}")->assertSessionHasNoErrors();
        $this->assertSame('dikembalikan', $pinjam->fresh()->status);
        $this->assertNotNull($pinjam->fresh()->tanggal_kembali);
    }

    public function test_09_petugas_ditolak_mengelola_akun_dan_role(): void
    {
        $petugas = $this->akun('petugas@perpus.test');
        $siswa = $this->akun('siswa@perpus.test');

        $this->actingAs($petugas)->get('/users')->assertForbidden();
        $this->actingAs($petugas)->put("/users/{$siswa->id}/role", ['role' => 'admin'])->assertForbidden();
        $this->assertTrue($siswa->fresh()->hasRole('siswa'));
    }

    public function test_10_siswa_melihat_daftar_dan_detail_buku(): void
    {
        $siswa = $this->akun('siswa@perpus.test');
        $buku = $this->buku();

        $this->actingAs($siswa)->get('/buku')->assertOk();
        $this->actingAs($siswa)->get("/buku/{$buku->id}")->assertOk();
        $this->actingAs($siswa)->getJson('/api/buku')->assertOk();
    }

    public function test_11_siswa_melihat_dan_memperbarui_profil_sendiri(): void
    {
        $siswa = $this->akun('siswa@perpus.test');

        $this->actingAs($siswa)->get('/profile')->assertOk();
        $this->actingAs($siswa)->patch('/profile', ['name' => 'Nama Baru', 'email' => $siswa->email])
            ->assertSessionHasNoErrors();
        $this->assertSame('Nama Baru', $siswa->fresh()->name);
    }

    public function test_12_siswa_melihat_riwayat_peminjaman_sendiri(): void
    {
        $siswa = $this->akun('siswa@perpus.test');
        Peminjaman::create(['user_id' => $siswa->id, 'buku_id' => $this->buku('Buku Saya')->id, 'status' => 'diajukan']);

        $this->actingAs($siswa)->get('/riwayat')->assertOk()->assertSee('Buku Saya');
    }

    public function test_13_siswa_ditolak_dashboard_admin_dan_kelola_buku(): void
    {
        $siswa = $this->akun('siswa@perpus.test');

        $this->actingAs($siswa)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($siswa)->get('/petugas/dashboard')->assertForbidden();
        $this->actingAs($siswa)->get('/buku/1/edit')->assertForbidden();
        $this->actingAs($siswa)->postJson('/api/buku', $this->dataBuku())->assertForbidden();
        $this->actingAs($siswa)->get('/laporan')->assertForbidden();
        $this->actingAs($siswa)->get('/kelola/peminjaman')->assertForbidden();
    }

    public function test_14_siswa_ditolak_melihat_riwayat_siswa_lain(): void
    {
        $lain = $this->akun('siswa2@perpus.test');
        Peminjaman::create(['user_id' => $lain->id, 'buku_id' => $this->buku('Rahasia')->id, 'status' => 'disetujui']);

        $this->actingAs($this->akun('siswa@perpus.test'))->get("/riwayat/{$lain->id}")->assertForbidden();
    }

    public function test_15_setelah_logout_harus_login_kembali(): void
    {
        $this->actingAs($this->akun('siswa@perpus.test'))->post('/logout');

        $this->assertGuest();
        $this->get('/buku')->assertRedirect('/login');
    }

    public function test_registrasi_selalu_menjadi_siswa_walau_mengirim_role_admin(): void
    {
        $this->post('/register', [
            'name' => 'Penyusup', 'email' => 'penyusup@test.com',
            'password' => 'password-kuat-123', 'password_confirmation' => 'password-kuat-123',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'penyusup@test.com')->firstOrFail();
        $this->assertTrue($user->hasRole('siswa'));
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_user_yang_sudah_login_tidak_bisa_membuka_halaman_login(): void
    {
        $this->actingAs($this->akun('siswa@perpus.test'))->get('/login')->assertRedirect();
    }

    public function test_login_dengan_kredensial_salah_gagal(): void
    {
        $this->post('/login', ['email' => 'siswa@perpus.test', 'password' => 'salah-total']);
        $this->assertGuest();
    }

    public function test_api_buku_tanpa_login_ditolak(): void
    {
        $this->getJson('/api/buku')->assertUnauthorized();
    }

    public function test_password_tersimpan_ter_hash(): void
    {
        $this->assertNotSame('password', $this->akun('siswa@perpus.test')->password);
    }
}