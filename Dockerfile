FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libonig-dev \
    && docker-php-ext-install pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p storage/framework/{sessions,views,cache}
RUN chmod -R 775 storage bootstrap/cache

# Lancer le serveur intégré Laravel
EXPOSE 8080
CMD php artisan serve --host 0.0.0.0 --port 8080
