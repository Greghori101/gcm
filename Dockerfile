FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libicu-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql zip gd intl exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer binary from official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copy application files
COPY . .

# Install PHP dependencies (no dev, no scripts for production)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Build frontend assets
RUN npm install && npm run build

# Cache Laravel config and routes
RUN php artisan config:clear && php artisan config:cache && php artisan route:cache

# Fix storage and bootstrap/cache permissions
RUN mkdir -p storage/framework/{cache,sessions,views} storage/app/public bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose FPM port
EXPOSE 8080

# Set entrypoint and default command
ENTRYPOINT ["deploy.sh"]
CMD ["php-fpm"]
