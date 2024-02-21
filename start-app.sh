#!/bin/bash
cd src
composer install
php artisan migrate && php -S 0.0.0.0:8000 -t public
