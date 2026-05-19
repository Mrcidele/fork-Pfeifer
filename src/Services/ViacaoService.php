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
    private CacheService $cache;

    public function __construct()
    {
        $pdo = getPdo();
        $this->repo          = new ViacaoRepository($pdo);
        $this->historicoRepo = new ViacaoHistoricoRepository($pdo);
        $this->upload        = new UploadService();
        $this->cache         = new CacheService();
    }

    //procura no repository em todas as linhas
    public function all(): array
    {
        return $this->repo->all();
    }

    //encontra o id especifico
    public function find(int $id): array
    {
        return $this->repo->find($id);
    }

    //cria a viacao e envia o arquivo da imagem se existir e valida atraves do ViacaoValidator os campos de input
    public function create(array $data, ?array $file = null): void
    {
        // Só faz upload se um arquivo foi enviado de fato
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

        $this->historicoRepo->create(
            $id,
            $_SESSION['usuario_id'] ?? 1,
            $alteracao,
            'criado'
        );

        $this->cache->forget('home_viacoes');
    }

    //passa por validações para realizar a edição
    public function update(int $id, array $data, ?array $file = null): void
    {
        $viacaoAtual = $this->repo->find($id);

        if (!$viacaoAtual) {
            throw new \Exception('Viação não encontrada');
        }

        // Só faz upload se um arquivo foi enviado de fato
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $logo = $this->upload->upload($file);
            if ($logo) {
                $data['logo'] = $logo;
            }
        }

        // Mantém a logo atual se não enviou nova
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

        $this->cache->forget('home_viacoes');
    }

    //deleta atraves do id
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

        $this->cache->forget('home_viacoes');
    }

    //pega apenas as viacoes ativas para mostrar na home
    public function allAtivas(): array
    {
        return $this->repo->allAtivas();
    }

    //mostra o historico das alteracoes
    public function historicoAll(): array
    {
        return $this->historicoRepo->all();
    }

    //filtra a viacao
    public function filter(string $nome, string $cidade, string $status): array
    {
        return $this->repo->filter($nome, $cidade, $status);
    }

    //filtra o historico
    public function filterHistorico(string $acao, string $usuario, string $data): array
    {
        return $this->historicoRepo->filter($acao, $usuario, $data);
    }
}