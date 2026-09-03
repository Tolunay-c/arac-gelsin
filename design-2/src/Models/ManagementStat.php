<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** The four dark stat tiles on "Yönetim Paneli" (Aktif Yolculuklar, Aylık Kullanım, …). */
final class ManagementStat extends Model
{
    protected static string $table = 'management_stats';
    protected static array $fillable = ['stat_title', 'stat_subtitle', 'sort_order', 'is_active'];
}
