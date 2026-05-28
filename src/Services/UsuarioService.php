<?php

namespace App\Services;

use App\Repository\UsuarioRepository;
use App\Repository\HistoricoRepository;

final class UsuarioService
{
    private UsuarioRepository $repo;
    private HistoricoRepository $historicoRepo;

    public function __construct()
    {
        $this->repo = new UsuarioRepository();
        $this->historicoRepo = new HistoricoRepository(getPdo());
    }


    // Retorna a listagem de usuários paginada e filtrada.

    public function paginate(array $filtros, int $limit, int $offset): array
    {
        return $this->repo->paginate($filtros, $limit, $offset);
    }


    // Conta o total de usuários com base nos filtros aplicados.

    public function countTotal(array $filtros): int
    {
        return $this->repo->countTotal($filtros);
    }


    // Busca um usuário específico pelo ID.

    public function find(int $id): array
    {
        return $this->repo->find($id);
    }


    // Busca o histórico individual de alterações de um usuário.

    public function findHistory(int $id): array
    {
        return $this->historicoRepo->findByRegistro('usuarios', $id);
    }


    // Regra de Negócio: Trata os dados, criptografa a senha e cria o usuário com o log de histórico.

    public function create(array $data, int $usuarioLogadoId): int
    {
        $data['senha'] = password_hash($data['senha'], PASSWORD_BCRYPT);
        $data['status'] = 0;

        $id = $this->repo->create($data);

        // Grava histórico de criação
        $depois = $this->repo->find($id);
        $alteracao = json_encode(['antes' => null, 'depois' => $depois], JSON_UNESCAPED_UNICODE);

        $this->historicoRepo->create('usuarios', $id, $usuarioLogadoId, $alteracao, 'criado');

        return $id;
    }


    // Regra de Negócio: Atualiza os dados cadastrais mantendo o rastreamento do estado anterior e atual.

    public function update(int $id, array $data, int $usuarioLogadoId): void
    {
        $antes = $this->repo->find($id);

        $this->repo->update($id, $data);

        $depois = $this->repo->find($id);

        $alteracao = json_encode(['antes' => $antes, 'depois' => $depois], JSON_UNESCAPED_UNICODE);
        $this->historicoRepo->create('usuarios', $id, $usuarioLogadoId, $alteracao, 'editado');
    }


    //Regra de Negócio: Executa o soft delete e documenta a exclusão no histórico.

    public function delete(int $id, int $usuarioLogadoId): void
    {
        $antes = $this->repo->find($id);

        $this->repo->delete($id);

        $depois = $this->repo->find($id);

        $alteracao = json_encode(['antes' => $antes, 'depois' => $depois], JSON_UNESCAPED_UNICODE);
        $this->historicoRepo->create('usuarios', $id, $usuarioLogadoId, $alteracao, 'excluido');
    }


    // Regra de Negócio: Restaura um usuário excluído e documenta no histórico.

    public function restore(int $id, int $usuarioLogadoId): void
    {
        $antes = $this->repo->find($id);

        $this->repo->restore($id);

        $depois = $this->repo->find($id);

        $alteracao = json_encode(['antes' => $antes, 'depois' => $depois], JSON_UNESCAPED_UNICODE);
        $this->historicoRepo->create('usuarios', $id, $usuarioLogadoId, $alteracao, 'restaurado');
    }


    // Retorna a listagem do histórico geral de usuários de forma paginada.

    public function paginateHistory(array $filtros, int $limit, int $offset): array
    {
        return $this->historicoRepo->paginate($filtros, $limit, $offset);
    }


    // Conta a quantidade total de registros de logs para a paginação do histórico geral.

    public function countTotalHistory(array $filtros): int
    {
        return $this->historicoRepo->countTotal($filtros);
    }
}