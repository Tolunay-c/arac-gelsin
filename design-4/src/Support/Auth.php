<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Admin;

/** Session-based authentication guard for the admin panel. */
final class Auth
{
    private const SESSION_KEY = 'admin_id';

    public static function attempt(string $username, string $password): bool
    {
        $admin = Admin::verifyCredentials($username, $password);

        if ($admin === null) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION[self::SESSION_KEY] = $admin['id'];
        Admin::touchLastLogin((int) $admin['id']);

        return true;
    }

    public static function check(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return Admin::find((int) $_SESSION[self::SESSION_KEY]);
    }

    public static function id(): ?int
    {
        return self::check() ? (int) $_SESSION[self::SESSION_KEY] : null;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
        session_regenerate_id(true);
    }

    /** Redirect to the login screen unless an admin session is active. */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect('login.php');
        }
    }
}
