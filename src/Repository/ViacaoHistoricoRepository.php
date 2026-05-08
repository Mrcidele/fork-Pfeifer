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

    public function create(
        int $viacaoId,
        int $usuarioId,
        string $alteracao,
        string $acao
    ): void {

        $stmt = $this->pdo->prepare("
            INSERT INTO historico_viacoes
            (
                viacao_id,
                usuario_id,
                alteracao,
                acao
            )
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $viacaoId,
            $usuarioId,
            $alteracao,
            $acao
        ]);
    }

    public function all(): array
    {
        $sql = "
        SELECT
            h.*,
            u.nome AS usuario_nome
        FROM historico_viacoes h

        LEFT JOIN usuarios u
            ON u.id = h.usuario_id

        ORDER BY h.id DESC
    ";

        return $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}