<?php

require_once dirname(__DIR__) . '/db.php';

//procura todos os arquivos em sql e conecta com o banco
$pdo = getPdo();
$files = glob(__DIR__ . '/*.sql');

sort($files);

//executa no banco os arquivos em sql para popular as tabelas
foreach ($files as $file) {

    echo 'Executando seed: '
        . basename($file)
        . PHP_EOL;

    $sql = file_get_contents($file);
    $pdo->exec($sql);
}

echo 'Seeds executados com sucesso!' . PHP_EOL;