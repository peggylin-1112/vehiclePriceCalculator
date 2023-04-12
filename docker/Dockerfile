FROM php:8.1-cli
COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

ENTRYPOINT bash
WORKDIR /app