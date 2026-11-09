
<?php $__env->startSection('title', 'Detail Peminjaman - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Detail Peminjaman #<?php echo e($peminjaman->id); ?></h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <tbody>
                <tr><th>Peminjam</th><td><?php echo e($peminjaman->namaPeminjam()); ?></td></tr>
                <tr><th>Buku</th><td><?php echo e($peminjaman->buku?->judul ?? '-'); ?></td></tr>
                <tr><th>Status</th><td><span class="badge-status"><?php echo e($peminjaman->status); ?></span></td></tr>
                <tr><th>Tanggal Pinjam</th><td><?php echo e($peminjaman->tanggal_pinjam?->format('d M Y') ?? '-'); ?></td></tr>
                <tr><th>Tanggal Kembali</th><td><?php echo e($peminjaman->tanggal_kembali?->format('d M Y') ?? '-'); ?></td></tr>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/peminjaman/show.blade.php ENDPATH**/ ?>