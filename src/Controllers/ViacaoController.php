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
        $data = $_POST;

        if (!empty($_FILES['logo']['name'])) {

            $file = $_FILES['logo'];

            $nomeArquivo = uniqid() . '_' . $file['name'];

            $uploadPath = dirname(__DIR__, 2) . '/src/public/uploads/';

            move_uploaded_file(
                $file['tmp_name'],
                $uploadPath . $nomeArquivo
            );

            $data['logo'] = $nomeArquivo;
        }

        $this->service->create($data);

        header('Location: /viacoes');
        exit;
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
        $data = $_POST;

        if (!empty($_FILES['logo']['name'])) {

            $file = $_FILES['logo'];

            $nomeArquivo = uniqid() . '_' . $file['name'];

            $uploadPath = dirname(__DIR__, 2) . '/src/public/uploads/';


            move_uploaded_file(
                $file['tmp_name'],
                $uploadPath . $nomeArquivo
            );

            $data['logo'] = $nomeArquivo;
        }

        $this->service->update($id, $data);

        header('Location: /viacoes');
        exit;
    }

    public function historico(): void
    {
        $historico = $this->service->historicoAll();

        View::render('viacoes/historico', [
            'title' => 'Histórico de Viações',
            'historico' => $historico
        ]);
    }

}