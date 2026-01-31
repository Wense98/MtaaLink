#!/usr/bin/env bash
# entrypoint.sh

# Ensure storage and cache are writable at runtime
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Use stderr for logging to avoid permission issues with files
export LOG_CHANNEL=stderr

# Run migrations (Force it and don't stop if it errors)
php artisan migrate --force || true

# Clear and Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
echo "MtaaLink is ready..."
exec apache2-foreground


