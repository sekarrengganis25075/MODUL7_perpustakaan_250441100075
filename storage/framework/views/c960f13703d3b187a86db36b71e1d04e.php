<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Lunaria Library</title>

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/lunaria.css', 'resources/js/app.js']); ?>
    </head>
    <body class="auth-body">
        <header class="site-header">
            <div class="container">
                <h1 class="app-name">Lunaria Library</h1>
                <p class="app-tagline">Temukan dan jelajahi koleksi buku favoritmu</p>
            </div>
        </header>

        <main class="auth-wrap">
            <?php if(request()->routeIs('register')): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-lunaria btn-lunaria-outline" style="margin:34px 0 14px;padding:6px 16px;font-size:.8rem;text-decoration:none">&larr; Kembali ke Halaman Masuk</a>
            <?php else: ?>
                <a href="<?php echo e(route('home')); ?>" class="btn-lunaria btn-lunaria-outline" style="margin:34px 0 14px;padding:6px 16px;font-size:.8rem;text-decoration:none">&larr; Kembali ke Beranda</a>
            <?php endif; ?>

            <div class="auth-card">
                <?php echo e($slot); ?>

            </div>
            <p class="auth-foot">&copy; <?php echo e(date('Y')); ?> Lunaria Library</p>
        </main>
    </body>
</html><?php /**PATH C:\laragon\www\perpustakaan_250441100075 (2)\perpustakaan_250441100075\resources\views/layouts/guest.blade.php ENDPATH**/ ?>