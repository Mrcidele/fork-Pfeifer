<div class="container-form">
    <div class="container-form-botoes">
        <h1>Detalhes da Viação #<?= $viacao['id'] ?></h1>
        <div class="container-form-botoes-lado">
            <p class="mb-20">
                <a href="/viacoes" class="btn btn-secondary">&larr; Voltar</a>
                <a href="/viacoes/edit?id=<?= $viacao['id'] ?>" class="btn btn-primary">Editar</a>
            </p>
        </div>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #ddd;">
        <p><strong>Nome:</strong> <?= htmlspecialchars($viacao['nome'] ?? '') ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($viacao['cidade'] ?? '') ?></p>
        <p><strong>URL:</strong> <?= htmlspecialchars($viacao['url'] ?? '') ?></p>
        <p><strong>Status:</strong> <?= $viacao['status'] == '0' ? 'Ativo' : 'Inativo' ?></p>

        <?php if (!empty($viacao['logo'])): ?>
            <p><strong>Logo:</strong><br>
                <img src="/uploads/<?= htmlspecialchars($viacao['logo']) ?>" width="150" style="margin-top: 10px;"></p>
        <?php endif; ?>
    </div>

    <h2>Histórico de Alterações</h2>
    <table>
        <thead>
        <tr>
            <th>Data</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Alterações (Antes / Depois)</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($historico)): ?>
            <tr>
                <td colspan="4" style="text-align:center">Nenhuma alteração registrada para este registro.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($historico as $h): ?>
                <tr>
                    <td class="small muted"><?= htmlspecialchars($h['data_acao'] ?? '') ?></td>
                    <td><?= htmlspecialchars($h['usuario_nome'] ?? 'Sistema') ?></td>
                    <td>
                        <?php
                        $class = ($h['acao'] === 'criado') ? 'success' : 'btn-editado';
                        if ($h['acao'] === 'excluido') $class = 'alert--danger';
                        if ($h['acao'] === 'restaurado') $class = 'success';
                        ?>
                        <span class="<?= $class ?>"><?= ucfirst($h['acao']) ?></span>
                    </td>
                    <td>
                        <?php
                        $alt = json_decode($h['alteracao'] ?? '{}', true);
                        $antes = $alt['antes'] ?? null;
                        $depois = $alt['depois'] ?? null;
                        ?>

                        <?php if ($antes && $depois): ?>
                            <table class="diff-table" style="width:100%;">
                                <thead>
                                <tr><th>Campo</th><th>Antes</th><th>Depois</th></tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach (['nome', 'cidade', 'url', 'status'] as $c):
                                    $vA = $antes[$c] ?? '';
                                    $vD = $depois[$c] ?? '';
                                    if ($vA === $vD) continue; // Mostra apenas o que mudou

                                    if ($c === 'status') {
                                        $vA = $vA == '0' ? 'Ativo' : 'Inativo';
                                        $vD = $vD == '0' ? 'Ativo' : 'Inativo';
                                    }
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
                            <small class="muted">Ação de registro.</small>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>