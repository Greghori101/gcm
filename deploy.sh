#!/bin/bash
set -e

# Ensure required directories exist
mkdir -p /var/www/html/storage/framework/{cache,sessions,views}
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/bootstrap/cache

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if missing
if [ -z "$(grep '^APP_KEY=' .env | grep -v '=$')" ]; then
    echo "Generating Laravel APP_KEY..."
    php artisan key:generate
fi

# Wait for database if DB_HOST is set
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database connection at $DB_HOST..."
    until nc -z -v -w30 $DB_HOST 3306; do
        echo "Database not ready. Retrying in 5 seconds..."
        sleep 5
    done
    echo "Database connected."

    # Run migrations
    php artisan migrate --force
fi

# Execute container command (default: php-fpm)
exec "$@"
