<?php

declare(strict_types=1);

/**
 * Public site front controller. Every request that isn't a real file
 * (assets, uploads, admin/*.php — see /.htaccess) is routed through here.
 *
 * PHP's built-in dev server (`php -S host:port index.php`) invokes this
 * script for *every* request, not only missing ones — unlike Apache with
 * the .htaccess rewrite. Mirror that passthrough here so `php -S` behaves
 * the same as production: real files are served/executed as-is.
 */
if (PHP_SAPI === 'cli-server') {
    $requestPath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $resolved = realpath(__DIR__ . $requestPath);
    if ($resolved !== false && str_starts_with($resolved, __DIR__ . DIRECTORY_SEPARATOR) && is_file($resolved) && $resolved !== __FILE__) {
        return false;
    }
}

require_once __DIR__ . '/config/bootstrap.php';

/** @var \App\Core\Router $router */
$router = require __DIR__ . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'] ?? '/');
