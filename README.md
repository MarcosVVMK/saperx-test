
# SaperX Test

Test project for mid-level software engineer job

## Description
Item 01:
Desenvolver uma API de uma AGENDA TELEFÔNICA em PHP ou Laravel, fazendo uso de testes
automatizados capaz de cadastrar os itens abaixo:
```Nome
E-mail
Data de Nascimento
CPF
Telefones
```
``POST localhost/api/V1/phonebook``

Item 02:
A agenda deverá ser capaz de editar todos os campos e excluir um nome previamente cadastrado.

``PUT localhost/api/V1/phonebook/{id}``

``DELETE localhost/api/V1/phonebook/{id}``

Item 03:
Desenvolver um relatório para visualizar os nomes contidos na agenda telefônica

``GET localhost/api/V1/phonebook/{id}``

# Requirements

    PHP 8.3 ( curl, dom, xml mbsting e php-mysql )
    Composer 2
    MySQL 8.0

# Dependecies
    composer require laravellegends/pt-br-validator
    composer require darkaonline/l5-swagger
    composer require zircote/swagger-php


## Installation

Install saperx-test with github

```bash
  git clone git@github.com:MarcosVVMK/saperx-test.git
```
```
  cd saperx-test
```
Install the project composer dependecies
```
  composer install
```

Create database from migration

```
  php artisan migrate
```

Run server

```
  php artisan serve
```

To run tests
```
   php artisan test 
```

## API Documentation
```
   http://127.0.0.1:8000/api/documentation
```
