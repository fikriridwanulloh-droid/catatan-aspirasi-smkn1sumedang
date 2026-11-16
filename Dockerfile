FROM php:8.2-apache

# Mengaktifkan ekstensi database MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Menyalin seluruh file proyek ke folder web server Apache
COPY . /var/www/html/

# Mengatur hak akses folder
RUN chown -R www-data:www-data /var/www/html
