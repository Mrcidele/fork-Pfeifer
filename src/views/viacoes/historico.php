<br>
<div class="container-historico">
<h1>Histórico de Viações</h1>

<a href="/viacoes" class="btn btn-success">&larr; Voltar</a>
<br><br>

<form method="GET" action="/viacoes/historico" class="filter-form mb-20">
    <select name="acao" class="filter-input">
        <option value="">Todas as ações</option>
        <option value="criado"   <?= ($filtros['acao'] ?? '') === 'criado'   ? 'selected' : '' ?>>Criado</option>
        <option value="editado"  <?= ($filtros['acao'] ?? '') === 'editado'  ? 'selected' : '' ?>>Editado</option>
        <option value="excluido" <?= ($filtros['acao'] ?? '') === 'excluido' ? 'selected' : '' ?>>Excluído</option>
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
        <th>Viação</th>
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
        <td><?= $h['viacao_id'] ?></td>
        <td><?= htmlspecialchars($h['usuario_nome'] ?? '') ?></td>

        <td>
            <?php
            $alt    = json_decode($h['alteracao'] ?? '{}', true);
            $antes  = $alt['antes']  ?? null;
            $depois = $alt['depois'] ?? null;
            ?>

            <?php if ($antes && $depois): ?>
                <table class="diff-table">
                    <thead>
                    <tr>
                        <th>Campo</th>
                        <th>Antes</th>
                        <th>Depois</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $campos = ['nome', 'url', 'cidade', 'status', 'logo'];
                    foreach ($campos as $campo):
                        $valorAntes  = $antes[$campo]  ?? '';
                        $valorDepois = $depois[$campo] ?? '';
                        if ($valorAntes === $valorDepois) continue;
                        if ($campo === 'status') {
                            $valorAntes  = $valorAntes  == '0' ? 'Ativo' : 'Inativo';
                            $valorDepois = $valorDepois == '0' ? 'Ativo' : 'Inativo';
                        }
                        ?>
                        <tr>
                            <td><b><?= ucfirst($campo) ?></b></td>
                            <td class="diff-antes"><?= htmlspecialchars($valorAntes) ?></td>
                            <td class="diff-depois"><?= htmlspecialchars($valorDepois) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            <?php elseif (!$antes && $depois): ?>
                <span class="muted">
                            <?= htmlspecialchars($depois['nome'] ?? '') ?> —
                            <?= htmlspecialchars($depois['cidade'] ?? '') ?>
                        </span>

            <?php elseif ($antes && !$depois): ?>
                <span class="muted">
                            <?= htmlspecialchars($antes['nome'] ?? '') ?> —
                            <?= htmlspecialchars($antes['cidade'] ?? '') ?>
                        </span>

            <?php else: ?>
                <span class="muted">—</span>
            <?php endif; ?>
        </td>

        <td>
            <?php if ($h['acao'] === 'criado'): ?>
                <span class="success">Criado</span>
            <?php elseif ($h['acao'] === 'editado'): ?>
                <span class="btn-editado">Editado</span>
            <?php else: ?>
                <span class="alert--danger">Excluído</span>
            <?php endif; ?>
        </td>
        <td class="small muted"><?= $h['data_acao'] ?></td>
    </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
    <div>