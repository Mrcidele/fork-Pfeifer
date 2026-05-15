<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/db.php';

use App\Core\Router;
use App\Services\AuthService;

//proteção de rotas
$rotasPublicas = ['/login', '/viacoes/home'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!in_array($uri, $rotasPublicas) && !AuthService::check()) {
    header('Location: /login');
    exit;
}

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$router->dispatch($method, $uri);