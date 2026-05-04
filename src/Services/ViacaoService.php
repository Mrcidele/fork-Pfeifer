<?php

namespace App\Services;
use PDO;

final class ViacaoService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getPdo();
    }

    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM viacoes ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {

        $sql = "INSERT INTO viacoes
                (nome, url, cidade, status, logo)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $data['nome'],
            $data['url'],
            $data['cidade'],
            $data['status'],
            $data['logo'] ?? null
        ]);


        $id = (int) $this->pdo->lastInsertId();

        $this->historico($id, $data, 'criado');
    }

    public function delete(int $id): void
    {
        $viacao = $this->find($id);

        $this->historico($id, $viacao, 'excluido');

        $stmt = $this->pdo->prepare(
            "DELETE FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);
    }

    public function find(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM viacoes WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function update(int $id, array $data): void
    {
        $viacaoAtual = $this->find($id);

        $logo = $data['logo'] ?? $viacaoAtual['logo'];

        $sql = "UPDATE viacoes SET
                nome = ?,
                url = ?,
                cidade = ?,
                status = ?,
                logo = ?
            WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $data['nome'],
            $data['url'],
            $data['cidade'],
            $data['status'],
            $logo,
            $id
        ]);

        $dadosAtualizados = $this->find($id);

        $this->historico($id, $dadosAtualizados, 'editado');
    }


    private function historico(
        int $id,
        array $dados,
        string $acao
    ): void {
        $sql = "INSERT INTO historico_viacoes
                (
                    viacao_id,
                    nome,
                    url,
                    cidade,
                    status,
                    logo,
                    acao
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

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
}