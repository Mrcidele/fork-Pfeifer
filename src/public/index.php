<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/db.php';

use App\Core\Router;

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = $uri ?: '/';

$router->dispatch($method, $uri);