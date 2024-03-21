
# Buzzvel Test

Test project for mid-level software engineer job

## Description
You are required to create a RESTful API using Laravel to manage holiday plans for
the year 2024.
The API should allow users to perform CRUD operations (Create, Read, Update,
Delete) on holiday plans.

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
