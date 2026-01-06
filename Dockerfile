# Gunakan PHP 8.2 dengan Apache
FROM php:8.2-apache

# 1. Install dependency sistem (termasuk library ZIP dan Node.js untuk CSS)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql bcmath zip

# --- TAMBAHAN BARU: INSTALL NODE.JS ---
# Kita butuh Node.js untuk compile CSS (Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 2. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 3. Setting folder kerja
WORKDIR /var/www/html

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copy Semua File Project
COPY . .

# 6. Install Library PHP (Composer)
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# --- TAMBAHAN BARU: BUILD CSS/JS (VITE) ---
# Jalankan npm install dan npm run build agar file CSS jadi
RUN npm install && npm run build

# 7. Atur Permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Atur Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 9. Buka port
EXPOSE 80