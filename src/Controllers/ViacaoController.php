<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\ViacaoService;
use App\Services\UploadService;

final class ViacaoController
{
    private ViacaoService $service;
    private UploadService $upload;

    public function __construct()
    {
        $this->service = new ViacaoService();
        $this->upload = new UploadService();
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

            $logo = null;

            if (isset($_FILES['logo'])) {
                $logo = $this->upload->upload($_FILES['logo']);
            }

            if ($logo) {
                $data['logo'] = $logo;
            }

            if ($isUpdate) {
                $id = (int) $_POST['id'];
                $this->service->update($id, $data);
            } else {
                $this->service->create($data);
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
            'title' => 'Editar Viação',
            'viacao' => $viacao
        ]);
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