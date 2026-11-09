
<?php $__env->startSection('title', 'Kelola Pengguna - Lunaria Library'); ?>
<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Kelola Pengguna & Role</h2>
    <p style="margin:12px 0"><a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">+ Tambah Pengguna</a></p>
    <div class="tabel-wrap">
        <table class="tabel-data">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($u->name); ?></td>
                    <td><?php echo e($u->email); ?></td>
                    <td>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('kelola-role-pengguna')): ?>
                            <form method="POST" action="<?php echo e(route('users.role', $u)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <select name="role">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($r); ?>" <?php if($u->hasRole($r)): echo 'selected'; endif; ?>><?php echo e($r); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button class="btn btn-secondary btn-sm">Simpan</button>
                            </form>
                        <?php else: ?>
                            <?php echo e($u->getRoleNames()->join(', ')); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo e(route('users.destroy', $u)); ?>" onsubmit="return confirm('Hapus pengguna ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-secondary btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/users/index.blade.php ENDPATH**/ ?>