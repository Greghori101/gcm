#!/bin/bash
set -e

echo "Starting Laravel deployment script..."

# Run migrations safely
if php artisan migrate:status > /dev/null 2>&1; then
  echo "Running database migrations..."
  php artisan migrate --force || echo "Migration skipped (already applied)"
else
  echo "Database connection not ready, skipping migrations"
fi

# Cache configs and routes
php artisan optimize
php artisan filament:optimize || echo "Filament optimize skipped (if not installed)"

echo "Deployment optimization completed."

# Finally, run the default CMD
exec "$@"
