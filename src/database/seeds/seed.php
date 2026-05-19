<?php

require_once dirname(__DIR__) . '/db.php';

//executa todos os arquivos da pasta em sql
$pdo = getPdo();
$files = glob(__DIR__ . '/*.sql');

sort($files);

//executa o seed no banco
foreach ($files as $file) {
    echo 'Executando seed: ' . basename($file) . PHP_EOL;

    $sql = file_get_contents($file);

    //substitui INSERT por INSERT IGNORE para evitar erro de duplicata
    $sql = str_ireplace('INSERT INTO', 'INSERT IGNORE INTO', $sql);

    $pdo->exec($sql);
}

echo 'Seeds executados com sucesso!' . PHP_EOL;