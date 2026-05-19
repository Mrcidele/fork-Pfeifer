<?php

namespace App\Repository;

use PDO;

final class ViacaoRepository
{

    //banco
    private PDO $pdo;

//conecta com o banco
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
//exibe as inf da tabela de viações
    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM viacoes ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
//encontra a viação em especifico
    public function find(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    //prepara a query e executa para inserir a nova viação
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

    public function allAtivas(): array
    {
        return $this->pdo
            ->query("SELECT * FROM viacoes WHERE status = 0 ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

//prepara a query e executa para edita a viação
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
//prepara a query e executa para filtra as viações
    public function filter(string $nome = '', string $cidade = '', string $status = ''): array
    {
        $where = [];
        $params = [];

        if ($nome !== '') {
            $where[] = "nome LIKE ?";
            $params[] = "%{$nome}%";
        }

        if ($cidade !== '') {
            $where[] = "cidade LIKE ?";
            $params[] = "%{$cidade}%";
        }

        if ($status !== '') {
            $where[] = "status = ?";
            $params[] = $status;
        }

        $sql = "SELECT * FROM viacoes";
        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //prepara a query e executa para deleta a viação
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);
    }
}