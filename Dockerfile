
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx git unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql bcmath intl zip \
    && apt-get clean

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 3000

CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php-fpm -D && nginx -g 'daemon off;'"]
