FROM dunglas/frankenphp

# Install Laravel extensions
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache

WORKDIR /app

# Copy your code
COPY . .

# Install dependencies (You can still use multi-stage if you prefer, 
# but for simplicity, you can do it here if you have composer installed)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80"]
