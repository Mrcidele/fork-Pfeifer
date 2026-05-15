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
        View::render('viacoes/home', [
            'title' => 'Quero Passagem',
            'css'   => 'home'
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

    public function edit(): void
    {
        $id = (int) $_GET['id'];
        $viacao = $this->service->find($id);
        View::render('viacoes/edit', [
            'title'  => 'Editar Viação',
            'viacao' => $viacao
        ]);
    }

    public function index(): void
    {
        $nome   = trim($_GET['nome']   ?? '');
        $cidade = trim($_GET['cidade'] ?? '');
        $status = $_GET['status'] ?? '';

        $viacoes = ($nome || $cidade || $status !== '')
            ? $this->service->filter($nome, $cidade, $status)
            : $this->service->all();

        View::render('viacoes/index', [
            'title'   => 'Viações',
            'viacoes' => $viacoes,
            'filtros' => compact('nome', 'cidade', 'status'),
        ]);
    }

    public function historico(): void
    {
        $acao    = trim($_GET['acao']    ?? '');
        $usuario = trim($_GET['usuario'] ?? '');
        $data    = trim($_GET['data']    ?? '');

        $historico = ($acao || $usuario || $data)
            ? $this->service->filterHistorico($acao, $usuario, $data)
            : $this->service->historicoAll();

        View::render('viacoes/historico', [
            'title'     => 'Histórico de Viações',
            'historico' => $historico,
            'filtros'   => compact('acao', 'usuario', 'data'),
        ]);
    }
}