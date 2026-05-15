<div class="container-form-add-edit">
<form method="POST" action="/viacoes/store" enctype="multipart/form-data">
    <h1>Nova Viação</h1>
    <label>Nome</label>
    <input
            type="text"
            name="nome"
            placeholder="Nome da viação"
            required>

    <label>URL</label>
    <input
            type="text"
            name="url"
            placeholder="https://site.com.br">

    <label>Cidade</label>
    <input
            type="text"
            name="cidade"
            placeholder="Cidade">

    <label>Logo atual</label><br>

    <img src="/uploads/<?= $viacao['logo'] ?>" width="100">

    <br><br>

    <input type="file" name="logo">

    <label>Status</label>
    <select name="status">

        <option value="0">
            Ativo
        </option>

        <option value="1">
            Inativo
        </option>

    </select>

    <div class="actions mt-20">

        <button
                type="submit"
                class="btn btn-success"
        >
            Salvar
        </button>

        <a
                href="/viacoes"
                class="btn btn-danger"
        >
            Cancelar
        </a>

    </div>

</form>
    <div/>