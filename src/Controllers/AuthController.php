<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\AuthService;

final class AuthController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function showLogin(): void
    {
        AuthService::redirectIfAuthenticated();

        View::render('viacoes/login', [
            'title' => 'Login',
            'css'   => 'login',
        ], false);
    }

    //ele vai passar pelo processo de validação de login e enviar para o service
    public function login(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            $this->service->login($email, $senha);

            header('Location: /viacoes');
            exit;

        } catch (\Exception $e) {
            View::render('viacoes/login', [
                'title' => 'Login',
                'css'   => 'login',
                'erro'  => $e->getMessage(),
            ], false);
        }
    }

//ele acessa a função do logout
    public function logout(): void
    {
        $this->service->logout();

        header('Location: /login');
        exit;
    }
}