<?php

namespace App\Services;

/*Serviço simples de cache baseado em arquivos*/
final class CacheService
{
    //caminho onde os arquivos de cache serão armazenados
    private string $path;

    //tempo de vida do cache em segundos
    private int $ttl;

    /*define o TTL e cria a pasta de cache caso não exista
     @param int $ttl Tempo de expiração do cache (padrão: 300s = 5 min)*/
    public function __construct(int $ttl = 300)
    {
        //define o diretório de cache
        $this->path = dirname(__DIR__) . '/cache/';

        //define tempo de vida
        $this->ttl = $ttl;

        //cria a pasta caso não exista
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * Busca um valor no cache
     *
     * @param string $chave
     * @return mixed|null
     */
    public function get(string $chave): mixed
    {
        // gera nome único do arquivo usando hash MD5
        $arquivo = $this->path . md5($chave) . '.cache';

        //verifica se o arquivo existe
        if (!file_exists($arquivo)) {
            return null;
        }

        //verifica se o cache expirou
        if ((time() - filemtime($arquivo)) > $this->ttl) {

            //remove arquivo expirado
            unlink($arquivo);

            return null;
        }

        //retorna conteúdo desserializado
        return unserialize(file_get_contents($arquivo));
    }

    /*salva um valor no cache
     @param string $chave
     @param mixed $valor*/
    public function set(string $chave, mixed $valor): void
    {
        // gera nome do arquivo baseado na chave
        $arquivo = $this->path . md5($chave) . '.cache';

        // serializa e salva
        file_put_contents($arquivo, serialize($valor));
    }

    /*remove um item específico do cache
     @param string $chave*/
    public function forget(string $chave): void
    {
        //gera caminho do arquivo
        $arquivo = $this->path . md5($chave) . '.cache';

        // remove se existir
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }
    }
}