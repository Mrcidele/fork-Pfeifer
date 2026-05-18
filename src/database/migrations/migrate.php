<?php

require_once dirname(__DIR__) . '/db.php';

//conecta no banco e procura na pasta todos os arquivos que terminam em sql
$pdo = getPdo();
$path = __DIR__;
$files = glob($path . '/*.sql');

//executa os arquivos em sql
foreach ($files as $file) {

    echo "Executando: " . basename($file) . PHP_EOL;

    $sql = file_get_contents($file);
    $pdo->exec($sql);
}

echo "Migrations executadas com sucesso!" . PHP_EOL;