<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** A row of the "Rekabet Perspektifi" comparison table. */
final class ComparisonCriterion extends Model
{
    protected static string $table = 'comparison_criteria';
    protected static array $fillable = [
        'criterion_name', 'traditional_service_value', 'taxi_app_value', 'aracim_gelsin_value', 'sort_order', 'is_active',
    ];
}
