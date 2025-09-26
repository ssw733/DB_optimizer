FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt update && apt install -y \
    libpq-dev \
    git \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN git clone https://github.com/ssw733/DB_optimizer.git && \
    cd DB_optimizer && \
    composer i && \
    php artisan migrate

EXPOSE 9000

CMD ["php-fpm"]
