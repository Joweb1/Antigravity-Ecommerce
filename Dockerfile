# Dockerfile
FROM php:8.4-apache

# 1. Install system dependencies and unzip (crucial for unpacking the artifact)
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions
# Using the standard mlocati installer script
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions gd mbstring xml zip pdo_mysql opcache intl

# 3. Configure Apache to allow .htaccess rewrites
RUN a2enmod rewrite

# 4. Setup Working Directory
# We will use /var/www as the base. 
# Apache looks at /var/www/html by default.
WORKDIR /var/www

# 5. Copy the Zipped Project from the build context
# The CI/CD pipeline will place 'release.zip' here
COPY release.zip .

# 6. Unzip and Setup "Shared Hosting" Structure
# We unzip into 'laravel-app' folder, parallel to 'html'
RUN unzip release.zip -d laravel-app && \
    rm release.zip



# 7. Move Public files to Main Directory (Apache Root)
# Clean default html folder
RUN rm -rf html/*
# Move contents of public to html
RUN cp -r laravel-app/public/* html/
# Ensure .htaccess is moved (cp -r usually catches it, but explicit checks are safer)
RUN cp laravel-app/public/.htaccess html/

# 8. Modify index.php to point to the new paths
# We use sed to replace the relative paths to point up one level into 'laravel-app'
WORKDIR /var/www/html

RUN sed -i "s|require __DIR__.'/../vendor/autoload.php';|require __DIR__.'/../laravel-app/vendor/autoload.php';|g" index.php && \
    sed -i "s|\$app = require_once __DIR__.'/../bootstrap/app.php';|\$app = require_once __DIR__.'/../laravel-app/bootstrap/app.php';|g" index.php

# 9. Create Production .env
# NOTE: It is better security practice to use Environment Variables injected by Render.
# However, this creates the file as requested.
RUN echo "APP_ENV=production" > ../laravel-app/.env && \
    echo "APP_DEBUG=false" >> ../laravel-app/.env && \
    echo "APP_URL=https://antigravity-ecommerce-ql94.onrender.com" >> ../laravel-app/.env && \
    echo "LOG_CHANNEL=stderr" >> ../laravel-app/.env

# 10. Permissions and Storage Linking
# Fix permissions for the app code
RUN chown -R www-data:www-data /var/www/laravel-app \
    && chown -R www-data:www-data /var/www/html

# Set directory permissions to 755 and files to 644
RUN find /var/www/laravel-app -type d -exec chmod 755 {} + \
    && find /var/www/laravel-app -type f -exec chmod 644 {} +



# Create public directory for product images and set permissions
RUN mkdir -p /var/www/html/storage/product-images
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 777 /var/www/html/storage

# Also ensure the laravel-side storage is writable for any other operations
RUN chown -R www-data:www-data /var/www/laravel-app/storage /var/www/laravel-app/bootstrap/cache \
    && chmod -R 777 /var/www/laravel-app/storage /var/www/laravel-app/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
