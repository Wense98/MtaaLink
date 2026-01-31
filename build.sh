#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

npm install
npm run build

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
