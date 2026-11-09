<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Lunaria Library'); ?></title>

    <?php echo $__env->yieldPushContent('before-styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/lunaria.css']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body <?php if(auth()->guard()->check()): ?> data-kelola="<?php echo e(auth()->user()->can('kelola-data-buku') ? '1' : '0'); ?>" data-pinjam="<?php echo e(auth()->user()->can('ajukan-peminjaman-buku') ? '1' : '0'); ?>" <?php endif; ?>>

    <header class="site-header">
        <?php if(auth()->guard()->check()): ?>
        <button type="button" id="tombol-menu" class="tombol-menu" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true">
                <line x1="4" y1="6" x2="20" y2="6"></line>
                <line x1="4" y1="12" x2="20" y2="12"></line>
                <line x1="4" y1="18" x2="20" y2="18"></line>
            </svg>
        </button>
        <?php endif; ?>
        <div class="container">
            <h1 class="app-name">Lunaria Library</h1>
            <p class="app-tagline">Temukan dan jelajahi koleksi buku favoritmu</p>
        </div>
    </header>

    <?php if(auth()->guard()->check()): ?>
    <div id="sidebar-latar" class="sidebar-latar" hidden></div>

    <aside id="sidebar" class="sidebar" aria-label="Menu utama" aria-hidden="true">
        <div class="sidebar-kepala">
            <span class="sidebar-merek">Lunaria Library</span>
            <button type="button" id="tombol-tutup" class="sidebar-tutup" aria-label="Tutup menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true">
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                </svg>
            </button>
        </div>

        <?php if(auth()->guard()->check()): ?>
            <div class="sidebar-pengguna">
                <span class="sidebar-avatar" aria-hidden="true"><?php echo e(mb_strtoupper(mb_substr(auth()->user()->name, 0, 1))); ?></span>
                <div>
                    <strong><?php echo e(auth()->user()->name); ?></strong>
                    <small><?php echo e(ucfirst(auth()->user()->getRoleNames()->join(', ') ?: 'tanpa peran')); ?></small>
                </div>
            </div>
        <?php endif; ?>

        <nav class="sidebar-menu">
            <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>
                Beranda
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard', 'admin.dashboard', 'petugas.dashboard') ? 'active' : ''); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                    Dasbor
                </a>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lihat-daftar-buku')): ?>
                    <a href="<?php echo e(route('buku.index')); ?>" class="<?php echo e(request()->routeIs('buku.*') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Daftar Buku
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola-peminjaman')): ?>
                    <a href="<?php echo e(route('kelola.peminjaman')); ?>" class="<?php echo e(request()->routeIs('kelola.peminjaman') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12H3"/><path d="M15 6l6 6-6 6"/></svg>
                        Peminjaman
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola-pengembalian')): ?>
                    <a href="<?php echo e(route('kelola.pengembalian')); ?>" class="<?php echo e(request()->routeIs('kelola.pengembalian') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12h18"/><path d="M9 6l-6 6 6 6"/></svg>
                        Pengembalian
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lihat-laporan-perpustakaan')): ?>
                    <a href="<?php echo e(route('laporan')); ?>" class="<?php echo e(request()->routeIs('laporan') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Laporan
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola-data-pengguna')): ?>
                    <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Pengguna
                    </a>
                <?php endif; ?>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'siswa')): ?>
                    <a href="<?php echo e(route('peminjaman.saya')); ?>" class="<?php echo e(request()->routeIs('peminjaman.saya') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                        Pinjaman Saya
                    </a>
                    <a href="<?php echo e(route('riwayat')); ?>" class="<?php echo e(request()->routeIs('riwayat') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        Riwayat
                    </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lihat-profil-sendiri')): ?>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <div class="sidebar-kaki">
            <?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="sidebar-keluar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </aside>
    <?php else: ?>
    <nav class="navbar">
        <div class="container navbar-inner">
                        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a>
        </div>
    </nav>
    <?php endif; ?>

    <main class="container main-content">
        <?php if(session('status')): ?>
            <div class="flash sukses"><?php echo e(__(session('status'))); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="flash error"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> Lunaria Library. Sebuah Tempat Kecil untuk Cerita Tanpa Akhir</p>
        </div>
    </footer>

    <script>
        (function () {
            if (!document.getElementById('sidebar')) return;
            var sidebar = document.getElementById('sidebar');
            var latar = document.getElementById('sidebar-latar');
            var tombolBuka = document.getElementById('tombol-menu');
            var tombolTutup = document.getElementById('tombol-tutup');

            function buka() {
                sidebar.classList.add('terbuka');
                sidebar.setAttribute('aria-hidden', 'false');
                latar.hidden = false;
                requestAnimationFrame(function () { latar.classList.add('tampil'); });
                tombolBuka.setAttribute('aria-expanded', 'true');
                document.body.classList.add('sidebar-aktif');
                tombolTutup.focus();
            }

            function tutup() {
                sidebar.classList.remove('terbuka');
                sidebar.setAttribute('aria-hidden', 'true');
                latar.classList.remove('tampil');
                setTimeout(function () { if (!sidebar.classList.contains('terbuka')) latar.hidden = true; }, 250);
                tombolBuka.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('sidebar-aktif');
                tombolBuka.focus();
            }

            tombolBuka.addEventListener('click', buka);
            tombolTutup.addEventListener('click', tutup);
            latar.addEventListener('click', tutup);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && sidebar.classList.contains('terbuka')) tutup();
            });
        })();

        document.querySelectorAll('.flash.sukses').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity .4s, margin .4s, padding .4s, height .4s';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 450);
            }, 4000);
        });
    </script>
</body>

</html><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/layouts/lunaria.blade.php ENDPATH**/ ?>