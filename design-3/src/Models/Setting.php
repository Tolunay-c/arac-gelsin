<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

/**
 * Key/value site settings (hero copy, store links, contact info, SEO meta…).
 *
 * Modelled as EAV-style rows on purpose: it lets the admin panel expose an
 * arbitrary, evolving list of editable text fields without a schema change
 * for every new copy field a marketing request adds.
 */
final class Setting
{
    private static string $table = 'site_settings';

    /** @var array<string,string>|null In-process cache for the request lifecycle. */
    private static ?array $cache = null;

    public static function all(): array
    {
        if (self::$cache === null) {
            $rows = Database::connection()
                ->query('SELECT setting_key, setting_value FROM ' . self::$table)
                ->fetchAll();

            self::$cache = [];
            foreach ($rows as $row) {
                self::$cache[$row['setting_key']] = $row['setting_value'];
            }
        }

        return self::$cache;
    }

    public static function get(string $key, string $default = ''): string
    {
        $all = self::all();

        return $all[$key] ?? $default;
    }

    public static function set(string $key, string $value): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO ' . self::$table . ' (setting_key, setting_value)
             VALUES (:key, :value)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );
        $statement->execute(['key' => $key, 'value' => $value]);

        self::$cache = null;
    }

    /**
     * Persist many settings at once (typical admin form submission).
     *
     * @param array<string,string> $values
     */
    public static function setMany(array $values): void
    {
        $pdo = Database::connection();
        $statement = $pdo->prepare(
            'INSERT INTO ' . self::$table . ' (setting_key, setting_value)
             VALUES (:key, :value)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );

        $pdo->beginTransaction();
        foreach ($values as $key => $value) {
            $statement->execute(['key' => $key, 'value' => (string) $value]);
        }
        $pdo->commit();

        self::$cache = null;
    }
}
