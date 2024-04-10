# Một số lệnh chạy

```shell
php artisan migrate:refresh
php artisan db:seed
php artisan migrate
php artisan make:controller StudentController --resource
php artisan make:migration create_persons_table --create=persons
php artisan make:factory StudentFactory --model=Student
php artisan make:factory PersonFactory --model=Person
php artisan make:controller PersonController
```

# Lệnh chạy swagger
```shell
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
```