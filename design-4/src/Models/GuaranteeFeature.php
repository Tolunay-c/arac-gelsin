<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** The four "Özikizler Turizm Şirketler Grubu Güvencesi" trust cards. */
final class GuaranteeFeature extends Model
{
    protected static string $table = 'guarantee_features';
    protected static array $fillable = ['icon', 'title', 'description', 'sort_order', 'is_active'];
}
