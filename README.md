#  To-Do List

Este é um projeto fullstack completo de uma lista de tarefas, dividido em duas partes principais:

- `frontend/`: Interface do usuário feita com Vue 3.
- `api/`: API desenvolvida com Laravel.

---

## 🚀 Como executar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/HenriqueMedeiros93/to-do-list.git
cd to-do-list
```

---

## Frontend (Vue 3)

### Instalação e Execução

```bash
cd frontend
npm install
npm run dev
```
## Backend (Laravel)

### Tecnologias Utilizadas

- **Laravel**: Framework PHP.
- **MySQL**: Banco de dados relacional.
- **Eloquent ORM**: Para interação com o banco de dados.
- **DTO (Data Transfer Objects)**: Para estruturar e validar os dados de entrada e saída.
- **Repository Pattern**: Para separar as lógicas de acesso aos dados.

### Instalação

#### Passo 1: Instalar Dependências

```bash
cd api
composer install
```

#### Passo 2: Configurar o Arquivo `.env`

```bash
cp .env.example .env
```

Edite as variáveis de ambiente no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=
```

#### Passo 3: Gerar a chave da aplicação

```bash
php artisan key:generate
```

#### Passo 4: Rodar as Migrations e Seeds

```bash
php artisan migrate
php artisan db:seed
```

#### Passo 5 (Opcional): Instalar Xdebug

Acesse: https://xdebug.org/docs/

#### Passo 6: Gerar Documentação Swagger

```bash
php artisan swagger:generate
```

#### Passo 7: Rodar o Servidor

```bash
php artisan serve
```

A API estará disponível em `http://localhost:8000` (por padrão).

---

## 📈Escalabilidade

- **Separação de responsabilidades** em camadas: API e frontend funcionam separadamente e podem ser escaladas de forma independente.
- **Componentização no Frontend** com Vue 3, facilitando manutenção e reuso de código.
- **Repository Pattern no Backend**, separando a lógica de dados da lógica de negócio.
- **Padronização RESTful**, permitindo integração com outros sistemas no futuro.
- Uso de **DTOs e validações**, garantindo consistência e clareza nos dados.

---

## Principio SOLID

## Princípios de Design e Arquitetura

Este projeto foi desenvolvido aplicando o **Princípio da Responsabilidade Única (SRP)**, que afirma que "uma classe (ou módulo, função, componente) deve ter apenas uma razão para mudar". Essa abordagem resulta em um sistema modular, facilitando a manutenção, os testes e a escalabilidade.

### Frontend (Vue 3)

A arquitetura do frontend em Vue 3 é baseada em componentes especializados:

* **`TaskModal.vue`**: Dedicado exclusivamente ao gerenciamento da criação e edição de tarefas, incluindo o formulário, a validação e a apresentação do modal.
* **`TaskTable.vue`**: Responsável unicamente pela listagem das tarefas e pela emissão de eventos para ações como edição e exclusão.
* **`SideBar.vue`**: Lida apenas com os filtros e ações auxiliares da interface.
* **Pinia Store**: Centraliza o estado global da aplicação, isolando a lógica de dados dos componentes da interface do usuário.

Essa separação de responsabilidades permite que alterações em uma parte do frontend tenham um impacto mínimo nas outras, simplificando a evolução da interface.

### Backend (Laravel)

A arquitetura do backend em Laravel segue os seguintes padrões:

* **Controllers**: Encarregados de receber as requisições HTTP e de orquestrar o fluxo de dados, tanto na entrada quanto na resposta.
* **DTOs (Data Transfer Objects)**: Responsáveis por encapsular os dados esperados nas requisições e respostas, evitando a mistura de lógica e simplificando as validações.
* **Repositórios**: Dedicados exclusivamente ao acesso à camada de dados (banco de dados), utilizando o Eloquent ou queries específicas, o que mantém os controllers mais limpos.
* **Services (se aplicável)**: Contêm as regras de negócio que não se encaixam diretamente nem nos controllers nem nos repositórios.

Essa arquitetura promove um **baixo acoplamento** e uma **alta coesão**, dois princípios fundamentais para a construção de aplicações escaláveis e de fácil manutenção.

---

