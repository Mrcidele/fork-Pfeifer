<?php

namespace App\Repository;

use PDO;

final class HistoricoRepository
{
    //banco
    private PDO $pdo;

    //conecta com banco
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //prepara query para depois executar
    public function create(
        string $tabela,
        int $registroId,
        int $usuarioId,
        string $alteracao,
        string $acao
    ): void {

        $stmt = $this->pdo->prepare("
            INSERT INTO historicos
            (
                tabela,
                registro_id,
                usuario_id,
                alteracao,
                acao
            )
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $tabela,
            $registroId,
            $usuarioId,
            $alteracao,
            $acao
        ]);
    }

    //parte de filtro
    public function filter(string $tabela = '', string $acao = '', string $usuario = '', string $data = ''): array
    {
        $where = [];
        $params = [];

        if ($tabela !== '') {
            $where[] = "h.tabela = ?";
            $params[] = $tabela;
        }

        if ($acao !== '') {
            $where[] = "h.acao = ?";
            $params[] = $acao;
        }

        if ($usuario !== '') {
            $where[] = "u.nome LIKE ?";
            $params[] = "%{$usuario}%";
        }

        if ($data !== '') {
            $where[] = "DATE(h.data_acao) = ?";
            $params[] = $data;
        }

        $sql = "
        SELECT h.*, u.nome AS usuario_nome
        FROM historicos h
        LEFT JOIN usuarios u ON u.id = h.usuario_id
        ";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY h.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //pega as alterações gerais
    public function all(string $tabela = ''): array
    {
        $sql = "
        SELECT
            h.*,
            u.nome AS usuario_nome
        FROM historicos h
        LEFT JOIN usuarios u
            ON u.id = h.usuario_id
        ";

        $params = [];
        if ($tabela !== '') {
            $sql .= " WHERE h.tabela = ?";
            $params[] = $tabela;
        }

        $sql .= " ORDER BY h.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para a funcionalidade de "Visualizar um único registro"
    public function findByRegistro(string $tabela, int $registroId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT h.*, u.nome AS usuario_nome
            FROM historicos h
            LEFT JOIN usuarios u ON u.id = h.usuario_id
            WHERE h.tabela = ? AND h.registro_id = ?
            ORDER BY h.id DESC
        ");

        $stmt->execute([$tabela, $registroId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function paginate(array $filtros, int $limit, int $offset): array
    {
        $where = [];
        $params = [];

        if (!empty($filtros['tabela'])) {
            $where[] = "h.tabela = :tabela";
            $params['tabela'] = $filtros['tabela'];
        }
        if (!empty($filtros['acao'])) {
            $where[] = "h.acao = :acao";
            $params['acao'] = $filtros['acao'];
        }
        if (!empty($filtros['usuario'])) {
            $where[] = "u.nome LIKE :usuario";
            $params['usuario'] = "%{$filtros['usuario']}%";
        }
        if (!empty($filtros['data'])) {
            $where[] = "DATE(h.data_acao) = :data";
            $params['data'] = $filtros['data'];
        }

        $sql = "
            SELECT h.*, u.nome AS usuario_nome
            FROM historicos h
            LEFT JOIN usuarios u ON u.id = h.usuario_id
        ";

        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY h.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para contar o total de registros
    public function countTotal(array $filtros): int
    {
        $where = [];
        $params = [];

        if (!empty($filtros['tabela'])) {
            $where[] = "h.tabela = :tabela";
            $params['tabela'] = $filtros['tabela'];
        }
        if (!empty($filtros['acao'])) {
            $where[] = "h.acao = :acao";
            $params['acao'] = $filtros['acao'];
        }
        if (!empty($filtros['usuario'])) {
            $where[] = "u.nome LIKE :usuario";
            $params['usuario'] = "%{$filtros['usuario']}%";
        }
        if (!empty($filtros['data'])) {
            $where[] = "DATE(h.data_acao) = :data";
            $params['data'] = $filtros['data'];
        }

        $sql = "
            SELECT COUNT(*)
            FROM historicos h
            LEFT JOIN usuarios u ON u.id = h.usuario_id
        ";

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