# Tabela de viações (crud)

Projeto de Matheus Pfeifer.

## Como rodar

1. Suba os containers:

```bash
cd ~/Downloads/php-task-app-main
docker compose up --build
```

Na inicializacao do container `app`, o Composer gera `vendor/autoload.php` automaticamente.

2. Acesse:

- http://localhost:8081/viacoes/home#

3. Para parar:

```bash
docker compose down
```

## Rotas

### Públicas

- `GET /viacoes/home` → página inicial
- `GET /viacoes/login` → tela visual de login
- `GET /login` → formulário de autenticação
- `POST /login` → autentica usuário

---

### CRUD de Viações

- `GET /viacoes/create` → formulário de criação
- `POST /viacoes/store` → cria uma nova viação
- `GET /viacoes/edit?id={id}` → formulário de edição
- `POST /viacoes/update` → atualiza uma viação
- `GET /viacoes/delete?id={id}` → remove uma viação
- `GET /viacoes/historico` → histórico de alterações

---

### Fluxo principal

```txt
GET /
 ↓
ViacaoController
 ↓
ViacaoService
 ↓
ViacaoRepository
 ↓
View::render()

## Banco de dados

- O MySQL é iniciado via Docker Compose.
- A tabela `viacoes` é criada automaticamente no primeiro start pelo `src/database/init.sql`.

Reset completo (recria banco e dados seed):

```bash
docker compose down -v
docker compose up --build -d
```

Apos mudancas de namespace/estrutura, rode:

```bash
composer dump-autoload --working-dir=.
```

---

## init.sql

O arquivo `src/database/init.sql` é mapeado para `docker-entrypoint-initdb.d`
e executado pelo MySQL na primeira criação do container.

Atualmente contém apenas `SELECT` para visualização das tabelas (útil para
debug via cliente SQL) e os `DROP TABLE` estão comentados.

Para forçar um reset completo do banco, descomente os `DROP TABLE` e recrie
o volume:

```sql
DROP TABLE IF EXISTS viacoes;
DROP TABLE IF EXISTS historico_viacoes;
DROP TABLE IF EXISTS usuarios;
```
> **Atenção:** isso apaga todos os dados do banco permanentemente.

```bash
docker compose down -v
docker compose up --build
```