FROM richarvey/nginx-php-fpm:8.3

# Set working directory
WORKDIR /var/www/html

# Image config
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install Composer dependencies
# Use --ignore-platform-reqs as previously determined for build issues
# Use -vvv for verbose output if still debugging composer issues
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs -vvv

# Copy the rest of the application code
COPY . .

# Ensure storage and bootstrap/cache permissions
# This should happen after all code is copied
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Run Laravel artisan commands
# These are typically run once during build for optimization
# Use the commands from 00-laravel-deploy.sh
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan migrate --force

# Note: The richarvey/nginx-php-fpm image automatically starts Nginx and PHP-FPM
# The `CMD ["/start.sh"]` from the base image is suitable.
# The 00-laravel-deploy.sh script is no longer run directly by Dockerfile RUN.
# If parts of it still need to run at container startup, they should be integrated
# with the base image's entrypoint mechanism, possibly by placing it in a specific
# directory that /start.sh monitors. For now, moving build-time steps to RUN.