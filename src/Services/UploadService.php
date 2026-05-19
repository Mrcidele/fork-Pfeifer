<?php

namespace App\Services;

final class UploadService
{
    private string $path;

    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        'image/svg',
    ];

    //extensões de imagem
    private const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
    ];

    private const MAX_SIZE = 2 * 1024 * 1024;

    public function __construct()
    {
        $this->path = dirname(__DIR__) . '/public/uploads/';
    }

    //parte de validação
    public function upload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception($this->getUploadError($file['error']));
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('Arquivo inválido.');
        }

        if ($file['size'] > self::MAX_SIZE) {
            throw new \Exception('Arquivo muito grande. Máximo permitido: 2MB.');
        }

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, self::ALLOWED_MIME_TYPES, true)) {
            throw new \Exception("Tipo de arquivo não permitido: {$mime}.");
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            throw new \Exception("Extensão não permitida: {$ext}.");
        }

        // SVG é XML/texto — exif_imagetype não suporta, valida diferente
        if ($ext === 'svg') {
            $conteudo = file_get_contents($file['tmp_name']);
            if (preg_match('/<script/i', $conteudo) || preg_match('/on\w+\s*=/i', $conteudo)) {
                throw new \Exception('SVG contém código não permitido.');
            }
        } else {
            // Para outros formatos valida que é imagem real
            if (exif_imagetype($file['tmp_name']) === false) {
                throw new \Exception('O arquivo não é uma imagem válida.');
            }
        }

        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }

        $nome = bin2hex(random_bytes(16)) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $this->path . $nome)) {
            throw new \Exception('Falha ao salvar o arquivo no servidor.');
        }

        return $nome;
    }

    //caso tenha algum erro no upload
    private function getUploadError(int $code): string
    {
        return match($code) {
            UPLOAD_ERR_INI_SIZE   => 'Arquivo maior que o permitido pelo servidor.',
            UPLOAD_ERR_FORM_SIZE  => 'Arquivo maior que o permitido pelo formulário.',
            UPLOAD_ERR_PARTIAL    => 'Upload incompleto.',
            UPLOAD_ERR_NO_FILE    => 'Nenhum arquivo enviado.',
            UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária ausente no servidor.',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao gravar no disco.',
            UPLOAD_ERR_EXTENSION  => 'Upload bloqueado por extensão PHP.',
            default               => 'Erro desconhecido no upload.',
        };
    }
}