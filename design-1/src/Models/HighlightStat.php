<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/**
 * Short "stat + label" badges reused across the Hero strip and the
 * "Neden Farklı?" positioning cards — e.g. 30 DK / Elektrikli / İzmir / B2B.
 */
final class HighlightStat extends Model
{
    protected static string $table = 'highlight_stats';
    protected static array $fillable = ['stat_value', 'stat_label', 'stat_description', 'icon', 'sort_order', 'is_active'];
}
