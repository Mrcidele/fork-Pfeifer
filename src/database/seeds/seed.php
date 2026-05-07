<?php

require_once dirname(__DIR__) . '/db.php';

$pdo = getPdo();
$files = glob(__DIR__ . '/*.sql');

sort($files);

foreach ($files as $file) {

    echo 'Executando seed: '
        . basename($file)
        . PHP_EOL;

    $sql = file_get_contents($file);
    $pdo->exec($sql);
}

echo 'Seeds executados com sucesso!' . PHP_EOL;