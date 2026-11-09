
<?php $__env->startSection('title', 'Kelola Pengembalian - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Kelola Pengembalian</h2>
    <div class="tabel-wrap" style="margin-top:16px">
        <table class="tabel-data">
            <thead><tr><th>Peminjam</th><th>Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->namaPeminjam()); ?></td>
                    <td><?php echo e($p->buku->judul); ?></td>
                    <td><?php echo e($p->tanggal_pinjam?->format('d M Y') ?? '-'); ?></td>
                    <td><?php echo e($p->tanggal_kembali?->format('d M Y') ?? '-'); ?></td>
                    <td><span class="badge-status"><?php echo e($p->status); ?></span></td>
                    <td>
                        <?php if($p->status === 'disetujui'): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('catat-pengembalian-buku')): ?>
                                <form method="POST" action="<?php echo e(route('kelola.kembalikan', $p)); ?>"><?php echo csrf_field(); ?><button class="btn btn-primary btn-sm">Catat Kembali</button></form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center">Belum ada data pengembalian.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px"><?php echo e($list->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/peminjaman/pengembalian.blade.php ENDPATH**/ ?>