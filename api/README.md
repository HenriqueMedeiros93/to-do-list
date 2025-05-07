## Tecnologias Utilizadas

- **Laravel**: Framework PHP.
- **MySQL**: Banco de dados relacional.
- **Eloquent ORM**: Para interação com o banco de dados.
- **DTO (Data Transfer Objects)**: Para estruturar e validar os dados de entrada e saída.
- **Repository Pattern**: Para separar as lógicas de acesso aos dados.

---

## Instalação

### Passo 1: Clonar o Repositório

Clone o repositório para sua máquina local:

```bash
git clone https://github.com/seu-usuario/todolist-laravel.git

```
### Passo 2: Instalar Dependências do Composer

```bash
cd todolist-laravel
composer install

```

### Passo 3: Configurar o Arquivo .env

```bash
cp .env.example .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=

```
### Passo 4: Gerar a Chave da Aplicação

```bash
php artisan key:generate

```
### Passo 4: Gerar a Chave da Aplicação

```bash
cd todolist-laravel
composer install

```
### Passo 5: Rodar as Migrations

Este comando irá **criar as tabelas** no banco de dados conforme definido nas migrations:
```bash
php artisan migrate
```
Este comando irá **criar exemplos** no banco de dados:
```bash
php artisan db:seed
```

### Passo 6: Instalar o Xdebug (opcional)

Acesse a documentação oficial do Xdebug e baixe a versão adequada para seu sistema operacional:

- [Documentação do Xdebug](https://xdebug.org/docs/)
- [Download do Xdebug](https://xdebug.org/download)

### Passo 7: Gerar a Documentação Swagger

```bash
php artisan swagger:generate

```
### Passo 8: Rodando o Servidor

```bash
php artisan serve
```