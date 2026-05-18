<?php

declare(strict_types=1);
use App\Controllers\ViacaoController;
use App\Controllers\AuthController;
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