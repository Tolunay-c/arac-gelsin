<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\MockDatabase;
use App\Core\Model;

/**
 * Numbered step cards, reused by two sections that share the exact same
 * shape (icon, title, description): "Nasıl Çalışır?" and "Dijital Sistem".
 * `flow_type` distinguishes which section a row belongs to.
 */
final class ProcessStep extends Model
{
    protected static string $table = 'process_steps';
    protected static array $fillable = ['flow_type', 'step_number', 'icon', 'title', 'description', 'sort_order', 'is_active'];

    public const FLOW_HOW_IT_WORKS = 'how_it_works';
    public const FLOW_DIGITAL_SYSTEM = 'digital_system';

    public static function byFlow(string $flowType, bool $onlyActive = false): array
    {
        $rows = array_filter(
            MockDatabase::table(self::$table),
            static function (array $row) use ($flowType, $onlyActive): bool {
                if (($row['flow_type'] ?? '') !== $flowType) {
                    return false;
                }

                return !$onlyActive || (int) ($row['is_active'] ?? 1) === 1;
            }
        );

        return MockDatabase::sort($rows, self::$defaultOrder);
    }
}
