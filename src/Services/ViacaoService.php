<?php

namespace App\Services;

use App\Repository\ViacaoRepository;
use App\Repository\ViacaoHistoricoRepository;
use App\Validators\ViacaoValidator;

final class ViacaoService
{
    private ViacaoRepository $repo;
    private ViacaoHistoricoRepository $historicoRepo;

    public function __construct()
    {
        $pdo = getPdo();

        $this->repo = new ViacaoRepository($pdo);
        $this->historicoRepo = new ViacaoHistoricoRepository($pdo);
    }

    public function all(): array
    {
        return $this->repo->all();
    }

    public function find(int $id): array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): void
    {
        ViacaoValidator::validate($data);

        $id = $this->repo->create($data);

        $this->historicoRepo->create($id, $data, 'criado');
    }

    public function update(int $id, array $data): void
    {
        ViacaoValidator::validate($data);

        $viacaoAtual = $this->repo->find($id);

        if (!$viacaoAtual) {
            throw new \Exception('Viação não encontrada');
        }

        $data['logo'] = $data['logo'] ?? $viacaoAtual['logo'];

        $this->repo->update($id, $data);

        $dadosAtualizados = $this->repo->find($id);

        $this->historicoRepo->create($id, $dadosAtualizados, 'editado');
    }

    public function delete(int $id): void
    {
        $viacao = $this->repo->find($id);

        if (!$viacao) {
            throw new \Exception('Viação não encontrada');
        }

        $this->historicoRepo->create($id, $viacao, 'excluido');

        $this->repo->delete($id);
    }

    public function historicoAll(): array
    {
        return $this->historicoRepo->all();
    }
}