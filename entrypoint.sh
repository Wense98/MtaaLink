#!/usr/bin/env bash
# entrypoint.sh

# Increase memory for migrations
export COMPOSER_MEMORY_LIMIT=-1

# Run migrations (Force it and don't stop if it errors for already existing tables)
php artisan migrate --force || true

# Clear and Cache everything for production
php artisan config:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
echo "MtaaLink is starting..."
exec apache2-foreground

