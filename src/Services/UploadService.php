<?php

namespace App\Services;

final class UploadService
{
    private string $path;

    public function __construct()
    {
        $this->path = dirname(__DIR__, 2) . '/public/uploads/';
    }

    public function upload(array $file): ?string
    {
        if (empty($file['name'])) {
            return null;
        }

        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $nome = uniqid() . '_' . basename($file['name']);

        if (!move_uploaded_file($file['tmp_name'], $this->path . $nome)) {
            throw new \Exception('Erro ao fazer upload');
        }

        return $nome;
    }
}