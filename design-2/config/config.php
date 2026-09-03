<?php
/**
 * Application configuration.
 *
 * Values can be overridden via environment variables (e.g. set on the
 * hosting panel or in a .env-style export before PHP-FPM/Apache starts).
 * Sensible local-development defaults are provided as fallbacks.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------
// Environment
// ---------------------------------------------------------------------
define('APP_ENV', getenv('APP_ENV') ?: 'local');          // local | production
define('APP_DEBUG', APP_ENV !== 'production');
define('APP_NAME', 'Aracım Gelsin');
define('APP_TIMEZONE', 'Europe/Istanbul');

// Base URL of the application (no trailing slash), used to build absolute
// links/assets. Auto-detected when not explicitly set.
$detectedScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$detectedHost   = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('APP_URL', rtrim(getenv('APP_URL') ?: ($detectedScheme . '://' . $detectedHost), '/'));

// ---------------------------------------------------------------------
// Database
// ---------------------------------------------------------------------
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'aracim_gelsin');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// ---------------------------------------------------------------------
// Filesystem paths
// ---------------------------------------------------------------------
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('UPLOAD_URL', APP_URL . '/uploads');

// ---------------------------------------------------------------------
// Security
// ---------------------------------------------------------------------
// Used to key session cookies; change per-deployment for extra isolation.
define('SESSION_NAME', 'aracimgelsin_session');
define('ADMIN_SESSION_LIFETIME', 60 * 60 * 8); // 8 hours

date_default_timezone_set(APP_TIMEZONE);

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
}
