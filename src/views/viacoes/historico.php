<div class="container-historico">
    <h1>Histórico de Viações</h1>

    <a href="/viacoes" class="btn btn-success">&larr; Voltar</a>
    <br><br>

    <form method="GET" action="/viacoes/historico" class="filter-form mb-20">
        <select name="acao" class="filter-input">
            <option value="">Todas as ações</option>
            <option value="criado" <?= ($filtros['acao'] ?? '') === 'criado' ? 'selected' : '' ?>>Criado</option>
            <option value="editado" <?= ($filtros['acao'] ?? '') === 'editado' ? 'selected' : '' ?>>Editado</option>
            <option value="excluido" <?= ($filtros['acao'] ?? '') === 'excluido' ? 'selected' : '' ?>>Excluído</option>
            <option value="restaurado" <?= ($filtros['acao'] ?? '') === 'restaurado' ? 'selected' : '' ?>>Restaurado</option>
        </select>
        <input type="text" name="usuario" placeholder="Buscar por usuário..."
               value="<?= htmlspecialchars($filtros['usuario'] ?? '') ?>" class="filter-input">
        <input type="date" name="data"
               value="<?= htmlspecialchars($filtros['data'] ?? '') ?>" class="filter-input">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="/viacoes/historico" class="btn btn-secondary">Limpar</a>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID Viação</th>
            <th>Usuário</th>
            <th>Alteração</th>
            <th>Ação</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($historico)): ?>
            <tr>
                <td colspan="5" style="text-align:center">Nenhum registro encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($historico as $h): ?>
                <tr>
                    <td>#<?= $h['registro_id'] ?></td>
                    <td><?= htmlspecialchars($h['usuario_nome'] ?? 'Sistema') ?></td>
                    <td>
                        <?php
                        $alt = json_decode($h['alteracao'] ?? '{}', true);
                        $antes = $alt['antes'] ?? null;
                        $depois = $alt['depois'] ?? null;
                        ?>
                        <?php if ($antes && $depois): ?>
                            <table class="diff-table">
                                <thead><tr><th>Campo</th><th>Antes</th><th>Depois</th></tr></thead>
                                <tbody>
                                <?php foreach (['nome', 'cidade', 'status'] as $c):
                                    $vA = $antes[$c] ?? ''; $vD = $depois[$c] ?? '';
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
                        <span class="btn-<?= $h['acao'] ?>"><?= ucfirst($h['acao']) ?></span>
                    </td>
                    <td class="small muted"><?= $h['data_acao'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php if (($totalPaginas ?? 1) > 1): ?>
    <div style="text-align: center; margin-top: 20px;">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>&acao=<?= urlencode($filtros['acao'] ?? '') ?>&usuario=<?= urlencode($filtros['usuario'] ?? '') ?>&data=<?= urlencode($filtros['data'] ?? '') ?>"
               class="btn <?= $i === $paginaAtual ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>