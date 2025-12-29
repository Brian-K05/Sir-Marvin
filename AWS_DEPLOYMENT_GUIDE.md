# AWS Deployment Guide - Cost-Optimized

This guide provides cost-effective AWS deployment options for your Laravel application while maintaining good performance.

## Application Requirements Analysis

Your application needs:
- **Web Server**: PHP 8.1+, Laravel 10
- **Database**: MySQL
- **File Storage**: Document uploads, payment proofs
- **Email**: SMTP (Gmail)
- **SSL/HTTPS**: Required for production

## Recommended AWS Architecture (Cost-Optimized)

### Option 1: EC2 + RDS (Most Cost-Effective for Small-Medium Traffic)

**Estimated Monthly Cost: $30-50**

#### Components:
1. **EC2 Instance**: `t3.micro` or `t3.small`
   - **t3.micro**: 2 vCPU, 1 GB RAM - **~$7-8/month**
   - **t3.small**: 2 vCPU, 2 GB RAM - **~$15-16/month**
   - Free tier eligible for first year (t2.micro)

2. **RDS MySQL**: `db.t3.micro` or `db.t4g.micro`
   - **db.t3.micro**: 2 vCPU, 1 GB RAM - **~$15-18/month**
   - **db.t4g.micro** (ARM-based): **~$12-15/month** (cheaper!)
   - Free tier eligible for first year (db.t2.micro)

3. **Elastic IP**: Free (if attached to running instance)

4. **Storage**:
   - EBS Volume (20-30 GB): **~$2-3/month**
   - RDS Storage (20 GB): **~$2-3/month**

5. **Data Transfer**: First 100 GB free, then **~$0.09/GB**

**Total: ~$30-50/month** (or **FREE for first year** with free tier)

#### Setup Steps:

1. **Launch EC2 Instance**:
   ```bash
   # Use Amazon Linux 2023 or Ubuntu 22.04 LTS
   # Instance type: t3.micro (free tier) or t3.small
   ```

2. **Install LAMP Stack**:
   ```bash
   # Amazon Linux 2023
   sudo dnf install -y httpd php php-mysqlnd php-mbstring php-xml php-zip php-gd
   sudo systemctl enable httpd
   sudo systemctl start httpd
   
   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

3. **Create RDS MySQL Instance**:
   - Engine: MySQL 8.0
   - Instance class: db.t4g.micro (cheapest)
   - Storage: 20 GB gp3
   - Enable automated backups (7 days retention)
   - Publicly accessible: No (for security)

4. **Configure Security Groups**:
   - EC2: Allow HTTP (80), HTTPS (443), SSH (22)
   - RDS: Allow MySQL (3306) from EC2 security group only

### Option 2: Lightsail (Simplest & Predictable Pricing)

**Estimated Monthly Cost: $10-20**

#### Components:
1. **Lightsail Instance**: $3.50-$10/month
   - **512 MB RAM, 1 vCPU**: $3.50/month (too small)
   - **1 GB RAM, 1 vCPU**: $5/month ✅ **RECOMMENDED**
   - **2 GB RAM, 1 vCPU**: $10/month (if needed)

2. **Lightsail Database**: $15/month
   - MySQL 8.0
   - 1 GB RAM, 1 vCPU
   - 20 GB storage

**Total: ~$20-25/month**

**Pros:**
- Fixed, predictable pricing
- Easy setup (includes LAMP stack)
- Free SSL certificate
- Simple management

**Cons:**
- Less flexible than EC2
- Limited instance types

### Option 3: Elastic Beanstalk (Managed, Auto-Scaling)

**Estimated Monthly Cost: $40-60**

- Managed platform
- Auto-scaling capabilities
- More expensive but easier management

**Best for**: If you expect traffic growth

## Cost Comparison

| Service | Monthly Cost | Best For |
|---------|-------------|----------|
| **EC2 + RDS** | $30-50 | Full control, cost optimization |
| **Lightsail** | $20-25 | Simplicity, predictable costs |
| **Elastic Beanstalk** | $40-60 | Auto-scaling, managed service |

## 🏆 RECOMMENDATION: AWS Lightsail

**Why Lightsail?**
1. **Lowest cost**: $20-25/month total
2. **Simplest setup**: Pre-configured LAMP stack
3. **Predictable pricing**: No surprise bills
4. **Free SSL**: Included SSL certificate
5. **Easy scaling**: Upgrade instance size anytime
6. **Perfect for small-medium traffic**: Handles 100-1000 daily visitors easily

## Step-by-Step Lightsail Deployment

### Step 1: Create Lightsail Instance

1. Go to AWS Lightsail Console
2. Click "Create instance"
3. Choose:
   - **Platform**: Linux/Unix
   - **Blueprint**: LAMP (PHP 8.1)
   - **Instance plan**: $5/month (1 GB RAM, 1 vCPU, 40 GB SSD)
   - **Name**: `sir-marvin-app`

### Step 2: Create Lightsail Database

1. Go to Lightsail → Databases
2. Click "Create database"
3. Choose:
   - **Database engine**: MySQL 8.0
   - **Plan**: $15/month (1 GB RAM, 1 vCPU, 20 GB SSD)
   - **Database name**: `marvin_db`
   - **Master username**: `admin` (or your choice)
   - **Master password**: Generate strong password

### Step 3: Connect to Instance

```bash
# Download SSH key from Lightsail
# Connect via SSH
ssh -i your-key.pem bitnami@your-instance-ip
```

### Step 4: Install Application

```bash
# Navigate to web root
cd /opt/bitnami/apache2/htdocs

# Remove default files
sudo rm -rf *

# Clone or upload your application
# Option 1: If using Git
sudo git clone your-repo-url .

# Option 2: Upload via SFTP/SCP
# Use FileZilla or WinSCP to upload files to /opt/bitnami/apache2/htdocs

# Install dependencies
sudo composer install --optimize-autoloader --no-dev

# Set permissions
sudo chown -R bitnami:daemon .
sudo chmod -R 775 storage bootstrap/cache
```

### Step 5: Configure Environment

```bash
# Copy .env file
sudo cp .env.example .env

# Edit .env file
sudo nano .env
```

Update `.env`:
```env
APP_NAME="Sir Marvin - Grammar & Editing Service"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-database-endpoint.lightsail.aws-region.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=marvin_db
DB_USERNAME=admin
DB_PASSWORD=your-database-password

SESSION_DRIVER=file
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Mail configuration (Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

### Step 6: Generate Key and Run Migrations

```bash
# Generate application key
sudo php artisan key:generate

# Run migrations
sudo php artisan migrate --force

# Seed database
sudo php artisan db:seed --force

# Create storage link
sudo php artisan storage:link

# Optimize for production
sudo php artisan config:cache
sudo php artisan route:cache
sudo php artisan view:cache
```

### Step 7: Configure Apache

```bash
# Edit Apache configuration
sudo nano /opt/bitnami/apache2/conf/httpd.conf

# Or use Bitnami's configuration
sudo nano /opt/bitnami/apache2/conf/bitnami/bitnami.conf
```

Add/Update:
```apache
<Directory "/opt/bitnami/apache2/htdocs/public">
    Options -Indexes +FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

# Point to public directory
DocumentRoot "/opt/bitnami/apache2/htdocs/public"
```

Restart Apache:
```bash
sudo /opt/bitnami/ctlscript.sh restart apache
```

### Step 8: Set Up SSL Certificate (Free)

1. Go to Lightsail → Networking
2. Click "Create static IP" and attach to instance
3. Go to your domain DNS settings
4. Create A record pointing to static IP
5. In Lightsail, go to Networking → SSL/TLS certificates
6. Click "Create certificate"
7. Enter your domain name
8. Follow DNS validation steps
9. Attach certificate to your instance

### Step 9: Configure Firewall

In Lightsail Networking:
- Allow HTTP (80)
- Allow HTTPS (443)
- Allow SSH (22) - restrict to your IP if possible

## Cost Optimization Tips

### 1. Use Reserved Instances (EC2)
- Save up to 72% with 3-year commitment
- Only if you're sure about long-term usage

### 2. Use Spot Instances (Not Recommended for Production)
- Can save 90% but can be terminated
- Only for development/testing

### 3. Optimize Storage
- Use gp3 instead of gp2 (20% cheaper)
- Delete unused snapshots
- Use S3 for file storage (cheaper than EBS for large files)

### 4. Monitor Usage
- Set up billing alerts
- Use AWS Cost Explorer
- Review monthly costs

### 5. Use CloudFront CDN (Optional)
- Free tier: 50 GB data transfer
- Speeds up static assets
- Reduces server load

### 6. Database Optimization
- Use db.t4g.micro (ARM-based, cheaper)
- Enable automated backups (7 days is enough)
- Monitor database size

## Monthly Cost Breakdown (Lightsail)

| Service | Cost |
|---------|------|
| Lightsail Instance (1 GB) | $5.00 |
| Lightsail Database | $15.00 |
| Static IP | $0.00 (free) |
| SSL Certificate | $0.00 (free) |
| Data Transfer (first 1 TB) | $0.00 (free) |
| **Total** | **$20.00/month** |

## Scaling Plan

### When to Upgrade:

1. **Traffic increases**:
   - 1 GB → 2 GB RAM: +$5/month
   - 2 GB → 4 GB RAM: +$10/month

2. **Database needs more power**:
   - Upgrade database plan: +$10-20/month

3. **Need auto-scaling**:
   - Migrate to EC2 + Auto Scaling: $40-60/month

## Backup Strategy

### Lightsail Snapshots:
- Manual snapshots: $0.05/GB/month
- Automated daily snapshots: Configure in Lightsail

### Database Backups:
- Automated backups included (7 days retention)
- Manual snapshots: $0.095/GB/month

**Recommendation**: Weekly manual snapshots + automated daily backups

## Monitoring & Alerts

1. **Set up CloudWatch Alarms**:
   - CPU utilization > 80%
   - Memory utilization > 80%
   - Disk space < 20%

2. **Billing Alerts**:
   - Alert when monthly cost > $25
   - Alert when cost > $50

## Security Checklist

- [ ] Enable SSL certificate
- [ ] Restrict SSH access to your IP
- [ ] Use strong database passwords
- [ ] Enable firewall rules
- [ ] Regular security updates
- [ ] Enable automated backups
- [ ] Use IAM roles (not access keys)
- [ ] Enable MFA for AWS account

## Migration from Local to AWS

1. **Export local database**:
   ```bash
   mysqldump -u root -p marvin_site > backup.sql
   ```

2. **Upload to AWS**:
   ```bash
   # Upload via SCP
   scp -i key.pem backup.sql bitnami@your-instance-ip:/tmp/
   
   # Import to RDS
   mysql -h db-endpoint -u admin -p marvin_db < backup.sql
   ```

3. **Upload application files**:
   ```bash
   # Use SFTP or SCP
   scp -r -i key.pem ./ bitnami@your-instance-ip:/opt/bitnami/apache2/htdocs/
   ```

4. **Upload storage files**:
   ```bash
   # Upload storage directory
   scp -r -i key.pem storage/ bitnami@your-instance-ip:/opt/bitnami/apache2/htdocs/storage/
   ```

## Alternative: Use S3 for File Storage

For better cost optimization, store uploaded files in S3:

**S3 Pricing**: 
- First 50 TB: $0.023/GB/month
- Much cheaper than EBS for large files
- Better for scalability

**Implementation**:
- Install `league/flysystem-aws-s3-v3` package
- Configure S3 in Laravel
- Update file storage to use S3

## Support & Resources

- AWS Lightsail Documentation: https://lightsail.aws.amazon.com/
- Laravel Deployment: https://laravel.com/docs/deployment
- AWS Free Tier: https://aws.amazon.com/free/

## Estimated First Year Cost

**With AWS Free Tier**:
- EC2 t2.micro: FREE (750 hours/month)
- RDS db.t2.micro: FREE (750 hours/month)
- EBS 30 GB: FREE (first 30 GB)
- **Total: ~$0-10/month** (only data transfer and storage over free tier)

**After Free Tier (Lightsail)**:
- **Total: $20/month** (fixed, predictable)

This is the most cost-effective solution for your application!

