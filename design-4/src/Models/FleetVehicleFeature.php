<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\MockDatabase;
use App\Core\Model;

/** A single "Kullanım Odağı" bullet belonging to a fleet vehicle. */
final class FleetVehicleFeature extends Model
{
    protected static string $table = 'fleet_vehicle_features';
    protected static array $fillable = ['fleet_vehicle_id', 'feature_text', 'sort_order'];

    public static function byVehicle(int $vehicleId): array
    {
        $rows = array_filter(
            MockDatabase::table(self::$table),
            static fn (array $row): bool => (int) $row['fleet_vehicle_id'] === $vehicleId
        );

        return MockDatabase::sort($rows, 'sort_order ASC, id ASC');
    }

    public static function replaceForVehicle(int $vehicleId, array $featureTexts): void
    {
        $rows = self::withoutVehicle($vehicleId);
        $nextId = MockDatabase::nextId(self::$table);

        $position = 0;
        foreach ($featureTexts as $text) {
            $text = trim((string) $text);
            if ($text === '') {
                continue;
            }

            $rows[] = [
                'id' => $nextId++,
                'fleet_vehicle_id' => $vehicleId,
                'feature_text' => $text,
                'sort_order' => $position,
            ];
            $position++;
        }

        MockDatabase::put(self::$table, $rows);
    }

    /** Remove every feature belonging to a vehicle (used when the vehicle is deleted). */
    public static function deleteForVehicle(int $vehicleId): void
    {
        MockDatabase::put(self::$table, self::withoutVehicle($vehicleId));
    }

    private static function withoutVehicle(int $vehicleId): array
    {
        return array_values(array_filter(
            MockDatabase::table(self::$table),
            static fn (array $row): bool => (int) $row['fleet_vehicle_id'] !== $vehicleId
        ));
    }
}
