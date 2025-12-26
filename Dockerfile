FROM richarvey/nginx-php-fpm:1.7.2
COPY . .
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

# Copy and run the deployment script
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh
RUN /usr/local/bin/00-laravel-deploy.sh
# Optionally remove the script after it's run
RUN rm /usr/local/bin/00-laravel-deploy.sh

CMD ["/start.sh"]
