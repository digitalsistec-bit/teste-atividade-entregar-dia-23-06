# Documentação dos Testes de Integração

## Aluno
Rafael Felicidade

## Objetivo
Testes de integração para os endpoints da aplicação, cobrindo cenários válidos (operações CRUD), validações de dados inválidos/ausentes, regras de negócio e retorno de códigos HTTP adequados.

## Endpoints e Cenários Testados

### Bibliotecas - 7 testes PASSANDO
- `test_listar_bibliotecas`: listar bibliotecas cadastradas (retorna 200).
- `test_criar_biblioteca_com_dados_validos`: criar nova biblioteca redirecionando para a index (retorna 302).
- `test_criar_biblioteca_sem_nome`: validar que dados inválidos (ausência de nome) impedem a inserção.
- `test_atualizar_biblioteca`: atualizar informações de uma biblioteca existente.
- `test_atualizar_biblioteca_inexistente`: tentar atualizar biblioteca que não existe (retorna 404).
- `test_deletar_biblioteca`: remover biblioteca existente (retorna 302 e remove do banco).
- `test_deletar_biblioteca_inexistente`: tentar remover biblioteca inexistente (retorna 404).

### Autores - 7 testes PASSANDO
- `test_listar_autores`: listar autores cadastrados (retorna 200).
- `test_criar_autor_com_dados_validos`: criar autor com dados corretos (retorna 302).
- `test_criar_autor_sem_nome`: validar que autor sem nome não é cadastrado.
- `test_atualizar_autor`: atualizar informações de um autor existente.
- `test_atualizar_autor_inexistente`: tentar atualizar autor que não existe (retorna 404).
- `test_deletar_autor`: deletar autor existente (retorna 302 e remove do banco).
- `test_deletar_autor_inexistente`: tentar remover autor inexistente (retorna 404).

### Pessoas - 7 testes PASSANDO
- `test_listar_pessoas`: listar pessoas cadastradas (retorna 200).
- `test_criar_pessoa_com_dados_validos`: cadastrar pessoa com sucesso e associar à biblioteca se fornecido.
- `test_criar_pessoa_sem_nome`: validar falha ao cadastrar pessoa sem nome (retorna 302 com erros de sessão).
- `test_atualizar_pessoa`: atualizar informações de pessoa existente.
- `test_atualizar_pessoa_inexistente`: tentar atualizar pessoa que não existe (retorna 404).
- `test_deletar_pessoa`: remover pessoa existente (retorna 302 e remove do banco).
- `test_deletar_pessoa_inexistente`: tentar remover pessoa inexistente (retorna 404).

### Users - 7 testes PASSANDO
- `test_listar_users`: listar usuários cadastrados (retorna 200).
- `test_criar_user_com_dados_validos`: cadastrar usuário com sucesso.
- `test_criar_user_sem_email`: validar falha ao cadastrar usuário sem e-mail (retorna 302 com erros).
- `test_atualizar_user`: atualizar informações de usuário existente.
- `test_atualizar_user_inexistente`: tentar atualizar usuário inexistente (retorna 404).
- `test_deletar_user`: remover usuário do banco com sucesso.
- `test_deletar_user_inexistente`: tentar remover usuário inexistente (retorna 404).

### Livros - 7 testes PASSANDO
- `test_listar_livros`: listar livros cadastrados (retorna 200).
- `test_criar_livro_com_dados_validos`: cadastrar livro com dados corretos e autor associado.
- `test_criar_livro_sem_titulo`: validar falha de cadastro sem título (retorna 302 com erros).
- `test_atualizar_livro`: atualizar informações do livro.
- `test_atualizar_livro_inexistente`: tentar atualizar livro inexistente (retorna 404).
- `test_deletar_livro`: remover livro existente com sucesso.
- `test_deletar_livro_inexistente`: tentar remover livro inexistente (retorna 404).

---

## Bugs Corrigidos na Aplicação

Para obter um comportamento correto da API e da aplicação Web de acordo com o planejado nos testes, realizamos as seguintes correções:

### 1. LivroController
- Adicionada validação de entrada ao método `store()` e `update()` (antes, gerava erro 500 caso o título estivesse ausente).
- Corrigido o carregamento de registros inexistentes usando `findOrFail` no método `edit()`, garantindo o retorno adequado de erro 404.

### 2. AutorController
- Implementado o método `destroy()` para remoção de autores. Antes, o método não estava implementado e gerava erro 500.

### 3. PessoaController
- Adicionada validação de dados em `store()` e `update()`.
- Modificados os métodos `edit()`, `update()` e `destroy()` para utilizar `findOrFail()` garantindo que retorne 404 (Not Found) quando um ID inexistente for consultado, no lugar de redirecionamento 302 ou sucesso vazio.
- Implementado por completo o método `destroy()`, que estava vazio e não deletava o registro.

### 4. UserController
- Adicionada validação de dados em `store()` e `update()`.
- Corrigido o uso de `find()` para `findOrFail()` em `show()`, `edit()`, `update()` e `destroy()`, para que acessos a registros inexistentes resultem no código de status 404 correto ao invés de redirecionamento genérico.

---

## GitHub Actions & Docker Setup

### GitHub Actions
- Arquivo de workflow criado em `.github/workflows/tests.yml` configurado para executar automaticamente o `composer install`, a migração do banco de dados e todos os testes automatizados a cada Pull Request ou Push direcionado para as branches `master` ou `develop`.

### Configuração do Ambiente e Docker
- **Resolução de conflitos de rede:** Ajustamos o arquivo `docker-compose.yml` para remover a configuração de redes estáticas conflitantes, eliminando erros de overlap de subnets (IP Pool overlaps) na máquina host.
- **Instalação do Driver SQLite:** Adicionamos a extensão `php8.4-sqlite3` no `Dockerfile` da aplicação para que o driver necessário estivesse disponível no ambiente do container.
- **Forçar Variáveis de Teste:** Atualizamos o arquivo `phpunit.xml` adicionando a tag `force="true"` em todas as variáveis do `<php>` block, prevenindo que variáveis do sistema (como as do container Docker que rodam como `local` e `mysql`) sobrescrevessem o ambiente de teste, o que causava falhas de segurança (como erro CSRF 419) e persistência acidental no banco principal.

---

## Como executar os testes localmente no Docker
1. Suba os containers:
   ```bash
   docker compose up -d
   ```
2. Execute a suíte de testes:
   ```bash
   docker exec -e APP_ENV=testing app_laravel php artisan test
   ```

## Resultado Final da Suíte
```
Tests:    37 passed (54 assertions)
Duration: 41.54s
```
