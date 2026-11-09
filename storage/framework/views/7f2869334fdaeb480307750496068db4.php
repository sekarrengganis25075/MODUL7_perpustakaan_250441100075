
<?php $__env->startSection('title', 'Dasbor Petugas - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Dasbor Petugas</h2>
    <div class="kartu-statistik">
        <div class="kartu"><small>Total Buku</small><strong><?php echo e($totalBuku); ?></strong></div>
        <div class="kartu"><small>Menunggu Persetujuan</small><strong><?php echo e($menunggu); ?></strong></div>
        <div class="kartu"><small>Sedang Dipinjam</small><strong><?php echo e($dipinjam); ?></strong></div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/dashboard/petugas.blade.php ENDPATH**/ ?>