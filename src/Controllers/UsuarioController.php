<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\UsuarioService;

final class UsuarioController
{
    private UsuarioService $service;

    public function __construct()
    {
        $this->service = new UsuarioService();
    }

    // Listagem de usuários com paginação e filtragem
    public function index(): void
    {
        $nome = trim($_GET['nome'] ?? '');
        $status = $_GET['status'] ?? '0';

        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        if ($paginaAtual < 1) {
            $paginaAtual = 1;
        }
        $limit = 5;
        $offset = ($paginaAtual - 1) * $limit;

        $filtros = compact('nome', 'status');

        $usuarios = $this->service->paginate($filtros, $limit, $offset);
        $totalRegistros = $this->service->countTotal($filtros);
        $totalPaginas = ceil($totalRegistros / $limit);

        View::render('usuarios/index', [
            'title'          => 'Usuários',
            'usuarios'       => $usuarios,
            'filtros'        => $filtros,
            'paginaAtual'    => $paginaAtual,
            'totalPaginas'   => $totalPaginas,
            'totalRegistros' => $totalRegistros
        ]);
    }

    // Tela de criação de novo usuário
    public function create(): void
    {
        View::render('usuarios/create', [
            'title' => 'Novo Usuário'
        ]);
    }

    // Processa a inserção do usuário delegando ao Service
    public function store(): void
    {
        try {
            $usuarioLogadoId = $_SESSION['usuario_id'] ?? 1;

            $this->service->create($_POST, $usuarioLogadoId);

            header('Location: /usuarios');
            exit;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // Tela de edição carregando os dados atuais e o histórico individual via Service
    public function edit(): void
    {
        $id = (int)$_GET['id'];
        $usuario = $this->service->find($id);
        $historico = $this->service->findHistory($id);

        View::render('usuarios/edit', [
            'title'     => 'Editar Usuário',
            'usuario'   => $usuario,
            'historico' => $historico
        ]);
    }

    // Processa a atualização dos dados cadastrais via Service
    public function update(): void
    {
        try {
            $id = (int)$_POST['id'];
            $usuarioLogadoId = $_SESSION['usuario_id'] ?? 1;

            $this->service->update($id, $_POST, $usuarioLogadoId);

            header('Location: /usuarios');
            exit;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // Exibe os detalhes de um usuário específico
    public function show(): void
    {
        $id = (int)$_GET['id'];
        $usuario = $this->service->find($id);
        $historico = $this->service->findHistory($id);

        View::render('usuarios/show', [
            'title'     => 'Detalhes do Usuário',
            'usuario'   => $usuario,
            'historico' => $historico
        ]);
    }

    // Executa o Soft Delete via Service
    public function destroy(): void
    {
        $id = (int)$_GET['id'];
        $usuarioLogadoId = $_SESSION['usuario_id'] ?? 1;

        $this->service->delete($id, $usuarioLogadoId);

        header('Location: /usuarios');
        exit;
    }

    // Restaura o registro da lixeira via Service
    public function restore(): void
    {
        $id = (int)$_GET['id'];
        $usuarioLogadoId = $_SESSION['usuario_id'] ?? 1;

        $this->service->restore($id, $usuarioLogadoId);

        header('Location: /usuarios');
        exit;
    }

    // Exibe a tela de histórico geral de logs delegando a paginação ao Service
    public function historicoGeral(): void
    {
        // Captura os filtros opcionais enviados por GET
        $acao = trim($_GET['acao'] ?? '');
        $usuario = trim($_GET['usuario'] ?? '');
        $data = trim($_GET['data'] ?? '');

        // Configuração da Paginação
        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        if ($paginaAtual < 1) {
            $paginaAtual = 1;
        }
        $limit = 10;
        $offset = ($paginaAtual - 1) * $limit;

        // Monta o array de filtros exigido
        $filtros = [
            'tabela' => 'usuarios',
            'acao' => $acao,
            'usuario' => $usuario,
            'data' => $data
        ];

        // Busca os registros e o total através do Service
        $historicos = $this->service->paginateHistory($filtros, $limit, $offset);
        $totalRegistros = $this->service->countTotalHistory($filtros);
        $totalPaginas = ceil($totalRegistros / $limit);

        // Renderiza a View
        View::render('usuarios/historico', [
            'title'          => 'Histórico Geral de Usuários',
            'historicos'     => $historicos,
            'filtros'        => $filtros,
            'paginaAtual'    => $paginaAtual,
            'totalPaginas'   => $totalPaginas,
            'totalRegistros' => $totalRegistros
        ]);
    }
}