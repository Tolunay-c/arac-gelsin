<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/** A vehicle class in the fleet architecture (TOGG, Ford Explorer, …). */
final class FleetVehicle extends Model
{
    protected static string $table = 'fleet_vehicles';
    protected static array $fillable = [
        'name', 'category', 'tagline', 'description', 'image_path', 'sort_order', 'is_active',
    ];

    /** Fetch a vehicle together with its ordered feature bullet list. */
    public static function findWithFeatures(int $id): ?array
    {
        $vehicle = self::find($id);

        if ($vehicle === null) {
            return null;
        }

        $vehicle['features'] = FleetVehicleFeature::byVehicle($id);

        return $vehicle;
    }

    /** All active vehicles, each with its features attached (for the landing page). */
    public static function allWithFeatures(bool $onlyActive = false): array
    {
        $vehicles = self::all($onlyActive);

        $statement = Database::connection()->prepare(
            'SELECT * FROM fleet_vehicle_features WHERE fleet_vehicle_id = :id ORDER BY sort_order ASC, id ASC'
        );

        foreach ($vehicles as &$vehicle) {
            $statement->execute(['id' => $vehicle['id']]);
            $vehicle['features'] = $statement->fetchAll();
        }
        unset($vehicle);

        return $vehicles;
    }

    public static function delete(int $id): bool
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        $pdo->prepare('DELETE FROM fleet_vehicle_features WHERE fleet_vehicle_id = :id')
            ->execute(['id' => $id]);

        $deleted = $pdo->prepare('DELETE FROM fleet_vehicles WHERE id = :id')->execute(['id' => $id]);

        $pdo->commit();

        return $deleted;
    }
}
