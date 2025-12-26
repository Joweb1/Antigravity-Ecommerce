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

# Set the folder where index.php lives
ENV COMPOSER_HOME="/tmp"
ENV SERVER_NAME=":80"
ENV DOCUMENT_ROOT="./public"

# Use the default FrankenPHP server command instead of Octane
ENTRYPOINT ["frankenphp", "php-server"]
