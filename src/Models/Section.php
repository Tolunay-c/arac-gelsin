<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\MockDatabase;
use App\Core\Model;

/**
 * Controls which page/section blocks are rendered, and in what order.
 * `page_key` scopes a row to one routed page (home, about, fleet, …);
 * `section_key` matches a block a page template checks before rendering.
 */
final class Section extends Model
{
    protected static string $table = 'sections';
    protected static array $fillable = ['page_key', 'section_key', 'section_name', 'is_active', 'sort_order'];
    protected static string $defaultOrder = 'page_key ASC, sort_order ASC, id ASC';

    public static function byPage(string $pageKey): array
    {
        $rows = array_filter(
            MockDatabase::table(self::$table),
            static fn (array $row): bool => ($row['page_key'] ?? '') === $pageKey
        );

        return MockDatabase::sort($rows, 'sort_order ASC, id ASC');
    }

    /** @return array<string,bool> section_key => true, for every active block on $pageKey. */
    public static function activeKeysForPage(string $pageKey): array
    {
        $active = [];
        foreach (self::byPage($pageKey) as $section) {
            if ($section['is_active']) {
                $active[$section['section_key']] = true;
            }
        }

        return $active;
    }
}
