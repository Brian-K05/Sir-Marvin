#!/bin/bash

# Production Deployment Script
# Run this script to prepare your Laravel application for production

echo "=========================================="
echo "Laravel Production Deployment Script"
echo "=========================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found!"
    echo "Please copy .env.example to .env and configure it first."
    exit 1
fi

echo "📋 Step 1: Checking environment configuration..."
if grep -q "APP_DEBUG=true" .env; then
    echo "⚠️  Warning: APP_DEBUG is set to true. Please set it to false for production."
fi

if grep -q "APP_ENV=local" .env; then
    echo "⚠️  Warning: APP_ENV is set to local. Please set it to production."
fi

echo "✅ Environment file found"
echo ""

echo "📋 Step 2: Generating application key (if needed)..."
php artisan key:generate --force
echo "✅ Application key ready"
echo ""

echo "📋 Step 3: Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo "✅ Caches cleared"
echo ""

echo "📋 Step 4: Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Configuration cached"
echo ""

echo "📋 Step 5: Optimizing Composer autoloader..."
composer install --optimize-autoloader --no-dev --quiet
echo "✅ Composer optimized"
echo ""

echo "📋 Step 6: Building assets..."
npm run build
echo "✅ Assets built"
echo ""

echo "📋 Step 7: Setting file permissions..."
if [ -d "storage" ]; then
    chmod -R 775 storage
    echo "✅ Storage permissions set"
fi

if [ -d "bootstrap/cache" ]; then
    chmod -R 775 bootstrap/cache
    echo "✅ Cache permissions set"
fi

if [ -f ".env" ]; then
    chmod 600 .env
    echo "✅ .env permissions secured"
fi
echo ""

echo "📋 Step 8: Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"
echo ""

echo "=========================================="
echo "✅ Deployment preparation complete!"
echo "=========================================="
echo ""
echo "⚠️  IMPORTANT: Don't forget to:"
echo "   1. Set APP_DEBUG=false in .env"
echo "   2. Set APP_ENV=production in .env"
echo "   3. Configure SSL/HTTPS"
echo "   4. Change default admin password"
echo "   5. Set up database backups"
echo "   6. Configure firewall rules"
echo ""
echo "📖 See DEPLOYMENT_GUIDE.md for detailed instructions"
echo ""

