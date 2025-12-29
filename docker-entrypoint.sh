#!/bin/sh

# Wait for database to be ready (optional, but recommended)
echo "Waiting for database connection..."
sleep 2

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Run seeders (creates admin account and services)
echo "Seeding database..."
php artisan db:seed --force

# Create storage link if it doesn't exist
php artisan storage:link || true

# Start the Laravel server
echo "Starting Laravel server..."
exec php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=${PORT:-8080}

