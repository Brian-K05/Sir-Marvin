#!/bin/bash

# AWS Lightsail Deployment Script
# Run this on your Lightsail instance after connecting via SSH

echo "=========================================="
echo "AWS Lightsail Laravel Deployment Script"
echo "=========================================="
echo ""

# Check if running as root or with sudo
if [ "$EUID" -ne 0 ]; then 
    echo "⚠️  This script requires sudo privileges"
    echo "Please run: sudo bash deploy-aws-lightsail.sh"
    exit 1
fi

echo "📋 Step 1: Checking system requirements..."
php -v > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "❌ PHP not found. Please install LAMP stack first."
    exit 1
fi

composer --version > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "❌ Composer not found. Installing..."
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
fi

echo "✅ System requirements met"
echo ""

# Detect web root (Bitnami or standard)
if [ -d "/opt/bitnami/apache2/htdocs" ]; then
    WEB_ROOT="/opt/bitnami/apache2/htdocs"
    APACHE_USER="bitnami"
    APACHE_GROUP="daemon"
    APACHE_SERVICE="bitnami"
elif [ -d "/var/www/html" ]; then
    WEB_ROOT="/var/www/html"
    APACHE_USER="www-data"
    APACHE_GROUP="www-data"
    APACHE_SERVICE="apache2"
else
    echo "❌ Could not detect web root directory"
    exit 1
fi

echo "📋 Step 2: Setting up application directory..."
cd $WEB_ROOT

# Backup existing files
if [ "$(ls -A $WEB_ROOT)" ]; then
    echo "⚠️  Backing up existing files..."
    sudo tar -czf /tmp/web-backup-$(date +%Y%m%d).tar.gz .
fi

# Remove default files (keep .htaccess if exists)
find . -maxdepth 1 ! -name '.htaccess' -type f -delete
find . -maxdepth 1 -type d ! -name '.' ! -name '..' -exec rm -rf {} +

echo "✅ Application directory ready"
echo ""

echo "📋 Step 3: Installing application files..."
echo "⚠️  Please upload your application files to: $WEB_ROOT"
echo "    You can use:"
echo "    - SFTP (FileZilla, WinSCP)"
echo "    - SCP: scp -r -i key.pem ./ bitnami@your-ip:$WEB_ROOT"
echo ""
read -p "Press Enter after uploading files..."

if [ ! -f "$WEB_ROOT/composer.json" ]; then
    echo "❌ composer.json not found. Please upload application files first."
    exit 1
fi

echo "✅ Application files found"
echo ""

echo "📋 Step 4: Installing Composer dependencies..."
cd $WEB_ROOT
composer install --optimize-autoloader --no-dev --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Composer install failed"
    exit 1
fi
echo "✅ Dependencies installed"
echo ""

echo "📋 Step 5: Setting up environment file..."
if [ ! -f "$WEB_ROOT/.env" ]; then
    if [ -f "$WEB_ROOT/.env.example" ]; then
        cp .env.example .env
        echo "✅ Created .env from .env.example"
        echo "⚠️  IMPORTANT: Edit .env file with your configuration:"
        echo "    sudo nano $WEB_ROOT/.env"
    else
        echo "⚠️  .env.example not found. Please create .env manually"
    fi
else
    echo "✅ .env file already exists"
fi
echo ""

echo "📋 Step 6: Setting file permissions..."
chown -R $APACHE_USER:$APACHE_GROUP $WEB_ROOT
chmod -R 755 $WEB_ROOT
chmod -R 775 storage bootstrap/cache
chmod 600 .env 2>/dev/null || true
echo "✅ Permissions set"
echo ""

echo "📋 Step 7: Generating application key..."
if [ -f "$WEB_ROOT/.env" ]; then
    php artisan key:generate --force
    echo "✅ Application key generated"
else
    echo "⚠️  Skipping key generation (no .env file)"
fi
echo ""

echo "📋 Step 8: Running database migrations..."
read -p "Run migrations? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo "✅ Migrations completed"
else
    echo "⚠️  Skipping migrations"
fi
echo ""

echo "📋 Step 9: Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"
echo ""

echo "📋 Step 10: Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Application optimized"
echo ""

echo "📋 Step 11: Configuring Apache..."
# Update Apache configuration
if [ -d "/opt/bitnami/apache2/conf" ]; then
    # Bitnami configuration
    APACHE_CONF="/opt/bitnami/apache2/conf/bitnami/bitnami.conf"
    if [ -f "$APACHE_CONF" ]; then
        # Backup config
        cp $APACHE_CONF ${APACHE_CONF}.backup
        
        # Update DocumentRoot to public directory
        sed -i "s|DocumentRoot \".*\"|DocumentRoot \"$WEB_ROOT/public\"|g" $APACHE_CONF
        
        # Update Directory directive
        sed -i "s|<Directory \".*\">|<Directory \"$WEB_ROOT/public\">|g" $APACHE_CONF
        
        echo "✅ Apache configuration updated"
        echo "⚠️  Please verify Apache config: sudo nano $APACHE_CONF"
    fi
elif [ -d "/etc/apache2" ]; then
    # Standard Apache
    APACHE_CONF="/etc/apache2/sites-available/000-default.conf"
    if [ -f "$APACHE_CONF" ]; then
        sed -i "s|DocumentRoot .*|DocumentRoot $WEB_ROOT/public|g" $APACHE_CONF
        echo "✅ Apache configuration updated"
    fi
fi

# Restart Apache
if [ "$APACHE_SERVICE" = "bitnami" ]; then
    /opt/bitnami/ctlscript.sh restart apache
else
    systemctl restart apache2
fi

echo "✅ Apache restarted"
echo ""

echo "=========================================="
echo "✅ Deployment complete!"
echo "=========================================="
echo ""
echo "📋 Next steps:"
echo "   1. Edit .env file: sudo nano $WEB_ROOT/.env"
echo "   2. Configure database connection"
echo "   3. Set APP_URL to your domain"
echo "   4. Set up SSL certificate in Lightsail"
echo "   5. Test your application"
echo ""
echo "📖 See AWS_DEPLOYMENT_GUIDE.md for detailed instructions"
echo ""

