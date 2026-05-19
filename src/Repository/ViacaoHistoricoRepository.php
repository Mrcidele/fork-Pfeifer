<?php

namespace App\Repository;

use PDO;

final class ViacaoHistoricoRepository
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
//parte de filtro
    public function filter(string $acao = '', string $usuario = '', string $data = ''): array
    {
        $where = [];
        $params = [];

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
        FROM historico_viacoes h
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

//pega de acordo com o id do usuario as alterações
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