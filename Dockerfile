FROM php:8.2-apache

# Instalace závislostí
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalace PHP rozšíření
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Povolení zobrazování chyb v PHP
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-error-reporting.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-error-reporting.ini

# Povolení Apache mod_rewrite
RUN a2enmod rewrite
