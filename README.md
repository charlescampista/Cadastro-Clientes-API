# Laravel 12 - API de Clientes (Bearer token)

## Requisitos
- PHP 8.2+ (compatível com Laravel 12)
- MySQL

## Instalação local (passos)
1. Clonar o repositório:
   ````
    https://github.com/charlescampista/Cadastro-Clientes-API.git
   ````
2. Abrir a pasta do projeto
    ````
    cd laravel-api
    ````

3. Instalar as dependências do projeto *(Você precisa ter o composer instalado na sua máquina)*
    ````
    composer install
    ````

4. Criar o arquivo `.env`. É uma cópia de `.env.example` que armazena as variáveis de ambiente:
    ````
    DB_DATABASE=<o nome do seu banco de dados>
    DB_USERNAME=<seu usuário do banco de dados>
    DB_PASSWORD=<sua senha do banco de dados>
    ````

5. Gere a chave da aplicação:
   ````
   php artisan key:generate
   ````

6. Criar o banco de dados MySQL. 
    ````
    CREATE DATABASE <o nome do seu banco de dados aqui>;
    ````

    
7. Rodar as migrações e seeders *(Isso vai criar tabelas e popular com usuários e clientes de teste)*
   ````
   php artisan migrate --seed
   ````

8. Executar a aplicação localmente *(A API estará em: http://127.0.0.1:8000)*
   ````
   php artisan serve
   ````
   

9. Testar as requisições com o software de sua preferência.

## Alguns exemplos de requisições com cURL

#### 1. Registrar usuário
````
curl -X POST http://127.0.0.1:8000/api/auth/register \
 -H "Content-Type: application/json" \
 -d '{"name":"John Doe","email":"john@example.com","password":"password"}'

````

#### 2. Login (gera token, válido por 2 horas)
````
curl -X POST http://127.0.0.1:8000/api/auth/login \
 -H "Content-Type: application/json" \
 -d '{"email":"john@example.com","password":"password"}'

```` 
&nbsp;&nbsp;&nbsp; **Resposta do Exemplo *(JSON)***

````
{
  "message": "Autenticado com sucesso",
  "token": "random_generated_token_string_here",
  "expires_at": "2025-09-09 17:10:00"
}

````

#### 3. Criar cliente (protegido — usar token retornado)
````
curl -X POST http://127.0.0.1:8000/api/clients \
 -H "Content-Type: application/json" \
 -H "Authorization: Bearer <COLE_SEU_TOKEN_AQUI>" \
 -d '{"name":"Cliente Exemplo","email":"cliente@ex.com","phone":"1199999-9999","address":"Rua A, 123","city":"Teresópolis","state":"RJ"}'

````

#### 4. Listar clientes (protegido)
````
curl -X GET http://127.0.0.1:8000/api/clients \
 -H "Authorization: Bearer <COLE_SEU_TOKEN_AQUI>"

````

#### 5. Excluir cliente (protegido)
````
curl -X DELETE http://127.0.0.1:8000/api/clients/1 \
 -H "Authorization: Bearer <COLE_SEU_TOKEN_AQUI>"

````

#### 6. Logout (invalida token)
````
curl -X POST http://127.0.0.1:8000/api/auth/logout \
 -H "Authorization: Bearer <COLE_SEU_TOKEN_AQUI>"

````
