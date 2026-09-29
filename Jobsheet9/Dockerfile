FROM php:8.2-cli

# Instal driver PostgreSQL untuk PHP
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql

# Set direktori kerja
WORKDIR /app

# Copy seluruh file proyek ke /app
COPY . .

# Jalankan server bawaan PHP di port 8080 (tanpa butuh akses root Apache)
CMD ["php", "-S", "0.0.0.0:80"]