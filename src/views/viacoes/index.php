<div class="container-form">
    <div class="container-form-botoes">
        <h1>Viações</h1>
        <div class="container-form-botoes-lado">
            <p class="mb-20">
                <a href="/viacoes/create" class="btn btn-success">Nova Viação</a>
                <a href="/viacoes/historico" class="btn btn-success">Ver Histórico</a>
                <a href="/logout" class="btn btn-danger">Sair</a>
            </p>
        </div>
    </div>

    <form method="GET" action="/viacoes" class="filter-form">
        <input type="text" name="nome" placeholder="Buscar por nome..."
               value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>" class="filter-input">
        <input type="text" name="cidade" placeholder="Buscar por cidade..."
               value="<?= htmlspecialchars($filtros['cidade'] ?? '') ?>" class="filter-input">

        <select name="status" class="filter-input">
            <option value="0" <?= ($filtros['status'] ?? '0') === '0' ? 'selected' : '' ?>>Ativo</option>
            <option value="1" <?= ($filtros['status'] ?? '0') === '1' ? 'selected' : '' ?>>Inativo</option>
        </select>

        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="/viacoes" class="btn btn-secondary">Limpar</a>
    </form>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Logo</th>
        <th>Nome</th>
        <th>Cidade</th>
        <th>Status</th>
        <th width="220">Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($viacoes)): ?>
        <tr>
            <td colspan="6" style="text-align:center">Nenhuma viação encontrada.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($viacoes as $v): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><img src="/uploads/<?= htmlspecialchars($v['logo'] ?? '') ?>" width="80"></td>
                <td><?= htmlspecialchars($v['nome'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['cidade'] ?? '') ?></td>
                <td><?= $v['status'] == '0' ? 'Ativo' : 'Inativo' ?></td>
                <td>
                    <div class="actions">
                        <a href="/viacoes/show?id=<?= $v['id'] ?>" class="btn btn-secondary">Detalhes</a>
                        <?php if ($v['status'] == '0'): ?>
                            <a href="/viacoes/delete?id=<?= $v['id'] ?>" class="btn btn-danger"
                               onclick="return confirm('Deseja mover para a lixeira?')">Excluir</a>
                        <?php else: ?>
                            <a href="/viacoes/restore?id=<?= $v['id'] ?>" class="btn btn-success">Restaurar</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php if (($totalPaginas ?? 1) > 1): ?>
    <div style="text-align: center; margin-top: 20px;">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>&nome=<?= urlencode($filtros['nome'] ?? '') ?>&cidade=<?= urlencode($filtros['cidade'] ?? '') ?>&status=<?= urlencode($filtros['status'] ?? '0') ?>"
               class="btn <?= $i === $paginaAtual ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>