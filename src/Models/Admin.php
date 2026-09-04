<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** Admin panel operator account. */
final class Admin extends Model
{
    protected static string $table = 'admins';
    protected static array $fillable = ['username', 'email', 'full_name', 'password_hash', 'last_login_at'];
    protected static string $defaultOrder = 'id ASC';

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
        self::mutate($id, static function (array $row): array {
            $row['last_login_at'] = date('Y-m-d H:i:s');

            return $row;
        });
    }

    public static function updatePassword(int $id, string $plainPassword): bool
    {
        return self::mutate($id, static function (array $row) use ($plainPassword): array {
            $row['password_hash'] = password_hash($plainPassword, PASSWORD_DEFAULT);

            return $row;
        });
    }
}
