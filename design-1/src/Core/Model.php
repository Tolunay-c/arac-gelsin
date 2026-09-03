<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Minimal active-record-style base model shared by every domain entity.
 *
 * Concrete models only need to declare $table, $fillable and (optionally)
 * $defaultOrder — all CRUD/reorder/toggle behaviour lives here so entity
 * classes stay small and every query in the application goes through one
 * audited, prepared-statement code path.
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
        $sql = 'SELECT * FROM ' . static::$table;

        if ($onlyActive) {
            $sql .= ' WHERE is_active = 1';
        }

        $sql .= ' ORDER BY ' . static::$defaultOrder;

        $statement = Database::connection()->query($sql);

        return $statement->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT * FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);

        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    public static function findBy(string $column, $value): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT * FROM ' . static::$table . ' WHERE ' . static::sanitizeIdentifier($column) . ' = :value LIMIT 1'
        );
        $statement->execute(['value' => $value]);

        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    public static function count(bool $onlyActive = false): int
    {
        $sql = 'SELECT COUNT(*) FROM ' . static::$table;

        if ($onlyActive) {
            $sql .= ' WHERE is_active = 1';
        }

        return (int) Database::connection()->query($sql)->fetchColumn();
    }

    public static function create(array $data): int
    {
        $data = static::filterFillable($data);

        $columns = array_keys($data);
        $placeholders = array_map(static fn (string $column) => ':' . $column, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::$table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $statement = Database::connection()->prepare($sql);
        $statement->execute($data);

        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $data = static::filterFillable($data);

        if ($data === []) {
            return false;
        }

        $assignments = array_map(static fn (string $column) => $column . ' = :' . $column, array_keys($data));

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :primary_key',
            static::$table,
            implode(', ', $assignments),
            static::$primaryKey
        );

        $data['primary_key'] = $id;

        $statement = Database::connection()->prepare($sql);

        return $statement->execute($data);
    }

    public static function delete(int $id): bool
    {
        $statement = Database::connection()->prepare(
            'DELETE FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id'
        );

        return $statement->execute(['id' => $id]);
    }

    public static function toggleActive(int $id): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE ' . static::$table . ' SET is_active = 1 - is_active WHERE ' . static::$primaryKey . ' = :id'
        );

        return $statement->execute(['id' => $id]);
    }

    /**
     * Persist a new sort order for a set of rows in one go.
     *
     * @param int[] $orderedIds Row ids in their desired display order.
     */
    public static function reorder(array $orderedIds): void
    {
        $pdo = Database::connection();
        $statement = $pdo->prepare(
            'UPDATE ' . static::$table . ' SET sort_order = :position WHERE ' . static::$primaryKey . ' = :id'
        );

        $pdo->beginTransaction();
        foreach (array_values($orderedIds) as $position => $id) {
            $statement->execute(['position' => $position, 'id' => (int) $id]);
        }
        $pdo->commit();
    }

    protected static function filterFillable(array $data): array
    {
        return array_intersect_key($data, array_flip(static::$fillable));
    }

    private static function sanitizeIdentifier(string $column): string
    {
        // Defence in depth: column names are developer-supplied, never user
        // input, but we still restrict to a safe identifier character set.
        return preg_replace('/[^a-zA-Z0-9_]/', '', $column) ?? '';
    }
}
