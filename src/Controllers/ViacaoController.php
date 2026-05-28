<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\ViacaoService;

final class ViacaoController
{
    private ViacaoService $service;

    public function __construct()
    {
        $this->service = new ViacaoService();
    }

    public function create(): void
    {
        View::render('viacoes/create', [
            'title' => 'Nova Viação'
        ]);
    }

    public function home(): void
    {
        // Buscamos as viações ativas DIRETAMENTE do banco de dados, sem usar o cache!
        $viacoes = $this->service->allAtivas();

        View::render('viacoes/home', [
            'title'   => 'Quero Passagem',
            'css'     => 'home',
            'viacoes' => $viacoes,
        ], false);
    }

    public function login(): void
    {
        View::render('viacoes/login', [
            'title' => 'Login',
            'css'   => 'login'
        ], false);
    }

    public function store(): void
    {
        $this->save();
    }

    public function update(): void
    {
        $this->save(true);
    }

    private function save(bool $isUpdate = false): void
    {
        try {
            $data = $_POST;
            $file = $_FILES['logo'] ?? null;

            if ($isUpdate) {
                $id = (int) $_POST['id'];
                $this->service->update($id, $data, $file);
            } else {
                $this->service->create($data, $file);
            }

            header('Location: /viacoes');
            exit;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function destroy(): void
    {
        $id = (int) $_GET['id'];
        $this->service->delete($id);
        header('Location: /viacoes');
        exit;
    }

    public function restore(): void
    {
        $id = (int) $_GET['id'];
        $this->service->restore($id);
        header('Location: /viacoes');
        exit;
    }

    public function show(): void
    {
        $id = (int) $_GET['id'];
        $viacao = $this->service->find($id);
        $historico = $this->service->findHistory($id);

        View::render('viacoes/show', [
            'title'     => 'Detalhes da Viação',
            'viacao'    => $viacao,
            'historico' => $historico
        ]);
    }

    public function edit(): void
    {
        $id = (int) $_GET['id'];
        $viacao = $this->service->find($id);
        $historico = $this->service->findHistory($id);

        \App\Core\View::render('viacoes/edit', [
            'title'     => 'Editar Viação',
            'viacao'    => $viacao,
            'historico' => $historico
        ]);
    }

    // Listagem com Paginação e Filtros integrada
    public function index(): void
    {
        $nome   = trim($_GET['nome']   ?? '');
        $cidade = trim($_GET['cidade'] ?? '');
        $status = $_GET['status'] ?? '0';
        if ($status === '') $status = '0';

        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        if ($paginaAtual < 1) $paginaAtual = 1;
        $limit = 5;
        $offset = ($paginaAtual - 1) * $limit;

        $filtros = compact('nome', 'cidade', 'status');

        $viacoes = $this->service->paginate($filtros, $limit, $offset);
        $totalRegistros = $this->service->countTotal($filtros);

        $totalPaginas = $totalRegistros > 0 ? ceil($totalRegistros / $limit) : 1;

        View::render('viacoes/index', [
            'title'          => 'Viações',
            'viacoes'        => $viacoes,
            'filtros'        => $filtros,
            'paginaAtual'    => $paginaAtual,
            'totalPaginas'   => (int)$totalPaginas, // Garante que seja um número
            'totalRegistros' => $totalRegistros
        ]);
    }

    public function historico(): void
    {
        $acao    = trim($_GET['acao'] ?? '');
        $usuario = trim($_GET['usuario'] ?? '');
        $data    = trim($_GET['data'] ?? '');

        // Configuração da Paginação
        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        if ($paginaAtual < 1) $paginaAtual = 1;
        $limit = 10; // Quantos logs aparecerão por página
        $offset = ($paginaAtual - 1) * $limit;

        // Monta os filtros para passar pro Service/Repository
        $filtros = [
            'tabela'  => 'viacoes',
            'acao'    => $acao,
            'usuario' => $usuario,
            'data'    => $data
        ];

        // Busca paginada e contagem total
        $historico = $this->service->paginateHistory($filtros, $limit, $offset);
        $totalRegistros = $this->service->countTotalHistory($filtros);

        $totalPaginas = $totalRegistros > 0 ? ceil($totalRegistros / $limit) : 1;

        \App\Core\View::render('viacoes/historico', [
            'title'          => 'Histórico Geral de Viações',
            'historico'      => $historico,
            'filtros'        => $filtros,
            'paginaAtual'    => $paginaAtual,
            'totalPaginas'   => (int)$totalPaginas,
            'totalRegistros' => $totalRegistros
        ]);
    }
}