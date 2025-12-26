# Stage 1: Composer dependencies
FROM composer:2.7 as composer

WORKDIR /app

ENV COMPOSER_MEMORY_LIMIT=-1
# Use --no-scripts to prevent early execution of Laravel/Composer scripts
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs -vvv --no-scripts

# Stage 2: Node.js dependencies and asset build
FROM node:21 as node

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 3: Production image (Apache)
FROM php:8.3-apache

WORKDIR /var/www/html

# Install the helper script for PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/download/2.2.0/install-php-extensions /usr/local/bin/install-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions

# Install commonly required PHP extensions
RUN install-php-extensions gd mbstring xml zip pdo_sqlite

# Enable Apache's rewrite module
RUN a2enmod rewrite

# Remove default Apache virtual host
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Add custom Apache virtual host for Laravel
COPY docker/apache-laravel.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Copy application code from composer stage
COPY --from=composer /app/vendor /var/www/html/vendor

# Copy application code from node stage
COPY --from=node /app/public /var/www/html/public
COPY --from=node /app/resources /var/www/html/resources
COPY --from=node /app/bootstrap /var/www/html/bootstrap
COPY --from=node /app/app /var/www/html/app
COPY --from=node /app/config /var/www/html/config
COPY --from=node /app/database /var/www/html/database
COPY --from=node /app/routes /var/www/html/routes
COPY --from=node /app/storage /var/www/html/storage
COPY --from=node /app/artisan /var/www/html/artisan
COPY --from=node /app/.env.example /var/www/html/.env.example # Render will use its own .env

# Run Composer and Artisan scripts that were skipped earlier
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative \
    && php artisan optimize:clear \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan config:clear \
    && php artisan event:clear \
    && php artisan package:discover --ansi --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expose port 80 for Apache
EXPOSE 80