
<?php $__env->startSection('title', 'Laporan - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Laporan Perpustakaan</h2>
    <div class="kartu-statistik">
        <div class="kartu"><small>Total Judul Buku</small><strong><?php echo e($totalBuku); ?></strong></div>
        <?php $__currentLoopData = ['diajukan' => 'Diajukan', 'disetujui' => 'Sedang Dipinjam', 'ditolak' => 'Ditolak', 'dikembalikan' => 'Dikembalikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="kartu"><small><?php echo e($label); ?></small><strong><?php echo e($perStatus[$k] ?? 0); ?></strong></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="panel">
        <h3>Buku per Kategori</h3>
        <ul><?php $__empty_1 = true; $__currentLoopData = $perKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($k->nama); ?>: <?php echo e($k->bukus_count); ?> buku</li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li style="list-style:none">Belum ada data.</li><?php endif; ?></ul>
    </div>
    <div class="panel">
        <h3>5 Buku Terpopuler</h3>
        <ol><?php $__empty_1 = true; $__currentLoopData = $terpopuler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($b->judul); ?> (<?php echo e($b->peminjamans_count); ?>x dipinjam)</li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li style="list-style:none">Belum ada data.</li><?php endif; ?></ol>
    </div>
    <div class="panel">
        <h3>Peminjaman Terlambat (lebih dari 7 hari)</h3>
        <ul><?php $__empty_1 = true; $__currentLoopData = $terlambat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><li><?php echo e($t->namaPeminjam()); ?> — <?php echo e($t->buku->judul); ?> (sejak <?php echo e($t->tanggal_pinjam->format('d M Y')); ?>)</li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><li style="list-style:none">Tidak ada.</li><?php endif; ?></ul>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/laporan/index.blade.php ENDPATH**/ ?>