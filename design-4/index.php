<?php

declare(strict_types=1);

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

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$cleanUri = preg_replace('#^/design-4#', '', (string) $uri);
if ($cleanUri === '' || $cleanUri === false) {
    $cleanUri = '/';
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $cleanUri);