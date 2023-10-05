FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /var/www/html/

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . .

RUN composer install
