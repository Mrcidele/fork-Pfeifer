<div class="container-historico">
    <h1>Histórico de Usuários</h1>

    <a href="/usuarios" class="btn btn-success">&larr; Voltar</a>
    <br><br>

    <form method="GET" action="/usuarios/historico" class="filter-form mb-20">
        <select name="acao" class="filter-input">
            <option value="">Todas as ações</option>
            <option value="criado"   <?= ($filtros['acao'] ?? '') === 'criado'   ? 'selected' : '' ?>>Criado</option>
            <option value="editado"  <?= ($filtros['acao'] ?? '') === 'editado'  ? 'selected' : '' ?>>Editado</option>
            <option value="excluido" <?= ($filtros['acao'] ?? '') === 'excluido' ? 'selected' : '' ?>>Excluído</option>
            <option value="restaurado" <?= ($filtros['acao'] ?? '') === 'restaurado' ? 'selected' : '' ?>>Restaurado</option>
        </select>
        <input type="text" name="usuario" placeholder="Buscar por responsável..."
               value="<?= htmlspecialchars($filtros['usuario'] ?? '') ?>" class="filter-input">
        <input type="date" name="data"
               value="<?= htmlspecialchars($filtros['data'] ?? '') ?>" class="filter-input">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="/usuarios/historico" class="btn btn-secondary">Limpar</a>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID Registro</th>
            <th>Usuário</th>
            <th>Alteração</th>
            <th>Ação</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($historicos)): ?>
            <tr>
                <td colspan="5" style="text-align:center">Nenhum registro encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($historicos as $h): ?>
                <tr>
                    <td><?= $h['registro_id'] ?></td>
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
                                <tr><th>Campo</th><th>Antes</th><th>Depois</th></tr>
                                </thead>
                                <tbody>
                                <?php
                                $campos = ['nome', 'email', 'status'];
                                foreach ($campos as $campo):
                                    $vAntes = $antes[$campo] ?? '';
                                    $vDepois = $depois[$campo] ?? '';
                                    if ($vAntes === $vDepois) continue;
                                    ?>
                                    <tr>
                                        <td><b><?= ucfirst($campo) ?></b></td>
                                        <td class="diff-antes"><?= htmlspecialchars($vAntes) ?></td>
                                        <td class="diff-depois"><?= htmlspecialchars($vDepois) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <span class="muted">Alteração estrutural de registro.</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($h['acao'] === 'criado'): ?>
                            <span class="success">Criado</span>
                        <?php elseif ($h['acao'] === 'editado'): ?>
                            <span class="btn-editado">Editado</span>
                        <?php elseif ($h['acao'] === 'restaurado'): ?>
                            <span class="success" style="background: green; color: #fff; padding: 2px 5px;">Restaurado</span>
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
</div>