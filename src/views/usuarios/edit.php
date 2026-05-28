<br>
<div class="container-historico">
    <h1><?= htmlspecialchars($title ?? 'Editar Usuário') ?></h1>
    <a href="/usuarios" class="btn btn-secondary">&larr; Voltar</a>
    <br><br>

    <form method="POST" action="/usuarios/update" style="max-width: 600px; display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px;">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id'] ?? '') ?>">

        <div>
            <label for="nome" style="font-weight: bold; display: block; margin-bottom: 5px;">Nome Completo</label>
            <input type="text" name="nome" id="nome" class="filter-input" style="width: 100%;" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
        </div>

        <div>
            <label for="email" style="font-weight: bold; display: block; margin-bottom: 5px;">E-mail</label>
            <input type="email" name="email" id="email" class="filter-input" style="width: 100%;" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
        </div>

        <div style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
        </div>
    </form>

    <?php if (!empty($historico)): ?>
    <hr style="margin: 30px 0; border: 1px solid #ddd;">
    <h3>Últimas alterações neste usuário</h3>
    <table>
        <thead>
        <tr>
            <th>Data</th>
            <th>Responsável</th>
            <th>Alteração</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($historico as $h): ?>
            <tr>
                <td class="small muted"><?= htmlspecialchars($h['data_acao'] ?? '') ?></td>
                <td><?= htmlspecialchars($h['usuario_nome'] ?? 'Sistema') ?></td>
                <td>
                    <?php
                    // Decodifica o JSON de alterações (antes e depois)
                    $alt = json_decode($h['alteracao'] ?? '{}', true);
                    $antes = $alt['antes'] ?? null;
                    $depois = $alt['depois'] ?? null;
                    ?>
                    <?php if ($antes && $depois): ?>
                        <table class="diff-table">
                            <thead><tr><th>Campo</th><th>Antes</th><th>Depois</th></tr></thead>
                            <tbody>
                            <?php
                            // Campos específicos da tabela 'usuarios'
                            foreach (['nome', 'email', 'tipo', 'status'] as $c):
                                $vA = $antes[$c] ?? '';
                                $vD = $depois[$c] ?? '';

                                // Se o valor não mudou, pula para o próximo campo
                                if ($vA === $vD) continue;
                                ?>
                                <tr>
                                    <td><b><?= ucfirst($c) ?></b></td>
                                    <td class="diff-antes"><?= htmlspecialchars($vA) ?></td>
                                    <td class="diff-depois"><?= htmlspecialchars($vD) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <span class="muted">Alteração de registro</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="btn-<?= htmlspecialchars($h['acao'] ?? '') ?>"><?= htmlspecialchars(ucfirst($h['acao'] ?? '')) ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>