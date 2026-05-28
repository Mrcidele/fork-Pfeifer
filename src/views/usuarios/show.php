<h2>Histórico do Registro</h2>
<table class="historico-table">
    <thead>
    <tr>
        <th>Data</th>
        <th>Usuário</th>
        <th>Ação</th>
        <th style="width: 50%;">Alterações (Antes / Depois)</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($historico)): ?>
        <tr><td colspan="4" style="text-align:center">Nenhuma alteração registrada.</td></tr>
    <?php else: ?>
        <?php foreach ($historico as $h): ?>
            <tr>
                <td class="small muted"><?= htmlspecialchars($h['data_acao'] ?? '') ?></td>
                <td><?= htmlspecialchars($h['usuario_nome'] ?? 'Sistema') ?></td>
                <td>
                    <span class="badge-<?= $h['acao'] ?>"><?= ucfirst($h['acao']) ?></span>
                </td>
                <td>
                    <?php
                    $alt = json_decode($h['alteracao'] ?? '{}', true);
                    $antes = $alt['antes'] ?? null;
                    $depois = $alt['depois'] ?? null;
                    ?>

                    <?php if ($antes && $depois): ?>
                        <table class="diff-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th style="text-align: left;">Campo</th>
                                <th>Antes</th>
                                <th>Depois</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Lista de campos para exibir na comparação
                            foreach (['nome', 'cidade', 'url', 'status'] as $c):
                                $vA = $antes[$c] ?? '';
                                $vD = $depois[$c] ?? '';
                                if ($vA === $vD) continue; // Pula campos sem alteração

                                if ($c === 'status') {
                                    $vA = $vA == '0' ? 'Ativo' : 'Inativo';
                                    $vD = $vD == '0' ? 'Ativo' : 'Inativo';
                                }
                                ?>
                                <tr>
                                    <td><b><?= ucfirst($c) ?></b></td>
                                    <td class="diff-antes" style="padding: 5px 10px;"><?= htmlspecialchars($vA) ?></td>
                                    <td class="diff-depois" style="padding: 5px 10px;"><?= htmlspecialchars($vD) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <small class="muted">Registro criado.</small>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>