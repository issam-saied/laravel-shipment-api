FROM php:8.4-fpm

# Install system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy xdebug config
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html
