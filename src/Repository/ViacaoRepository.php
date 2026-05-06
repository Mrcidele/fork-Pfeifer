<?php

namespace App\Repository;

use PDO;

final class ViacaoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM viacoes ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO viacoes (nome, url, cidade, status, logo)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['url'],
            $data['cidade'],
            $data['status'],
            $data['logo'] ?? null
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE viacoes SET
                nome = ?,
                url = ?,
                cidade = ?,
                status = ?,
                logo = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['nome'],
            $data['url'],
            $data['cidade'],
            $data['status'],
            $data['logo'],
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);
    }
}