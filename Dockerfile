# Gunakan PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install kebutuhan sistem (termasuk driver PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql bcmath

# Aktifkan mod_rewrite untuk URL Laravel yang cantik
RUN a2enmod rewrite

# Setting folder kerja
WORKDIR /var/www/html

# Install Composer (Manajer Paket PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy semua file project ke dalam container
COPY . .

# Install library Laravel
RUN composer install --no-dev --optimize-autoloader

# Ubah permission agar bisa upload file/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ubah Document Root Apache ke folder /public (Standar Laravel)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Buka port 80
EXPOSE 80