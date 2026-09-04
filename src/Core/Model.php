<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Minimal active-record-style base model shared by every domain entity.
 *
 * DEMO SÜRÜMÜ: Sorgular MySQL yerine App\Core\MockDatabase üzerindeki
 * PHP dizilerine gider. Model sınıflarının arayüzü ($table, $fillable,
 * $defaultOrder ve tüm public metotlar) aynı kaldı; sadece altındaki
 * veri kaynağı değişti.
 */
abstract class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    /** @var string[] Columns that may be mass-assigned via create()/update(). */
    protected static array $fillable = [];

    protected static string $defaultOrder = 'sort_order ASC, id ASC';

    public static function all(bool $onlyActive = false): array
    {
        $rows = MockDatabase::table(static::$table);

        if ($onlyActive) {
            $rows = array_filter($rows, static fn (array $row): bool => (int) ($row['is_active'] ?? 1) === 1);
        }

        return MockDatabase::sort($rows, static::$defaultOrder);
    }

    public static function find(int $id): ?array
    {
        return static::findBy(static::$primaryKey, $id);
    }

    public static function findBy(string $column, $value): ?array
    {
        $column = static::sanitizeIdentifier($column);

        foreach (MockDatabase::table(static::$table) as $row) {
            if (array_key_exists($column, $row) && (string) $row[$column] === (string) $value) {
                return $row;
            }
        }

        return null;
    }

    public static function count(bool $onlyActive = false): int
    {
        return count(static::all($onlyActive));
    }

    public static function create(array $data): int
    {
        $data = static::filterFillable($data);

        $id = MockDatabase::nextId(static::$table);
        $now = date('Y-m-d H:i:s');

        $row = [static::$primaryKey => $id];

        foreach (MockDatabase::columns(static::$table) as $column) {
            if ($column === static::$primaryKey) {
                continue;
            }

            $row[$column] = match (true) {
                array_key_exists($column, $data) => $data[$column],
                $column === 'created_at', $column === 'updated_at' => $now,
                $column === 'is_active' => 1,
                $column === 'sort_order' => $id,
                default => null,
            };
        }

        // mock_data.php'de hiç satırı olmayan tablolar için: gelen alanları aynen al.
        foreach ($data as $column => $value) {
            if (!array_key_exists($column, $row)) {
                $row[$column] = $value;
            }
        }

        $rows = MockDatabase::table(static::$table);
        $rows[] = $row;
        MockDatabase::put(static::$table, $rows);

        return $id;
    }

    public static function update(int $id, array $data): bool
    {
        $data = static::filterFillable($data);

        if ($data === []) {
            return false;
        }

        return static::mutate($id, static function (array $row) use ($data): array {
            foreach ($data as $column => $value) {
                $row[$column] = $value;
            }

            if (array_key_exists('updated_at', $row)) {
                $row['updated_at'] = date('Y-m-d H:i:s');
            }

            return $row;
        });
    }

    public static function delete(int $id): bool
    {
        $rows = MockDatabase::table(static::$table);
        $remaining = array_filter(
            $rows,
            static fn (array $row): bool => (int) ($row[static::$primaryKey] ?? 0) !== $id
        );

        MockDatabase::put(static::$table, $remaining);

        return count($remaining) !== count($rows);
    }

    public static function toggleActive(int $id): bool
    {
        return static::mutate($id, static function (array $row): array {
            $row['is_active'] = (int) ($row['is_active'] ?? 1) === 1 ? 0 : 1;

            return $row;
        });
    }

    /**
     * Persist a new sort order for a set of rows in one go.
     *
     * @param int[] $orderedIds Row ids in their desired display order.
     */
    public static function reorder(array $orderedIds): void
    {
        $positions = array_flip(array_map('intval', array_values($orderedIds)));

        $rows = MockDatabase::table(static::$table);
        foreach ($rows as &$row) {
            $id = (int) ($row[static::$primaryKey] ?? 0);
            if (isset($positions[$id])) {
                $row['sort_order'] = $positions[$id];
            }
        }
        unset($row);

        MockDatabase::put(static::$table, $rows);
    }

    /** Tek bir satırı callback ile günceller. */
    protected static function mutate(int $id, callable $callback): bool
    {
        $rows = MockDatabase::table(static::$table);
        $changed = false;

        foreach ($rows as $index => $row) {
            if ((int) ($row[static::$primaryKey] ?? 0) === $id) {
                $rows[$index] = $callback($row);
                $changed = true;
                break;
            }
        }

        if ($changed) {
            MockDatabase::put(static::$table, $rows);
        }

        return $changed;
    }

    protected static function filterFillable(array $data): array
    {
        return array_intersect_key($data, array_flip(static::$fillable));
    }

    protected static function sanitizeIdentifier(string $column): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $column) ?? '';
    }
}
