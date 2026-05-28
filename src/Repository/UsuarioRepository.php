<?php

namespace App\Repository;

use PDO;
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

    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM usuarios ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // encontra um usuario em especifico pelo ID
    public function find(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM usuarios WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // prepara a query e executa para inserir o novo usuario
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (nome, email, senha, tipo, status)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['senha'],
            $data['tipo'] ?? 'usuario',
            $data['status'] ?? 0
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    // prepara a query e executa para edita o usuario
    public function update(int $id, array $data): void
    {
        // Neste update padrão, não incluí a senha para evitar sobrescrevê-la acidentalmente
        $stmt = $this->pdo->prepare("
            UPDATE usuarios SET
                nome = ?,
                email = ?,
                tipo = ?,
                status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['tipo'],
            $data['status'],
            $id
        ]);
    }

    // Soft Delete
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE usuarios SET status = 1 WHERE id = ?"
        );

        $stmt->execute([$id]);
    }

    public function restore(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE usuarios SET status = 0 WHERE id = ?"
        );

        $stmt->execute([$id]);
    }

    // Novo método unificado de listagem com Paginação e Filtro
    public function paginate(array $filtros, int $limit, int $offset): array
    {
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


        $sql = "SELECT 
                    id, 
                    nome AS nome, 
                    email AS email, 
                    tipo AS tipo, 
                    status AS status 
                FROM usuarios";

        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Conta o total de registros para a paginação
    public function countTotal(array $filtros): int
    {
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

        $sql = "SELECT COUNT(*) FROM usuarios";

        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }
}