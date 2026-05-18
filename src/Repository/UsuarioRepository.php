<?php

namespace App\Repository;

final class UsuarioRepository
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = getPdo();
    }

//procura no banco o email do usuario
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM usuarios WHERE email = :email AND status = 0 LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }
}