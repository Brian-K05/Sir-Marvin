#!/bin/sh

# Wait for database to be ready
echo "Waiting for database connection..."
sleep 3

# Run migrations (will show error if database connection fails)
echo "Running database migrations..."
php artisan migrate --force

# Run seeders (creates admin account and services)
echo "Seeding database..."
php artisan db:seed --force

# Create storage link if it doesn't exist
php artisan storage:link || true

# Clear caches
echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Start the Laravel server
echo "Starting Laravel server on port ${PORT:-8080}..."
exec php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=${PORT:-8080}

