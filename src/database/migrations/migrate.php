<?php

require_once dirname(__DIR__) . '/db.php';

$pdo = getPdo();
$path = __DIR__;
$files = glob($path . '/*.sql');

foreach ($files as $file) {

    echo "Executando: " . basename($file) . PHP_EOL;

    $sql = file_get_contents($file);
    $pdo->exec($sql);
}

echo "Migrations executadas com sucesso!" . PHP_EOL;