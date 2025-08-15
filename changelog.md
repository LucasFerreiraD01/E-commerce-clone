# Changelog

## [0.1.3.1] - 14-08-25

### CHANGED
    - user.php, login.php, login.html, cadastrar.php, cadastro.html foram atualizados com tratamento de erros padronizado utilizando JS
    - cadastro.html agora conta com máscara nos campos de input do usuário

## [0.1.3] - 08-08-25

### ADDED
    - Adicionado o endpoint logout.php, para terminar a sessão do usuário

### CHANGED
    - config.php agora possui as informações para conexão via API
    - login.php e user.php foram atulizados para chamar as requests da API
    - login.html e login.php agora possuem tratamento de erros, com alertas JS

## [0.1.2] - 07-08-25

### CHANGED
    - Método de conexão ao BD: implementado e testado método de conexão através de API através da classe SupabaseClient no database.php;