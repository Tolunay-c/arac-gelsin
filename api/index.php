<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// design-4 istekleri
if ($uri === 'design-4' || str_starts_with($uri, 'design-4/')) {
    $subPath = preg_replace('#^design-4/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../design-4');
    chdir($baseDir);

    if ($subPath === '' || $subPath === 'index.php') {
        require $baseDir . '/index.php';
        exit;
    }

    $target = realpath($baseDir . '/' . $subPath);
    if ($target && str_starts_with($target, $baseDir) && file_exists($target) && !is_dir($target)) {
        require $target;
    } else {
        require $baseDir . '/index.php';
    }
    exit;
}

// design-3 istekleri
if ($uri === 'design-3' || str_starts_with($uri, 'design-3/')) {
    $subPath = preg_replace('#^design-3/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../design-3');
    chdir($baseDir);

    if ($subPath === '' || $subPath === 'index.php') {
        require $baseDir . '/index.php';
        exit;
    }

    $target = realpath($baseDir . '/' . $subPath);
    if ($target && str_starts_with($target, $baseDir) && file_exists($target) && !is_dir($target)) {
        require $target;
    } else {
        require $baseDir . '/index.php';
    }
    exit;
}

// Varsayılan / ana dizin
$baseDir = realpath(__DIR__ . '/..');
chdir($baseDir);
require $baseDir . '/index.php';