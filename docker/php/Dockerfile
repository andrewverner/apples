FROM php:8.2-fpm-alpine

RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app