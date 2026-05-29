# PHP Task App — Fork por Caio

---

## Alterações deste fork

Este fork adiciona as seguintes funcionalidades ao projeto original:

- **CRUD completo de Usuários** — criação, edição, listagem, visualização e remoção
- **Soft delete** em usuários e viações — registros são marcados como deletados, sem remoção física do banco
- **Restauração de registros** — registros com soft delete podem ser restaurados pela interface
- **Tabela unificada de histórico** — uma única tabela `historico` registra todas as alterações de viações e usuários
- **Visualização individual** — além das listagens, é possível visualizar uma única viação ou um único usuário com todos os seus detalhes
- **Histórico por registro** — a tela de visualização de um registro exibe o histórico completo de alterações daquele item
- **Paginação e filtragem** nas listagens de viações e de usuários

---

## Como rodar

1. Suba os containers:

```bash
cd ~/Downloads/fork-Pfeifer
docker compose up --build
```

> Na inicialização do container `app`, o Composer gera `vendor/autoload.php` automaticamente.

2. Acesse:

- http://localhost:8081/viacoes/home

3. Para parar:

```bash
docker compose down
```

---

## Rotas

### Públicas

| Método | Rota | Descrição |
|--------|------|-----------|
| `GET` | `/viacoes/home` | Página inicial |
| `GET` | `/viacoes/login` | Tela visual de login |
| `GET` | `/login` | Formulário de autenticação |
| `POST` | `/login` | Autentica usuário |

---

### CRUD de Viações

| Método | Rota | Descrição |
|--------|------|-----------|
| `GET` | `/viacoes` | Listagem de viações (com paginação e filtros) |
| `GET` | `/viacoes/show?id={id}` | Visualiza uma única viação com histórico |
| `GET` | `/viacoes/create` | Formulário de criação |
| `POST` | `/viacoes/store` | Cria uma nova viação |
| `GET` | `/viacoes/edit?id={id}` | Formulário de edição |
| `POST` | `/viacoes/update` | Atualiza uma viação |
| `GET` | `/viacoes/delete?id={id}` | Soft delete de uma viação |
| `GET` | `/viacoes/restore?id={id}` | Restaura uma viação deletada |
| `GET` | `/viacoes/historico` | Histórico geral de alterações |

---

### CRUD de Usuários *(novo neste fork)*

| Método | Rota | Descrição |
|--------|------|-----------|
| `GET` | `/usuarios` | Listagem de usuários (com paginação e filtros) |
| `GET` | `/usuarios/show?id={id}` | Visualiza um único usuário com histórico |
| `GET` | `/usuarios/create` | Formulário de criação |
| `POST` | `/usuarios/store` | Cria um novo usuário |
| `GET` | `/usuarios/edit?id={id}` | Formulário de edição |
| `POST` | `/usuarios/update` | Atualiza um usuário |
| `GET` | `/usuarios/delete?id={id}` | Soft delete de um usuário |
| `GET` | `/usuarios/restore?id={id}` | Restaura um usuário deletado |

---

## Fluxo principal

```
GET /
 ↓
ViacaoController / UsuarioController
 ↓
ViacaoService / UsuarioService
 ↓
ViacaoRepository / UsuarioRepository
 ↓
View::render()
```

---

## Banco de dados

O MySQL é iniciado via Docker Compose. As tabelas são criadas automaticamente no primeiro start pelo arquivo `src/database/init.sql`.

### Tabelas

#### `viacoes`

| Coluna | Tipo | Descrição |
|--------|------|-----------|
| `id` | INT PK | Identificador |
| `nome` | VARCHAR | Nome da viação |
| `...` | ... | Outros campos |
| `deleted_at` | TIMESTAMP NULL | Soft delete — nulo se ativo |

#### `usuarios`

| Coluna | Tipo | Descrição |
|--------|------|-----------|
| `id` | INT PK | Identificador |
| `nome` | VARCHAR | Nome do usuário |
| `email` | VARCHAR | E-mail |
| `...` | ... | Outros campos |
| `deleted_at` | TIMESTAMP NULL | Soft delete — nulo se ativo |

#### `historico` *(tabela unificada — novo neste fork)*

Tabela única que registra todas as alterações de viações e usuários.

| Coluna | Tipo | Descrição |
|--------|------|-----------|
| `id` | INT PK | Identificador |
| `entidade` | VARCHAR | Tipo do registro (`viacao` ou `usuario`) |
| `entidade_id` | INT | ID do registro alterado |
| `acao` | VARCHAR | Ação realizada (`criar`, `editar`, `deletar`, `restaurar`) |
| `dados_anteriores` | JSON NULL | Estado antes da alteração |
| `dados_novos` | JSON NULL | Estado após a alteração |
| `criado_em` | TIMESTAMP | Data e hora da alteração |

---

## Reset completo do banco

Para recriar o banco do zero (apaga todos os dados):

```bash
docker compose down -v
docker compose up --build -d
```

Ou, descomentando os `DROP TABLE` dentro de `src/database/init.sql`:

```sql
DROP TABLE IF EXISTS historico;
DROP TABLE IF EXISTS viacoes;
DROP TABLE IF EXISTS usuarios;
```

> ⚠️ **Atenção:** isso apaga todos os dados permanentemente.

---

## Após mudanças de namespace ou estrutura

```bash
composer dump-autoload --working-dir=.
```

---

## Sobre o `init.sql`

O arquivo `src/database/init.sql` é mapeado para `docker-entrypoint-initdb.d` e executado pelo MySQL na primeira criação do container.

Atualmente contém apenas `SELECT` para visualização das tabelas (útil para debug via cliente SQL) — os `DROP TABLE` estão comentados por segurança.