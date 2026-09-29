FROM php:8.2-apache

RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf

# Install modul driver PostgreSQL untuk PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copy seluruh kodingan ke direktori Apache
COPY . /var/www/html/

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

EXPOSE 8080