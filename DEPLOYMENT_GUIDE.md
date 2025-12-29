# Production Deployment Guide

This guide will help you prepare your Laravel application for production deployment.

## Step 1: Environment Configuration

Update your `.env` file with the following production settings:

```env
APP_NAME="Sir Marvin - Grammar & Editing Service"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_strong_database_password

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Mail Configuration (if using email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Important Notes:
- **APP_KEY**: Run `php artisan key:generate` if not already set
- **APP_DEBUG**: Must be `false` in production
- **APP_URL**: Must match your actual domain
- **DB_PASSWORD**: Use a strong, unique password
- **SESSION_SECURE_COOKIE**: Set to `true` when using HTTPS

## Step 2: Generate Application Key

If you haven't already generated an application key:

```bash
php artisan key:generate
```

## Step 3: Optimize for Production

Run these commands to optimize your application:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Build assets for production
npm run build
```

## Step 4: Database Setup

1. **Create a dedicated database user** with minimal privileges:
   ```sql
   CREATE USER 'app_user'@'localhost' IDENTIFIED BY 'strong_password_here';
   GRANT SELECT, INSERT, UPDATE, DELETE ON your_database.* TO 'app_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

2. **Run migrations**:
   ```bash
   php artisan migrate --force
   ```

3. **Seed initial data** (only on first deployment):
   ```bash
   php artisan db:seed --force
   ```

## Step 5: File Permissions

Set proper file permissions (Linux/Unix servers):

```bash
# Storage and cache directories
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Ensure .env is not publicly accessible
chmod 600 .env
```

**Note**: On Windows servers, ensure the web server has read/write access to:
- `storage/` directory
- `bootstrap/cache/` directory

## Step 6: Remove Default Admin Credentials

**IMPORTANT**: After first deployment, change the default admin password!

1. Log in with the default admin account
2. Go to Admin Panel → Change Password
3. Set a strong, unique password
4. Consider creating additional admin accounts and removing the default one if needed

## Step 7: SSL/HTTPS Configuration

### For Apache:
1. Install SSL certificate (Let's Encrypt recommended)
2. Update virtual host configuration:
   ```apache
   <VirtualHost *:443>
       ServerName yourdomain.com
       DocumentRoot /path/to/your/app/public
       
       SSLEngine on
       SSLCertificateFile /path/to/certificate.crt
       SSLCertificateKeyFile /path/to/private.key
       
       <Directory /path/to/your/app/public>
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

3. Redirect HTTP to HTTPS:
   ```apache
   <VirtualHost *:80>
       ServerName yourdomain.com
       Redirect permanent / https://yourdomain.com/
   </VirtualHost>
   ```

### For Nginx:
1. Install SSL certificate
2. Update server configuration:
   ```nginx
   server {
       listen 443 ssl http2;
       server_name yourdomain.com;
       root /path/to/your/app/public;
       
       ssl_certificate /path/to/certificate.crt;
       ssl_certificate_key /path/to/private.key;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   
   server {
       listen 80;
       server_name yourdomain.com;
       return 301 https://$server_name$request_uri;
   }
   ```

## Step 8: Database SSL (Optional but Recommended)

If your database server supports SSL, configure it in `.env`:

```env
MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem
```

Then update `config/database.php` to use SSL connections.

## Step 9: Security Headers Verification

Verify that security headers are being sent. You can test using:

```bash
curl -I https://yourdomain.com
```

Or use online tools like:
- https://securityheaders.com
- https://observatory.mozilla.org

## Step 10: Set Up Regular Backups

### Database Backups:
```bash
# Create a backup script (backup-db.sh)
#!/bin/bash
mysqldump -u your_user -p'your_password' your_database > /backups/db_$(date +%Y%m%d_%H%M%S).sql

# Add to crontab (daily at 2 AM)
0 2 * * * /path/to/backup-db.sh
```

### File Backups:
```bash
# Backup storage directory
tar -czf /backups/storage_$(date +%Y%m%d_%H%M%S).tar.gz storage/
```

## Step 11: Monitoring and Logging

1. **Set up log rotation** to prevent log files from growing too large
2. **Monitor error logs** regularly: `storage/logs/laravel.log`
3. **Set up uptime monitoring** (e.g., UptimeRobot, Pingdom)
4. **Configure error reporting** (e.g., Sentry, Bugsnag)

## Step 12: Firewall Configuration

### For Linux servers (UFW):
```bash
# Allow SSH
ufw allow 22/tcp

# Allow HTTP and HTTPS
ufw allow 80/tcp
ufw allow 443/tcp

# Enable firewall
ufw enable
```

### For Windows servers:
- Configure Windows Firewall to allow ports 80 and 443
- Block all other unnecessary ports

## Step 13: Final Security Checklist

Before going live, verify:

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong database password set
- [ ] Default admin password changed
- [ ] SSL certificate installed and working
- [ ] HTTPS redirect configured
- [ ] File permissions set correctly
- [ ] All caches cleared and optimized
- [ ] `.env` file is not publicly accessible
- [ ] `storage/` and `bootstrap/cache/` are writable
- [ ] Error logging is working
- [ ] Security headers are present
- [ ] Rate limiting is active
- [ ] File upload limits are appropriate

## Step 14: Post-Deployment Testing

1. **Test authentication**:
   - Login as client
   - Login as admin
   - Test password reset

2. **Test file uploads**:
   - Submit a document
   - Upload payment proof
   - Verify file validation works

3. **Test security features**:
   - Try accessing admin routes without authentication
   - Test rate limiting (try multiple failed logins)
   - Verify CSRF protection is working

4. **Performance testing**:
   - Test page load times
   - Check database query performance
   - Monitor server resources

## Troubleshooting

### Common Issues:

1. **500 Internal Server Error**:
   - Check `storage/logs/laravel.log`
   - Verify file permissions
   - Check `.env` configuration

2. **Database Connection Error**:
   - Verify database credentials in `.env`
   - Check database server is running
   - Verify database user has correct permissions

3. **File Upload Issues**:
   - Check `storage/app/public` permissions
   - Verify `php artisan storage:link` was run
   - Check PHP upload limits in `php.ini`

4. **Session Issues**:
   - Verify `storage/framework/sessions` is writable
   - Check session configuration in `.env`

## Support

For issues or questions, refer to:
- `SECURITY.md` for security documentation
- Laravel documentation: https://laravel.com/docs
- Server logs: `storage/logs/laravel.log`

