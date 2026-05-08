<?php

namespace App\Validators;

final class ViacaoValidator
{
    public static function validate(array $data): void
    {
        if (empty($data['nome'])) {
            throw new \Exception('Nome é obrigatório');
        }

        if (strlen($data['nome']) < 4 ){
            throw new \Exception('Deve possuir mais de 4 caracteres');
        }

        if (empty($data['cidade'])) {
            throw new \Exception('Cidade é obrigatória');
        }

        if (!isset($data['status']) || !in_array($data['status'], ['0', '1'])) {
            throw new \Exception('Status inválido');
        }

        if (!empty($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            throw new \Exception('URL inválida');
        }

    }
}