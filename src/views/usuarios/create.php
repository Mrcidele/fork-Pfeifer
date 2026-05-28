<div class="container-form">
    <div class="container-form-botoes">
        <h1>Novo Usuário</h1>
        <div class="container-form-botoes-lado">
            <p class="mb-20">
                <a href="/usuarios" class="btn btn-secondary">&larr; Voltar</a>
            </p>
        </div>
    </div>

    <form method="POST" action="/usuarios/store" class="filter-form" style="flex-direction: column; align-items: flex-start;">
        <div style="margin-bottom: 15px; width: 100%;">
            <label for="nome" style="font-weight: bold; display: block; margin-bottom: 5px;">Nome Completo</label>
            <input type="text" name="nome" id="nome" class="filter-input" style="width: 100%; max-width: 500px;" required>
        </div>

        <div style="margin-bottom: 15px; width: 100%;">
            <label for="email" style="font-weight: bold; display: block; margin-bottom: 5px;">E-mail</label>
            <input type="email" name="email" id="email" class="filter-input" style="width: 100%; max-width: 500px;" required>
        </div>

        <div style="margin-bottom: 20px; width: 100%;">
            <label for="senha" style="font-weight: bold; display: block; margin-bottom: 5px;">Senha</label>
            <input type="password" name="senha" id="senha" class="filter-input" style="width: 100%; max-width: 500px;" required>
        </div>

        <div>
            <button type="submit" class="btn btn-success">Salvar Usuário</button>
        </div>
    </form>
</div>