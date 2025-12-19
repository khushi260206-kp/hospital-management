#!/bin/bash
set -e

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "Caching configuration..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Build completed successfully!"

