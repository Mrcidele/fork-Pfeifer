<h1>Viações</h1>

<p class="mb-20">
    <a href="/viacoes/create" class="btn btn-success">
        Nova Viação
    </a>
</p>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Cidade</th>
        <th>Status</th>
        <th width="220">Ações</th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($viacoes as $v): ?>

        <tr>
            <td><?= $v['id'] ?></td>

            <td><?= $v['nome'] ?></td>

            <td><?= $v['cidade'] ?></td>

            <td><?= $v['status'] ?></td>

            <td>
                <div class="actions">

                    <a
                            href="/viacoes/edit?id=<?= $v['id'] ?>"
                            class="btn btn-primary"
                    >
                        Editar
                    </a>

                    <a
                            href="/viacoes/delete?id=<?= $v['id'] ?>"
                            class="btn btn-danger"
                            onclick="return confirm('Deseja excluir esta viação?')"
                    >
                        Excluir
                    </a>

                </div>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
