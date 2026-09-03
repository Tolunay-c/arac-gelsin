<?php

declare(strict_types=1);

/**
 * Single entry point every front-controller (public/index.php, admin/*.php)
 * requires first. Wires up configuration, autoloading, session and helpers.
 */

require_once __DIR__ . '/config.php';

// PSR-4-style autoloader for the App\ namespace -> /src, no Composer needed.
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = BASE_PATH . '/src/' . str_replace('\\', '/', $relative) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

require_once __DIR__ . '/../src/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => ADMIN_SESSION_LIFETIME,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
