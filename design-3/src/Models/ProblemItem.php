<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** "Her Ulaşım İhtiyacı Servis Planına Uymaz" numbered problem list. */
final class ProblemItem extends Model
{
    protected static string $table = 'problem_items';
    protected static array $fillable = ['description', 'sort_order', 'is_active'];
}
