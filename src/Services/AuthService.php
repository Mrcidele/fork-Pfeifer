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

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['usuario_id']);
    }

    public static function admin(): bool
    {
        return self::check() && $_SESSION['usuario_tipo'] === 'usuario';
    }
}