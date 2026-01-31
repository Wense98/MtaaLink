#!/usr/bin/env bash
# entrypoint.sh

echo "Verifying environment..."
if [ -f "/var/www/html/database/aiven-ca.pem" ]; then
    echo "✅ CA Certificate found."
else
    echo "❌ CA Certificate MISSING at /var/www/html/database/aiven-ca.pem"
fi

# Ensure storage and cache are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run migrations (Wait a bit for Aiven to be ready)
echo "Waiting for database connection..."
sleep 5
php artisan migrate --force || echo "⚠️ Migration failed, but continuing..."

# Clear and Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 MtaaLink is ready..."
exec apache2-foreground



