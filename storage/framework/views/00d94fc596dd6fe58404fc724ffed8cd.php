<?php $__env->startSection('title', $buku ? 'Detail ' . $buku['judul'] : 'Buku Tidak Ditemukan'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($buku): ?>
        <div class="detail-buku">
            <a href="<?php echo e(route('buku.index')); ?>" class="back-link">&larr; Kembali ke Daftar Buku</a>

            <h2 class="page-title"><?php echo e($buku['judul']); ?></h2>
            <span class="badge"><?php echo e($buku['kategori']); ?></span>

            <table class="detail-table">
                <tr>
                    <th>ID Buku</th>
                    <td><?php echo e($buku['id']); ?></td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td><?php echo e($buku['judul']); ?></td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td><?php echo e($buku['penulis']); ?></td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td><?php echo e($buku['tahun']); ?></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><?php echo e($buku['kategori']); ?></td>
                </tr>
            </table>

            <div class="detail-deskripsi">
                <h3>Sinopsis</h3>
                <p><?php echo e($buku['deskripsi']); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h2>Buku Tidak Ditemukan</h2>
            <p>Maaf, data buku dengan ID tersebut tidak tersedia di perpustakaan.</p>
            <a href="<?php echo e(route('buku.index')); ?>" class="btn btn-primary">Kembali ke Daftar Buku</a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/buku/show.blade.php ENDPATH**/ ?>