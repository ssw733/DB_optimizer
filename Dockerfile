FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt update && apt install -y libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

RUN composer install 
#--no-dev --optimize-autoloader

EXPOSE 9000

CMD ["php-fpm"]
