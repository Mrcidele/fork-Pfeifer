<?php

namespace App\Repository;
use PDO;

final class ViacaoHistoricoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $id, array $dados, string $acao): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO historico_viacoes
            (viacao_id, nome, url, cidade, status, logo, acao)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $id,
            $dados['nome'] ?? '',
            $dados['url'] ?? '',
            $dados['cidade'] ?? '',
            $dados['status'] ?? 'inativo',
            $dados['logo'] ?? '',
            $acao
        ]);
    }

    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM historico_viacoes ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}