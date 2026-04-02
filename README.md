# Rock Commerce API

API de catálogo de produtos desenvolvida em Laravel, com autenticação via Sanctum e organização baseada em DDD + Clean Architecture.

Este projeto foi construído como backend. O frontend será desenvolvido separadamente em React, consumindo esta API.

Documentação:
[http://localhost/docs/api](http://localhost/docs/api)

---

## Tecnologias

- PHP
- Laravel
- Laravel Sanctum
- Laravel Sail
- MySQL
- Docker
- PHPUnit
- Swagger

---

## Funcionalidades

- Cadastro de usuário
- Login com geração de token
- Logout
- Usuário autenticado
- Listagem de categorias
- Listagem paginada de produtos
- Filtro de produtos por categoria
- Busca de produtos por nome ou descrição
- Detalhes de um produto

---

## Estrutura do projeto

```
app/
├── Http/
├── Models/
└── src/
    ├── Auth/
    └── Catalog/
```

A regra de negócio fica em `app/src`, separada por domínio.

- `Auth`: autenticação e usuário autenticado
- `Catalog`: categorias e produtos

---

## Ambiente de desenvolvimento

Para desenvolvimento, o projeto deve ser executado com **Laravel Sail**.

### Requisitos

- Docker
- Docker Compose

### Instalação

Clone o projeto:

```sh
git clone <url-do-repositorio>
cd rock-commerce-fmr
```

Copie o arquivo de ambiente:

```sh
cp .env.example .env
```

Suba os containers:

```sh
docker-compose up
```

A aplicação ficará disponível em:

```text
http://localhost:8000
```

A documentação aplicação ficará disponível em:

```text
http://localhost:8000/docs/api
```

---

## Ambiente de produção

Para produção, a recomendação é usar:

- Nginx
- PHP-FPM
- MySQL
- Supervisor, systemd ou outro gerenciador de processos, se necessário
- HTTPS com certificado válido

### Estrutura recomendada

- **Nginx** servindo a aplicação
- **PHP-FPM** processando o Laravel
- **MySQL** como banco de dados
- aplicação apontando para a pasta `public/`

### Passos gerais

Clone o projeto no servidor:

```sh
git clone <url-do-repositorio>
cd rock-commerce-fmr
```

Instale as dependências sem pacote de desenvolvimento:

```sh
composer install --no-dev --optimize-autoloader
```

Copie e configure o `.env` de produção:

```sh
cp .env.example .env
```

Gere a chave da aplicação:

```sh
php artisan key:generate
```

Rode as migrations:

```sh
php artisan migrate --force
```

Otimize caches do Laravel:

```sh
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Ajuste permissões de escrita para:

- `storage/`
- `bootstrap/cache/`

Exemplo:

```sh
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Exemplo de configuração Nginx

```
server {
    listen 80;
    server_name seu-dominio.com;
    root /var/www/rock-commerce/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

> Ajuste a versão do PHP-FPM conforme o servidor.

### Observações para produção

- nunca use `APP_DEBUG=true`
- use HTTPS
- use banco de dados real de produção
- use fila, cache e logs de forma adequada ao ambiente
- rode deploys com cuidado ao usar `config:cache` e `route:cache`

---

## Autenticação

A autenticação usa Sanctum com Bearer Token.

Exemplo de header:

```http
Authorization: Bearer {token}
```

---

## Endpoints principais

### Auth

- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/auth/me`
- `POST /api/auth/logout`

### Categories

- `GET /api/categories`

### Products

- `GET /api/products`
- `GET /api/products/{id}`

Filtros suportados em `/api/products`:

- `category`
- `search`
- `page`
- `per_page`

---

## Testes

Rodar todos os testes:

```sh
docker-compose exec -e XDEBUG_MODE=coverage backend php artisan test --coverage
```

Com Sail:

```sh
./vendor/bin/sail artisan test
```

Rodar um teste específico:

```sh
php artisan test tests/Feature/Catalog/ShowProductTest.php
```

Com Sail:

```sh
./vendor/bin/sail artisan test tests/Feature/Catalog/ShowProductTest.php
```

---

## Autor .:: Fernando Menezes Rodrigues ::.

Projeto desenvolvido como teste técnico, com foco em organização, clareza arquitetural e boas práticas de backend com Laravel.