<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** "Kullanım Senaryoları" cards (Mesai Sonrası Ulaşım, Yönetici Transferleri, …). */
final class UseCase extends Model
{
    protected static string $table = 'use_cases';
    protected static array $fillable = ['icon', 'title', 'description', 'sort_order', 'is_active'];
}
