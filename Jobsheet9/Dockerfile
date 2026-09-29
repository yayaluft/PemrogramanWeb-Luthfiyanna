FROM php:8.2-apache

# Ambil driver pdo_pgsql yang sudah jadi (tanpa kompilasi lama)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql

# port Apache ke 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf

# Copy kode proyek
COPY . /var/www/html/

# Aktifkan rewrite & expose port
RUN a2enmod rewrite
EXPOSE 8080