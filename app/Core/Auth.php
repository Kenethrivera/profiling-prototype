<?php

namespace App\Core;

class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            session_start();
        }
    }

    public static function login(array $userData): void
    {
        self::start();
        session_regenerate_id(true);

        $_SESSION['auth'] = [
            'email' => $userData['email'],
            'role' => $userData['role'] ?? 'admin',
            'logged_in_at' => time(),
        ];
    }

    public static function check(): bool
    {
        self::start();
        return isset($_SESSION['auth']);
    }

    public static function user(): ?array
    {
        self::start();
        return $_SESSION['auth'] ?? null;
    }

    public static function logout(): void
    {
        self::start();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public static function ensureNoCache(): void
    {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    public static function requireLogin(): void
    {
        self::start();
        self::ensureNoCache();

        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function redirectIfAuthenticated(): void
    {
        self::start();
        self::ensureNoCache();

        if (self::check()) {
            header('Location: /dashboard');
            exit;
        }
    }
}