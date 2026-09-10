<?php
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = trim($uri, '/');

// --- DESIGN-4 ---
if ($uri === 'design-4' || str_starts_with($uri, 'design-4/')) {
    $subPath = preg_replace('#^design-4/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../design-4');
    chdir($baseDir);

    // design-4'ün içindeki router veya sayfaların yolu tanıması için:
    $_SERVER['REQUEST_URI'] = '/' . ltrim($subPath, '/');
    $_SERVER['SCRIPT_NAME'] = '/index.php';

    // Eğer doğrudan fiziksel php dosyası çağrıldıysa
    $directFile = $baseDir . '/' . $subPath;
    if ($subPath !== '' && file_exists($directFile) && !is_dir($directFile)) {
        require $directFile;
        exit;
    }

    require $baseDir . '/index.php';
    exit;
}

// --- DESIGN-3 ---
if ($uri === 'design-3' || str_starts_with($uri, 'design-3/')) {
    $subPath = preg_replace('#^design-3/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../design-3');
    chdir($baseDir);
    $_SERVER['REQUEST_URI'] = '/' . ltrim($subPath, '/');
    require $baseDir . '/index.php';
    exit;
}

// --- DESIGN-2 / KÖK DİZİN ---
$baseDir = realpath(__DIR__ . '/..');
chdir($baseDir);
require $baseDir . '/index.php';