# Stage 1: Build assets and install PHP dependencies
FROM composer:2.7 as composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Stage 2: Install Node.js dependencies and build frontend assets
FROM node:21 as node

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 3: Production image
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Install PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    postgresql-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql zip

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

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy custom Nginx configuration
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy Supervisor configuration
COPY docker/supervisord.conf /etc/supervisord.conf

# Expose port 80 for Nginx
EXPOSE 80

# Start PHP-FPM and Nginx using Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]


