<div class="container-form">
    <div class="container-form-botoes">
        <h1>Usuários</h1>
        <div class="container-form-botoes-lado">
            <p class="mb-20">
                <a href="/usuarios/create" class="btn btn-success">Novo Usuário</a>
                <a href="/usuarios/historico" class="btn btn-success">Ver Histórico</a>
                <a href="/logout" class="btn btn-danger" style="justify-content: space-between">Sair</a>
            </p>
        </div>
    </div>

    <form method="GET" action="/usuarios" class="filter-form">
        <input type="text" name="nome" placeholder="Buscar por nome..."
               value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>" class="filter-input">

        <select name="status" class="filter-input">
            <option value="0" <?= ($filtros['status'] ?? '0') === '0' ? 'selected' : '' ?>>Ativo</option>
            <option value="1" <?= ($filtros['status'] ?? '0') === '1' ? 'selected' : '' ?>>Inativo</option>
        </select>

        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="/usuarios" class="btn btn-secondary">Limpar</a>
    </form>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Status</th>
        <th width="220">Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($usuarios)): ?>
        <tr>
            <td colspan="5" style="text-align:center">Nenhum usuário encontrado.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nome'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                <td><?= $u['status'] == '0' ? 'Ativo' : 'Inativo' ?></td>
                <td>
                    <div class="actions">
                        <a href="/usuarios/edit?id=<?= $u['id'] ?>" class="btn btn-primary">Editar</a>
                        <?php if ($u['status'] == '0'): ?>
                            <a href="/usuarios/delete?id=<?= $u['id'] ?>" class="btn btn-danger"
                               onclick="return confirm('Deseja desativar este usuário?')">Desativar</a>
                        <?php else: ?>
                            <a href="/usuarios/restore?id=<?= $u['id'] ?>" class="btn btn-success">Restaurar</a>
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
            <a href="?pagina=<?= $i ?>&nome=<?= urlencode($filtros['nome'] ?? '') ?>&status=<?= urlencode($filtros['status'] ?? '0') ?>"
               class="btn <?= $i === $paginaAtual ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>