<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\MockDatabase;

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
            self::$cache = [];
            foreach (MockDatabase::table(self::$table) as $row) {
                self::$cache[$row['setting_key']] = (string) ($row['setting_value'] ?? '');
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
        self::setMany([$key => $value]);
    }

    /**
     * Persist many settings at once (typical admin form submission).
     *
     * @param array<string,string> $values
     */
    public static function setMany(array $values): void
    {
        $rows = MockDatabase::table(self::$table);

        $indexByKey = [];
        foreach ($rows as $index => $row) {
            $indexByKey[$row['setting_key']] = $index;
        }

        $nextId = MockDatabase::nextId(self::$table);

        foreach ($values as $key => $value) {
            $value = (string) $value;

            if (isset($indexByKey[$key])) {
                $rows[$indexByKey[$key]]['setting_value'] = $value;
                $rows[$indexByKey[$key]]['updated_at'] = date('Y-m-d H:i:s');
                continue;
            }

            $rows[] = [
                'id' => $nextId++,
                'setting_key' => $key,
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        MockDatabase::put(self::$table, $rows);

        self::$cache = null;
    }
}
