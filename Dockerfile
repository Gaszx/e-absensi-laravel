# Gunakan PHP 8.2 dengan Apache
FROM php:8.2-apache

# 1. Install dependency sistem (termasuk zip/unzip yang tadi error)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql bcmath zip

# 2. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 3. Setting folder kerja
WORKDIR /var/www/html

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- PERUBAHAN UTAMA DI SINI ---
# Kita copy SEMUA file project dulu ke dalam Docker
COPY . .

# 5. Baru kita jalankan install
# Kita gabung proses install dan autoloader jadi satu perintah biar tidak error
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# 6. Atur Permission (Agar Laravel bisa nulis file cache/log)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Atur Apache agar baca folder public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 8. Buka port
EXPOSE 80