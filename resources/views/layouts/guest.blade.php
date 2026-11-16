<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Lunaria Library - 250441100075</title>

        @vite(['resources/css/app.css', 'resources/css/lunaria.css', 'resources/js/app.js'])
    </head>
    <body class="auth-body">
        <header class="site-header">
            <div class="container">
                <h1 class="Lunaria Library - 250441100075">Lunaria Library</h1>
                <p class="app-tagline">Temukan dan jelajahi koleksi buku favoritmu</p>
            </div>
        </header>

        <main class="auth-wrap">
            @if (request()->routeIs('register'))
                <a href="{{ route('login') }}" class="btn-lunaria btn-lunaria-outline" style="margin:34px 0 14px;padding:6px 16px;font-size:.8rem;text-decoration:none">&larr; Kembali ke Halaman Masuk</a>
            @else
                <a href="{{ route('home') }}" class="btn-lunaria btn-lunaria-outline" style="margin:34px 0 14px;padding:6px 16px;font-size:.8rem;text-decoration:none">&larr; Kembali ke Beranda</a>
            @endif

            <div class="auth-card">
                {{ $slot }}
            </div>
            <p class="auth-foot">&copy; {{ date('Y') }} Lunaria Library</p>
        </main>
    </body>
</html>