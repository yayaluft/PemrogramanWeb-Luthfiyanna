FROM php:8.2-apache

# Install modul driver PostgreSQL untuk PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copy seluruh kodingan ke direktori Apache
COPY . /var/www/html/

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

EXPOSE 80