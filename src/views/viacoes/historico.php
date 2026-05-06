<h1>Histórico de Viações</h1>

<a href="/viacoes" class="btn btn-success"><-- Voltar</a>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Viação</th>
        <th>Cidade</th>
        <th>Status</th>
        <th>Ação</th>
        <th>Data</th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($historico as $h): ?>

        <tr>
            <td><?= $h['viacao_id'] ?></td>

            <td>
                <?= $h['nome'] ?>
                <div class="small muted">
                    (Atual: <?= $h['nome_atual'] ?? 'Removida' ?>)
                </div>
            </td>

            <td><?= $h['cidade'] ?></td>

            <td>
                <span class="btn-status">
                    <?= $h['status'] ?>
                </span>
            </td>

            <td>
                <?php if ($h['acao'] === 'criado'): ?>
                    <span class="success">Criado</span>

                <?php elseif ($h['acao'] === 'editado'): ?>
                    <span class="btn-editado" >Editado</span>

                <?php else: ?>
                    <span class="alert--danger">Excluído</span>
                <?php endif; ?>
            </td>

            <td class="small muted">
                <?= $h['data_acao'] ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>