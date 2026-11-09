<?php $__env->startSection('title', 'Profil — Lunaria Library'); ?>

<?php $__env->startPush('before-styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="page-title">Profil Saya</h2>

    <div class="profile-stack">
        <div class="profile-card">
            <div class="profile-inner">
                <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-inner">
                <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-inner">
                <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lunaria', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan_250441100075\resources\views/profile/edit.blade.php ENDPATH**/ ?>