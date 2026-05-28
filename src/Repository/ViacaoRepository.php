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
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE viacoes SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function restore(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE viacoes SET status = 0 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function paginate(array $filtros, int $limit, int $offset): array {
        $where = [];
        $params = [];

        // Filtro padrão de soft delete (exibe apenas ativos a menos que seja pedido os deletados)
        $status = $filtros['status'] ?? '0';
        if ($status !== 'todos') {
            $where[] = "status = :status";
            $params['status'] = $status;
        }

        if (!empty($filtros['nome'])) {
            $where[] = "nome LIKE :nome";
            $params['nome'] = "%{$filtros['nome']}%";
        }

        $sql = "SELECT * FROM viacoes";
        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Conta o total de registros para a paginação saber quantas páginas criar
    public function countTotal(array $filtros): int {
        $where = [];
        $params = [];

        $status = $filtros['status'] ?? '0';
        if ($status !== 'todos') {
            $where[] = "status = :status";
            $params['status'] = $status;
        }

        if (!empty($filtros['nome'])) {
            $where[] = "nome LIKE :nome";
            $params['nome'] = "%{$filtros['nome']}%";
        }

        $sql = "SELECT COUNT(*) FROM viacoes";
        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}