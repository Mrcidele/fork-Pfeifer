<?php

declare(strict_types=1);
use App\Controllers\ViacaoController;
use App\Controllers\AuthController;
use App\Controllers\UsuarioController;
/** @var App\Core\Router $router */

//rotas
$router->get('/', [ViacaoController::class, 'index']);
$router->get('/viacoes', [ViacaoController::class, 'index']);
$router->get('/viacoes/create', [ViacaoController::class, 'create']);
$router->post('/viacoes/store', [ViacaoController::class, 'store']);
$router->get('/viacoes/edit', [ViacaoController::class, 'edit']);
$router->post('/viacoes/update', [ViacaoController::class, 'update']);
$router->get('/viacoes/delete', [ViacaoController::class, 'destroy']);
$router->get('/viacoes/historico', [ViacaoController::class, 'historico']);
$router->get('/viacoes/home', [ViacaoController::class, 'home']);
$router->get('/viacoes/login', [ViacaoController::class, 'login']);
$router->get('/login',  [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Novas Rotas para Visualização Única e Restore de Viações
$router->get('/viacoes/show', [ViacaoController::class, 'show']); // Passar ?id=
$router->get('/viacoes/restore', [ViacaoController::class, 'restore']);

// Rotas CRUD Usuários
$router->get('/usuarios', [UsuarioController::class, 'index']);
$router->get('/usuarios/create', [UsuarioController::class, 'create']);
$router->post('/usuarios/store', [UsuarioController::class, 'store']);
$router->get('/usuarios/edit', [UsuarioController::class, 'edit']);
$router->post('/usuarios/update', [UsuarioController::class, 'update']);
$router->get('/usuarios/show', [UsuarioController::class, 'show']);
$router->get('/usuarios/delete', [UsuarioController::class, 'destroy']);
$router->get('/usuarios/restore', [UsuarioController::class, 'restore']);

$router->get('/usuarios/historico', [\App\Controllers\UsuarioController::class, 'historicoGeral']);