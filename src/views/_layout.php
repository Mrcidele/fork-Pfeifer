<?php

declare(strict_types=1);

use App\Core\View;

/** @var string $content */
/** @var string|null $title */

$flash = View::pullFlash();?>

<?php if (($title ?? '') !== 'Login' && ($title ?? '') !== 'Quero Passagem'): ?>
<header>
    <nav>
        <a href="/viacoes">Viações</a>
    </nav>
</header>
<?php endif; ?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Task App', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/<?= $css ?? 'app.css' ?>">
</head>
<body>


<?php if ($flash !== null): ?>
    <div class="flash">
        <div class="flash__box flash__box--<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?>">
            <strong><?= htmlspecialchars(strtoupper($flash['type']), ENT_QUOTES, 'UTF-8') ?>:</strong>
            <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    </div>
<?php endif; ?>

<main>
    <?= $content ?>
</main>
</body>
</html>
