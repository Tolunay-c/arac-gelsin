<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** A regional operation node on the "İzmir Geneli Stratejik Konumlanma" map. */
final class HubLocation extends Model
{
    protected static string $table = 'hub_locations';
    protected static array $fillable = [
        'region_label', 'area_name', 'position_top', 'position_left', 'is_center', 'sort_order', 'is_active',
    ];
}
