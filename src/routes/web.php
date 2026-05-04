<?php

declare(strict_types=1);
use App\Controllers\ViacaoController;
/** @var App\Core\Router $router */

$router->get('/', [ViacaoController::class, 'index']);
$router->get('/viacoes', [ViacaoController::class, 'index']);
$router->get('/viacoes/create', [ViacaoController::class, 'create']);
$router->post('/viacoes/store', [ViacaoController::class, 'store']);
$router->get('/viacoes/edit', [ViacaoController::class, 'edit']);
$router->post('/viacoes/update', [ViacaoController::class, 'update']);
$router->get('/viacoes/delete', [ViacaoController::class, 'destroy']);