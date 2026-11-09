
<?php $__env->startSection('title', 'Beranda Siswa - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Halo, <?php echo e(auth()->user()->name); ?></h2>
    <p class="page-subtitle">Peminjaman aktif Anda</p>
    <div class="panel">
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $aktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li><?php echo e($p->buku->judul); ?> <span class="badge-status"><?php echo e(ucfirst($p->status)); ?></span></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li style="list-style:none">Belum ada peminjaman aktif.</li>
            <?php endif; ?>
        </ul>
        <p style="margin-top:12px"><a href="<?php echo e(route('buku.index')); ?>" class="btn btn-primary">Lihat Daftar Buku</a></p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/dashboard/siswa.blade.php ENDPATH**/ ?>