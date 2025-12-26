# Stage 1: Build dependencies (Composer)
FROM composer:2.7 as composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs

# Stage 2: Build assets (Node.js)
FROM node:20 as node
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 3: Production Server (FrankenPHP)
FROM dunglas/frankenphp

WORKDIR /app

# Install PHP Extensions
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    bcmath

# Copy Application Code
COPY . .
COPY --from=composer /app/vendor /app/vendor
COPY --from=node /app/public/build /app/public/build

# Configuration
ENV COMPOSER_HOME="/tmp"
ENV SERVER_NAME=":80"
ENV DOCUMENT_ROOT="/app/public"

# Permissions
RUN chmod -R 777 storage bootstrap/cache

# Production Optimizations
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN php artisan package:discover --ansi

# --- THE FIX IS HERE ---
# We use CMD instead of ENTRYPOINT. 
# This preserves the base image's permission setup script.
CMD ["frankenphp", "php-server"]
