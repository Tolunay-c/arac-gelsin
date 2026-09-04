<?php

declare(strict_types=1);

/**
 * Vercel giriş noktası (tek serverless fonksiyon).
 *
 * Vercel'de Apache/.htaccess yoktur ve her .php dosyasını ayrı bir
 * fonksiyon olarak derlemek fonksiyon limitine takılır. Bu yüzden tüm
 * istekler bu tek dosyaya gelir; burada .htaccess'teki kurallar birebir
 * PHP tarafında uygulanır:
 *
 *   1. /design-2, /design-3 önekleri ilgili tasarım klasörüne yönlenir.
 *   2. Gerçek bir .php dosyası varsa (admin/*.php gibi) doğrudan çalışır.
 *   3. /admin/settings gibi uzantısız admin yolları .php'ye eşlenir.
 *   4. Kalan her şey ilgili tasarımın index.php front controller'ına gider.
 */

$projectRoot = dirname(__DIR__);

$requestPath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestPath = '/' . ltrim(rawurldecode($requestPath), '/');

// 1. Hangi tasarım? (kök, design-2, design-3)
$appRoot = $projectRoot;
$basePath = '';

foreach (['design-2', 'design-3'] as $design) {
    if ($requestPath === '/' . $design || str_starts_with($requestPath, '/' . $design . '/')) {
        $appRoot = $projectRoot . '/' . $design;
        $basePath = '/' . $design;
        $requestPath = substr($requestPath, strlen($basePath)) ?: '/';
        break;
    }
}

// Alt klasör tasarımlarında bağlantıların/asset'lerin doğru üretilmesi için.
if ($basePath !== '') {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    putenv('APP_URL=' . $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $basePath);
}

// Front controller'ın gördüğü yolu tasarım köküne göre normalize et.
$_SERVER['REQUEST_URI'] = $requestPath . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== ''
    ? '?' . $_SERVER['QUERY_STRING']
    : '');

/** İstenen yolun tasarım kökü içinde kaldığından emin ol (path traversal koruması). */
$resolve = static function (string $relative) use ($appRoot): ?string {
    $candidate = realpath($appRoot . '/' . ltrim($relative, '/'));

    if ($candidate === false || !is_file($candidate)) {
        return null;
    }

    return str_starts_with($candidate, $appRoot . DIRECTORY_SEPARATOR) ? $candidate : null;
};

// 2. Gerçek bir .php dosyası (admin/login.php, admin/fleet-form.php, …)
$script = null;
if (str_ends_with($requestPath, '.php')) {
    $script = $resolve($requestPath);
}

// 3. Uzantısız admin yolları: /admin/settings -> admin/settings.php
if ($script === null && preg_match('#^/admin/([A-Za-z0-9_-]+)/?$#', $requestPath, $matches) === 1) {
    $script = $resolve('/admin/' . $matches[1] . '.php');
}

// /admin ve /admin/ -> admin/index.php
if ($script === null && ($requestPath === '/admin' || $requestPath === '/admin/')) {
    $script = $resolve('/admin/index.php');
}

// 4. Geri kalan her şey public front controller'a.
if ($script === null) {
    $script = $appRoot . '/index.php';
}

chdir(dirname($script));

require $script;
