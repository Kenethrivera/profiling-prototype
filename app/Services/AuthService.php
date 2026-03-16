<?php

namespace App\Services;

use App\Core\Auth;
use App\Core\Env;

class AuthService
{
    public function login(string $email, string $password): array
    {
        $adminEmail = Env::get('APP_ADMIN_EMAIL');
        $adminPassword = Env::get('APP_ADMIN_PASSWORD');

        if ($email !== $adminEmail || $password !== $adminPassword) {
            return [
                'success' => false,
                'message' => 'Invalid email or password.',
            ];
        }

        Auth::login([
            'email' => $email,
            'role' => 'admin',
        ]);

        return [
            'success' => true,
            'message' => 'Login successful.',
        ];
    }

    public function logout(): void
    {
        Auth::logout();
    }
}