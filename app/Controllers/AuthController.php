<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Services\AuthService;

class AuthController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function showLogin(): void
    {
        Auth::start();
        Auth::ensureNoCache();

        if (Auth::check()) {
            header('Location: /dashboard');
            exit;
        }

        $error = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_error']);

        require __DIR__ . '/../../views/auth/login.php';
    }

    public function login(): void
    {
        Auth::start();
        Auth::ensureNoCache();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['flash_error'] = 'Email and password are required.';
            header('Location: /login');
            exit;
        }

        $result = $this->authService->login($email, $password);

        if (!$result['success']) {
            $_SESSION['flash_error'] = $result['message'];
            header('Location: /login');
            exit;
        }

        header('Location: /dashboard');
        exit;
    }

    public function logout(): void
    {
        Auth::start();
        Auth::ensureNoCache();

        $this->authService->logout();

        header('Location: /login');
        exit;
    }
}