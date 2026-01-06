# Gunakan PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install dependency sistem yang sering dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql bcmath zip

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Setting folder kerja
WORKDIR /var/www/html

# Copy file composer dulu (agar cache layer Docker bekerja optimal)
COPY composer.json composer.lock ./

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install library Laravel (dengan bendera ignore-platform-reqs agar tidak rewel soal versi PHP minor)
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Copy sisa file project
COPY . .

# Generate key & optimize (jalankan lagi untuk memastikan script berjalan)
RUN composer dump-autoload --optimize

# Ubah permission storage (PENTING: Render butuh ini)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ubah Document Root ke /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Buka port 80
EXPOSE 80