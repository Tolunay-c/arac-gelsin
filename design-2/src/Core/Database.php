<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Thin PDO singleton wrapper.
 *
 * Kept intentionally small: the rest of the application talks to the
 * database exclusively through App\Core\Model (prepared statements only),
 * so this class has a single responsibility — hand out one shared,
 * correctly-configured PDO connection.
 */
final class Database
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_PORT,
                DB_NAME,
                DB_CHARSET
            );

            try {
                self::$connection = new PDO(DB_HOST !== '' ? $dsn : $dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
                ]);
            } catch (PDOException $exception) {
                if (APP_DEBUG) {
                    throw new RuntimeException('Database connection failed: ' . $exception->getMessage(), 0, $exception);
                }

                throw new RuntimeException('Database connection failed.');
            }
        }

        return self::$connection;
    }
}
