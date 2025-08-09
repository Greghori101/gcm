#!/bin/bash

# GCM Deployment Script for Coolify/Docker

echo "🚀 Starting GCM deployment..."

# Copy production environment file
if [ ! -f .env ]; then
    echo "📝 Creating .env file from production template..."
    cp .env.production .env
    echo "⚠️  Please update .env with your actual values before running the application!"
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    docker-compose exec app php artisan key:generate --force
fi

# Run migrations
echo "🗄️  Running database migrations..."
docker-compose exec app php artisan migrate --force

# Optimize Laravel
echo "⚡ Optimizing Laravel application..."
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Create storage symlink
echo "🔗 Creating storage symlink..."
docker-compose exec app php artisan storage:link

# Set proper permissions
echo "🔐 Setting file permissions..."
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache

echo "✅ Deployment completed successfully!"
echo "🌐 Your application should be available at http://localhost"
echo ""
echo "📋 Next steps:"
echo "1. Update .env file with your actual database and mail credentials"
echo "2. Run: docker-compose restart"
echo "3. Seed your database if needed: docker-compose exec app php artisan db:seed"
