<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/** Admin panel operator account. */
final class Admin extends Model
{
    protected static string $table = 'admins';
    protected static array $fillable = ['username', 'email', 'full_name', 'password_hash', 'last_login_at'];

    public static function findByUsername(string $username): ?array
    {
        return self::findBy('username', $username);
    }

    public static function verifyCredentials(string $username, string $password): ?array
    {
        $admin = self::findByUsername($username);

        if ($admin === null || !password_verify($password, $admin['password_hash'])) {
            return null;
        }

        return $admin;
    }

    public static function touchLastLogin(int $id): void
    {
        Database::connection()
            ->prepare('UPDATE ' . self::$table . ' SET last_login_at = NOW() WHERE id = :id')
            ->execute(['id' => $id]);
    }

    public static function updatePassword(int $id, string $plainPassword): bool
    {
        $statement = Database::connection()->prepare(
            'UPDATE ' . self::$table . ' SET password_hash = :hash WHERE id = :id'
        );

        return $statement->execute([
            'hash' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'id' => $id,
        ]);
    }
}
