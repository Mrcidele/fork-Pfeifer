<?php

namespace App\Services;

use App\Repository\ViacaoRepository;
use App\Repository\ViacaoHistoricoRepository;
use App\Validators\ViacaoValidator;

final class ViacaoService
{
    private ViacaoRepository $repo;
    private ViacaoHistoricoRepository $historicoRepo;
    private UploadService $upload;

    //arquivos de necessários para validar as regras de negócio
    public function __construct()
    {
        $pdo = getPdo();
        $this->repo          = new ViacaoRepository($pdo);
        $this->historicoRepo = new ViacaoHistoricoRepository($pdo);
        $this->upload        = new UploadService();
    }

    public function all(): array
    {
        return $this->repo->all();
    }

    public function find(int $id): array
    {
        return $this->repo->find($id);
    }
//add na tabela
    public function create(array $data, ?array $file = null): void
    {
        if ($file) {
            $logo = $this->upload->upload($file);
            if ($logo) {
                $data['logo'] = $logo;
            }
        }

        ViacaoValidator::validate($data);

        $id = $this->repo->create($data);

        $alteracao = json_encode([
            'antes'  => null,
            'depois' => [
                'nome'   => $data['nome'],
                'url'    => $data['url'],
                'cidade' => $data['cidade'],
                'status' => $data['status'],
                'logo'   => $data['logo'] ?? null,
            ],
        ], JSON_UNESCAPED_UNICODE);

        $this->historicoRepo->create(
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'criado'
        );
    }
//edita as inf
    public function update(int $id, array $data, ?array $file = null): void
    {
        $viacaoAtual = $this->repo->find($id);

        if (!$viacaoAtual) {
            throw new \Exception('Viação não encontrada');
        }

        if ($file) {
            $logo = $this->upload->upload($file);
            if ($logo) {
                $data['logo'] = $logo;
            }
        }

        $data['logo'] = $data['logo'] ?? $viacaoAtual['logo'];

        ViacaoValidator::validate($data);

        $antes = [
            'nome'   => $viacaoAtual['nome'],
            'url'    => $viacaoAtual['url'],
            'cidade' => $viacaoAtual['cidade'],
            'status' => $viacaoAtual['status'],
            'logo'   => $viacaoAtual['logo'],
        ];

        $depois = [
            'nome'   => $data['nome'],
            'url'    => $data['url'],
            'cidade' => $data['cidade'],
            'status' => $data['status'],
            'logo'   => $data['logo'],
        ];

        $alteracao = json_encode([
            'antes'  => $antes,
            'depois' => $depois,
        ], JSON_UNESCAPED_UNICODE);

        $this->repo->update($id, $data);

        $this->historicoRepo->create(
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'editado'
        );
    }
//delete valida
    public function delete(int $id): void
    {
        $viacao = $this->repo->find($id);

        if (!$viacao) {
            throw new \Exception('Viação não encontrada');
        }

        $alteracao = json_encode([
            'antes'  => [
                'nome'   => $viacao['nome'],
                'url'    => $viacao['url'],
                'cidade' => $viacao['cidade'],
                'status' => $viacao['status'],
                'logo'   => $viacao['logo'],
            ],
            'depois' => null,
        ], JSON_UNESCAPED_UNICODE);

        $this->historicoRepo->create(
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'excluido'
        );

        $this->repo->delete($id);
    }

//acessa o metodo no repository para verificar
    public function historicoAll(): array
    {
        return $this->historicoRepo->all();
    }

//acessa o filtro para verificar
    public function filter(string $nome, string $cidade, string $status): array
    {
        return $this->repo->filter($nome, $cidade, $status);
    }

//acessa o filtro de historico para verificar
    public function filterHistorico(string $acao, string $usuario, string $data): array
    {
        return $this->historicoRepo->filter($acao, $usuario, $data);
    }
}