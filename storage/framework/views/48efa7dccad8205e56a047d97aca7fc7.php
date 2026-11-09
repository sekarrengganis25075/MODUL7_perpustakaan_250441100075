
<?php $__env->startSection('title', 'Pinjaman Saya - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Status Peminjaman Saya</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Buku</th><th>Status</th><th>Tanggal Pinjam</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->buku->judul); ?></td>
                    <td><span class="badge-status"><?php echo e($p->status); ?></span></td>
                    <td><?php echo e($p->tanggal_pinjam?->format('d M Y') ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" style="text-align:center">Tidak ada peminjaman aktif.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/peminjaman/saya.blade.php ENDPATH**/ ?>