<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** Bullet list on the "Yönetim Paneli" section (canlı görünürlük, raporlar, …). */
final class ManagementFeature extends Model
{
    protected static string $table = 'management_features';
    protected static array $fillable = ['icon', 'feature_text', 'sort_order', 'is_active'];
}
