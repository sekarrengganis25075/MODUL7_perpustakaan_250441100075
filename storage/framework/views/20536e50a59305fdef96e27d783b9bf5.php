<?php $__env->startSection('title', 'Beranda - Lunaria Library'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero">
    <h2>Selamat Datang di Lunaria Library</h2>
    <p>
        Platform sederhana untuk menjelajahi koleksi buku secara online.
        Cari judul, penulis, dan kategori favoritmu dengan mudah.
    </p>
    <a href="<?php echo e(route('buku.index')); ?>" class="btn btn-primary">Lihat Daftar Buku</a>
</section>

<section class="info-grid">
    <div class="info-card">
        <h3>Koleksi Lengkap</h3>
        <p>Berbagai judul dari novel, non-fiksi, hingga pengembangan diri.</p>
    </div>
    <div class="info-card">
        <h3>Detail Buku</h3>
        <p>Lihat informasi penulis, tahun terbit, dan kategori tiap buku.</p>
    </div>
    <div class="info-card">
        <h3>Pencarian Mudah</h3>
        <p>Cari buku favoritmu berdasarkan judul, penulis, atau kategori.</p>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/home.blade.php ENDPATH**/ ?>