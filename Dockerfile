# Dockerfile para o PHP-FPM com extensão PostgreSQL
FROM php:8.3-fpm

# Instala as dependências necessárias e o driver pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html/public
