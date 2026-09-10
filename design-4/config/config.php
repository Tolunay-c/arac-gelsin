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
// Veri kaynağı — DEMO (mock) MOD
// ---------------------------------------------------------------------
// Bu sürüm MySQL'e bağlanmaz. Tüm içerik database/mock_data.php içindeki
// PHP dizilerinden okunur (bkz. App\Core\MockDatabase), böylece proje
// Vercel gibi veritabanı sunucusu olmayan ortamlarda da sorunsuz çalışır.
//
// Gerçek veritabanına dönmek istendiğinde: database/schema.sql +
// database/seed.sql dosyaları olduğu gibi duruyor; App\Core\Model ve
// App\Core\MockDatabase yerine PDO tabanlı eski katman geri konabilir.
define('DEMO_MODE', true);

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
