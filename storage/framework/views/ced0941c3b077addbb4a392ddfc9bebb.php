
<?php $__env->startSection('title', 'Riwayat Peminjaman - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Riwayat Peminjaman — <?php echo e($target->name); ?></h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Buku</th><th>Status</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->buku->judul); ?></td>
                    <td><span class="badge-status"><?php echo e($p->status); ?></span></td>
                    <td><?php echo e($p->tanggal_pinjam?->format('d M Y') ?? '-'); ?></td>
                    <td><?php echo e($p->tanggal_kembali?->format('d M Y') ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" style="text-align:center">Belum ada riwayat peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px"><?php echo e($list->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/peminjaman/riwayat.blade.php ENDPATH**/ ?>