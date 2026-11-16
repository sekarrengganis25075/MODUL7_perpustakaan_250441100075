<?php

$tmp = '/tmp';

foreach ([
    'storage/app/public',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
] as $dir) {
    if (! is_dir("$tmp/$dir")) {
        mkdir("$tmp/$dir", 0777, true);
    }
}

$paths = [
    'LARAVEL_STORAGE_PATH' => "$tmp/storage",
    'VIEW_COMPILED_PATH'   => "$tmp/storage/framework/views",
    'APP_SERVICES_CACHE'   => "$tmp/bootstrap/cache/services.php",
    'APP_PACKAGES_CACHE'   => "$tmp/bootstrap/cache/packages.php",
    'APP_CONFIG_CACHE'     => "$tmp/bootstrap/cache/config.php",
    'APP_ROUTES_CACHE'     => "$tmp/bootstrap/cache/routes.php",
    'APP_EVENTS_CACHE'     => "$tmp/bootstrap/cache/events.php",
];

if (getenv('LOG_CHANNEL') === false) {
    $paths['LOG_CHANNEL'] = 'stderr';
}

foreach ($paths as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $_SERVER[$key] = $value;
}

if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';

require __DIR__ . '/../public/index.php';