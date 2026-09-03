<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/** Corporate "teklif al" form submissions captured from the public site. */
final class LeadRequest extends Model
{
    protected static string $table = 'lead_requests';
    protected static array $fillable = [
        'company_name', 'contact_name', 'phone', 'email', 'message', 'source_page', 'status',
    ];
    protected static string $defaultOrder = 'created_at DESC, id DESC';

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    public static function updateStatus(int $id, string $status): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE ' . self::$table . ' SET status = :status WHERE id = :id'
        );

        return $statement->execute(['status' => $status, 'id' => $id]);
    }

    public static function countByStatus(string $status): int
    {
        $statement = Database::connection()->prepare(
            'SELECT COUNT(*) FROM ' . self::$table . ' WHERE status = :status'
        );
        $statement->execute(['status' => $status]);

        return (int) $statement->fetchColumn();
    }
}
