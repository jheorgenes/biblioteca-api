# Biblioteca API

Este projeto é um sistema simples de gerenciamento de biblioteca, desenvolvido com **Laravel 11** e utilizando o banco de dados **MySQL**

---

## Configuração do Ambiente

### **Observação Importante**
Foi publicado o arquivo .env propositalmente, por se tratar de um projeto de teste e pra facilitar o download do mesmo.

### 1 Instalar Dependências do Laravel

```bash
composer install
```

### 2 Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as credenciais do banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=
```

### 3 Gerar Chave da Aplicação (Opcional)

```bash
php artisan key:generate
```

### 4 Executar Migrações

```bash
php artisan migrate
```

### 5 Iniciar o Servidor

```bash
php artisan serve
```

A API estará disponível em: **http://localhost:8000/api/**

---
