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

    public function index(): void
    {
        $viacoes = $this->service->all();

        View::render('viacoes/index', [
            'title' => 'Viações',
            'viacoes' => $viacoes
        ]);
    }

    public function create(): void
    {
        View::render('viacoes/create', [
            'title' => 'Nova Viação'
        ]);
    }

    public function store(): void
    {
        $this->service->create($_POST);

        header('Location: /viacoes');
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
            'title' => 'Editar Viação',
            'viacao' => $viacao
        ]);
    }

    public function update(): void
    {
        $id = (int) $_POST['id'];

        $this->service->update($id, $_POST);

        header('Location: /viacoes');
        exit;
    }

}