@echo off
REM Production Deployment Script for Windows
REM Run this script to prepare your Laravel application for production

echo ==========================================
echo Laravel Production Deployment Script
echo ==========================================
echo.

REM Check if .env exists
if not exist .env (
    echo [ERROR] .env file not found!
    echo Please copy .env.example to .env and configure it first.
    exit /b 1
)

echo [Step 1] Checking environment configuration...
findstr /C:"APP_DEBUG=true" .env >nul
if %errorlevel% equ 0 (
    echo [WARNING] APP_DEBUG is set to true. Please set it to false for production.
)

findstr /C:"APP_ENV=local" .env >nul
if %errorlevel% equ 0 (
    echo [WARNING] APP_ENV is set to local. Please set it to production.
)

echo [OK] Environment file found
echo.

echo [Step 2] Generating application key (if needed)...
php artisan key:generate --force
echo [OK] Application key ready
echo.

echo [Step 3] Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo [OK] Caches cleared
echo.

echo [Step 4] Optimizing for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo [OK] Configuration cached
echo.

echo [Step 5] Optimizing Composer autoloader...
composer install --optimize-autoloader --no-dev --quiet
echo [OK] Composer optimized
echo.

echo [Step 6] Building assets...
call npm run build
echo [OK] Assets built
echo.

echo [Step 7] Creating storage link...
php artisan storage:link
echo [OK] Storage link created
echo.

echo ==========================================
echo [OK] Deployment preparation complete!
echo ==========================================
echo.
echo [IMPORTANT] Don't forget to:
echo    1. Set APP_DEBUG=false in .env
echo    2. Set APP_ENV=production in .env
echo    3. Configure SSL/HTTPS
echo    4. Change default admin password
echo    5. Set up database backups
echo    6. Configure firewall rules
echo.
echo [INFO] See DEPLOYMENT_GUIDE.md for detailed instructions
echo.

pause

