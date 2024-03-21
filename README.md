
# Buzzvel Test

Test project for mid-level software engineer job

## Description
You are required to create a RESTful API using Laravel to manage holiday plans for
the year 2024.
The API should allow users to perform CRUD operations (Create, Read, Update,
Delete) on holiday plans.

# Dependecies
    composer require laravellegends/pt-br-validator


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
Create database entries to test

```
  php artisan db:seed 
```
Run server

```
  php artisan serve
```

To run unit teste
```
   vendor/bin/phpunit
```

## Run project

To run this project you will need to create access token with `/api/V1/login` endpoint after use ``php artisan db:seed`` (NOTE: If you run the unit test the database will be deleted so you will need to run the command ``php artisan db:seed`` again )


## API Documentation
```
   http://127.0.0.1:8000/api/documentation
```
