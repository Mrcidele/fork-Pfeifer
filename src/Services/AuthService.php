<?php

namespace App\Services;

use App\Repository\UsuarioRepository;

final class AuthService
{
    private UsuarioRepository $repository;

    public function __construct()
    {
        $this->repository = new UsuarioRepository();
    }

//depois que ele faz o check ele redireciona para a lista de viações
    public static function redirectIfAuthenticated(): void
    {
        if (self::check()) {
            header('Location: /viacoes');
            exit;
        }
    }

//aqui é a parte de validação de login
    public function login(string $email, string $senha): void
    {
        if (empty($email) || empty($senha)) {
            throw new \Exception('Preencha todos os campos.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('E-mail inválido.');
        }

        $usuario = $this->repository->findByEmail($email);

        if (!$usuario) {
            throw new \Exception('Usuário não encontrado ou inativo.');
        }

        if (!password_verify($senha, $usuario['senha'])) {
            throw new \Exception('Senha incorreta.');
        }

        if ($usuario['tipo'] !== 'usuario') {
            throw new \Exception('Acesso restrito a administradores.');
        }

        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
    }
//aqui ele desloga
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

//faz o check de acordo com o id do login
    public static function check(): bool
    {
        return isset($_SESSION['usuario_id']);
    }

//aqui ele só permite logar de acordo com o tipo de usuario
    public static function admin(): bool
    {
        return self::check() && $_SESSION['usuario_tipo'] === 'usuario';
    }
}