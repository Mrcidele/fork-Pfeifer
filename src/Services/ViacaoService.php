<?php

namespace App\Services;

use App\Repository\ViacaoRepository;
use App\Repository\HistoricoRepository;
use App\Validators\ViacaoValidator;

final class ViacaoService
{
    private ViacaoRepository $repo;
    private HistoricoRepository $historicoRepo;
    private UploadService $upload;
    private CacheService $cache;

    public function __construct()
    {
        $pdo = getPdo();
        $this->repo          = new ViacaoRepository($pdo);
        $this->historicoRepo = new HistoricoRepository($pdo);
        $this->upload        = new UploadService();
        $this->cache         = new CacheService();
    }

    public function all(): array
    {
        return $this->repo->all();
    }

    public function find(int $id): array
    {
        return $this->repo->find($id);
    }

    // Paginação envelopada no Service
    public function paginate(array $filtros, int $limit, int $offset): array
    {
        return $this->repo->paginate($filtros, $limit, $offset);
    }

    public function countTotal(array $filtros): int
    {
        return $this->repo->countTotal($filtros);
    }

    public function create(array $data, ?array $file = null): void
    {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
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

        // Ajustado para a tabela unificada
        $this->historicoRepo->create(
            'viacoes',
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'criado'
        );

        $this->cache->forget('home_viacoes');
    }

    public function update(int $id, array $data, ?array $file = null): void
    {
        $viacaoAtual = $this->repo->find($id);

        if (!$viacaoAtual) {
            throw new \Exception('Viação não encontrada');
        }

        // Se houver upload de imagem
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $logo = $this->upload->upload($file);
            if ($logo) {
                $data['logo'] = $logo;
            }
        }

        // Mantém a logo antiga se não enviou uma nova
        $data['logo'] = $data['logo'] ?? $viacaoAtual['logo'];

        //ANTES
        $antes = [
            'nome'   => $viacaoAtual['nome'],
            'url'    => $viacaoAtual['url'],
            'cidade' => $viacaoAtual['cidade'],
            'status' => $viacaoAtual['status'],
            'logo'   => $viacaoAtual['logo'],
        ];

        //DEPOIS
        $depois = [
            'nome'   => $data['nome'],
            'url'    => $data['url'],
            'cidade' => $data['cidade'],
            'status' => $data['status'] ?? $viacaoAtual['status'],
            'logo'   => $data['logo'],
        ];

        // Converte para JSON
        $alteracao = json_encode([
            'antes'  => $antes,
            'depois' => $depois,
        ], JSON_UNESCAPED_UNICODE);

        // 1. ATUALIZA A VIAÇÃO NO BANCO
        $this->repo->update($id, $data);

        // 2. GRAVA O HISTÓRICO NA NOVA TABELA UNIFICADA
        $this->historicoRepo->create(
            'viacoes',                    // tabela
            $id,                          // registro_id
            $_SESSION['usuario_id'] ?? 1, // usuario_id
            $alteracao,                   // texto do json
            'editado'                     // acao
        );

        $this->cache->forget('home_viacoes');
    }

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

        // Registra o histórico primeiro
        $this->historicoRepo->create(
            'viacoes',
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'excluido'
        );

        // Agora executa o Soft Delete adaptado no repositório
        $this->repo->delete($id);

        $this->cache->forget('home_viacoes');
    }

    public function restore(int $id): void
    {
        $viacao = $this->repo->find($id);
        if (!$viacao) {
            throw new \Exception('Viação não encontrada');
        }

        $this->repo->restore($id);

        $this->historicoRepo->create(
            'viacoes',
            $id,
            $_SESSION['usuario_id'] ?? 1,
            'Registro restaurado para a listagem ativa',
            'restaurado'
        );

        $this->cache->forget('home_viacoes');
    }

    public function findHistory(int $id): array
    {
        return $this->historicoRepo->findByRegistro('viacoes', $id);
    }

    public function allAtivas(): array
    {
        return $this->repo->allAtivas();
    }

    public function allHistory(string $acao = '', string $usuario = '', string $data = ''): array
    {
        return $this->historicoRepo->filter('viacoes', $acao, $usuario, $data);
    }
    public function paginateHistory(array $filtros, int $limit, int $offset): array
    {

        return $this->historicoRepo->paginate($filtros, $limit, $offset);
    }

    public function countTotalHistory(array $filtros): int
    {
        return $this->historicoRepo->countTotal($filtros);
    }
}