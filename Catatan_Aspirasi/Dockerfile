# Menggunakan image resmi PHP 8.2 dengan web server Apache
FROM php:8.2-apache

# Menginstal ekstensi mysqli dan pdo_mysql agar bisa terhubung ke database MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Mengaktifkan mod_rewrite Apache (berguna untuk .htaccess Anda)
RUN a2enmod rewrite

# Menyalin semua file proyek ke folder root web server Apache
COPY . /var/www/html/

# Mengatur hak akses agar folder uploads bisa menyimpan file gambar/lampiran
RUN chown -R www-data:www-data /var/www/html/uploads && chmod -R 755 /var/www/html/uploads

# Mengekspos port 80
EXPOSE 80
