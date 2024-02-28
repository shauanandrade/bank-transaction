#!/bin/bash
cd src/infrastructure/Frames/Lumen
composer install && composer dump-autoload
php artisan migrate && php -S 0.0.0.0:8000 -t public
