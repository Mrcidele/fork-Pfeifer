<h1>Editar Viação</h1>

<form method="POST" action="/viacoes/update">

    <input
            type="hidden"
            name="id"
            value="<?= $viacao['id'] ?>"
    >

    <label>Nome</label>
    <input
            type="text"
            name="nome"
            value="<?= $viacao['nome'] ?>"
            placeholder="Nome da viação"
    >

    <label>URL</label>
    <input
            type="text"
            name="url"
            value="<?= $viacao['url'] ?>"
            placeholder="https://site.com.br"
    >

    <label>Cidade</label>
    <input
            type="text"
            name="cidade"
            value="<?= $viacao['cidade'] ?>"
            placeholder="Cidade"
    >

    <label>Logo</label>
    <input
            type="text"
            name="logo"
            value="<?= $viacao['logo'] ?>"
            placeholder="logo.png"
    >

    <label>Status</label>
    <select name="status">

        <option
                value="ativo"
                <?= $viacao['status'] == 'ativo' ? 'selected' : '' ?>
        >
            Ativo
        </option>

        <option
                value="inativo"
                <?= $viacao['status'] == 'inativo' ? 'selected' : '' ?>
        >
            Inativo
        </option>

    </select>

    <div class="actions mt-20">

        <button
                type="submit"
                class="btn btn-primary"
        >
            Salvar Alterações
        </button>

        <a
                href="/viacoes"
                class="btn btn-danger"
        >
            Cancelar
        </a>

    </div>

</form>
