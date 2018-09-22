# BiblioTCC

## Configurando ambiente Dev
1. Clonar o projeto
2. Sete as credenciais do banco de dados em `config/parameters.yml` 
3. Crie a database: `bin/console doctrine:database:create`
4. Crie as tabelas: `bin/console doctrine:schema:create`
5. Atualize as tabelas: `bin/console doctrine:schema:update --force`
6. Execute as migrations: `bin/console doctrine:migrations:migrate`
7. Execute as fixures: `bin/console doctrine:fixtures:load` 
8. Instalar assets: `bin/console assets:install`
9. Rode o projeto: `bin/console server:start` ou `bin/console server:run`

Obs: se não funcionar, ajoelha e chora.

