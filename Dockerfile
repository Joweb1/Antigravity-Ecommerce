# -----------------------------------------
# Stage 1: Build Backend (Composer)
# -----------------------------------------
FROM composer:2.7 as composer
WORKDIR /app
COPY composer.json composer.lock ./
# Install deps, ignore platform reqs to prevent PHP version errors during build
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs

# -----------------------------------------
# Stage 2: Build Frontend (Node.js)
# -----------------------------------------
FROM node:20 as node
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# -----------------------------------------
# Stage 3: Production Server (Apache)
# -----------------------------------------
FROM php:8.3-apache

WORKDIR /var/www/html

# 1. Install System Dependencies & PHP Extensions
# We use the official extension installer script for reliability
ADD https://github.com/mlocati/docker-php-extension-installer/releases/download/2.2.0/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd mbstring xml zip pdo_mysql bcmath intl opcache

# 2. Apache Configuration (The Render Fix)
# Enable rewrite module for Laravel routing
RUN a2enmod rewrite

# Change Apache to listen on port 8080 instead of 80 (Fixes "Operation not permitted")
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

# Point Apache to the 'public' folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf.conf

# 3. Copy Application Code
COPY . .

# Copy dependencies from Stage 1 & 2
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=node /app/public/build /var/www/html/public/build

# 4. Permissions
# Give the web server ownership of storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 5. Start Apache
EXPOSE 8080
CMD ["apache2-foreground"]
