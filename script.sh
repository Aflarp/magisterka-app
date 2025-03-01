#!/bin/bash

composer install

php artisan migrate:fresh
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan route:cache
php artisan config:cache
php artisan serve --host=0.0.0.0 --port=8000 

#exec docker-php-entrypoint "$@"