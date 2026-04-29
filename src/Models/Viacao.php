<?php

namespace App\Models;

final class Viacao
{
    public function __construct(
        public ?int $id,
        public string $nome,
        public ?string $url,
        public ?string $cidade,
        public string $status,
        public ?string $logo
    ) {}
}
