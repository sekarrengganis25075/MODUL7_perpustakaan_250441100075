
<?php $__env->startSection('title', 'Tambah Pengguna - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Tambah Pengguna</h2>
    <form method="POST" action="<?php echo e(route('users.store')); ?>" class="form-tampah" style="margin-top:16px">
        <?php echo csrf_field(); ?>
        <div><label>Nama</label><input name="name" value="<?php echo e(old('name')); ?>" required></div>
        <div><label>Email</label><input type="email" name="email" value="<?php echo e(old('email')); ?>" required></div>
        <div><label>Kata Sandi</label><input type="password" name="password" required></div>
        <div><label>Konfirmasi Kata Sandi</label><input type="password" name="password_confirmation" required></div>
        <div>
            <label>Role</label>
            <select name="role">
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r); ?>" <?php if(old('role') === $r): echo 'selected'; endif; ?>><?php echo e($r); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aksi-baris">
            <button class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/users/create.blade.php ENDPATH**/ ?>