<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** "Hub Modeli" bullet list (Stratejik bekleme noktaları, Bölgesel talep dengesi, …). */
final class HubFeature extends Model
{
    protected static string $table = 'hub_features';
    protected static array $fillable = ['feature_text', 'sort_order', 'is_active'];
}
