FROM composer:latest AS composer
FROM php:7.4-apache
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y git zip unzip mariadb-client \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

#configure apache2
RUN a2enmod rewrite
COPY docker/app/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/app/php_custom.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www

COPY symfony/ /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1