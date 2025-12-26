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

# 1. Install PHP Extensions
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    bcmath

# 2. Copy Application Code
COPY . .
COPY --from=composer /app/vendor /app/vendor
COPY --from=node /app/public/build /app/public/build

# 3. Render-Specific Configuration
# Render uses port 10000 by default.
# We set SERVER_NAME to :10000 to tell FrankenPHP to listen there.
ENV SERVER_NAME=":10000"
ENV DOCUMENT_ROOT="/app/public"

# 4. Permissions
RUN chmod -R 777 storage bootstrap/cache

# 5. Production Optimizations
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN php artisan package:discover --ansi

# 6. Start Command
# We rely on the default entrypoint but override the command.
# EXPOSE helps Render detect the port automatically.
EXPOSE 10000

CMD ["frankenphp", "php-server"]
