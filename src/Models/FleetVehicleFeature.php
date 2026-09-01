<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/** A single "Kullanım Odağı" bullet belonging to a fleet vehicle. */
final class FleetVehicleFeature extends Model
{
    protected static string $table = 'fleet_vehicle_features';
    protected static array $fillable = ['fleet_vehicle_id', 'feature_text', 'sort_order'];

    public static function byVehicle(int $vehicleId): array
    {
        $statement = Database::connection()->prepare(
            'SELECT * FROM ' . self::$table . ' WHERE fleet_vehicle_id = :id ORDER BY sort_order ASC, id ASC'
        );
        $statement->execute(['id' => $vehicleId]);

        return $statement->fetchAll();
    }

    public static function replaceForVehicle(int $vehicleId, array $featureTexts): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        $pdo->prepare('DELETE FROM ' . self::$table . ' WHERE fleet_vehicle_id = :id')
            ->execute(['id' => $vehicleId]);

        $insert = $pdo->prepare(
            'INSERT INTO ' . self::$table . ' (fleet_vehicle_id, feature_text, sort_order) VALUES (:vehicle_id, :text, :position)'
        );

        $position = 0;
        foreach ($featureTexts as $text) {
            $text = trim((string) $text);
            if ($text === '') {
                continue;
            }
            $insert->execute(['vehicle_id' => $vehicleId, 'text' => $text, 'position' => $position]);
            $position++;
        }

        $pdo->commit();
    }
}
