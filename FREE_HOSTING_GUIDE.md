# Free Hosting Guide for Testing Phase

This guide covers free hosting options for testing your Laravel application before deploying to AWS.

## 🏆 Best Option: Render (RECOMMENDED)

**Why Render?**
- ✅ Free tier with 750 hours/month (enough for testing)
- ✅ Native PHP/Laravel support
- ✅ Free PostgreSQL database
- ✅ Automatic SSL certificates
- ✅ Easy deployment from GitHub
- ✅ No credit card required for free tier
- ✅ Simple setup process

**Limitations:**
- Spins down after 15 minutes of inactivity (free tier)
- Takes 30-60 seconds to wake up
- 512 MB RAM (enough for testing)

**Perfect for**: Testing, development, demos

---

## Quick Comparison

| Platform | Laravel Support | Free Database | SSL | Best For |
|----------|----------------|---------------|-----|----------|
| **Render** | ✅ Excellent | ✅ PostgreSQL | ✅ Free | **Testing** ⭐ |
| **Railway** | ✅ Good | ✅ MySQL/Postgres | ✅ Free | Testing |
| **Fly.io** | ✅ Good | ❌ Need external | ✅ Free | Advanced users |
| **Vercel** | ❌ No (Node.js only) | ❌ No | ✅ Free | Static sites |
| **Heroku** | ✅ Good | ✅ Postgres | ✅ Free | Limited free tier |

---

## Option 1: Render (RECOMMENDED) ⭐

### Step 1: Prepare Your Application

1. **Update `.env.example` for Render**:
   ```env
   APP_NAME="Sir Marvin - Grammar & Editing Service"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-app.onrender.com

   DB_CONNECTION=pgsql
   DB_HOST=your-db-host.onrender.com
   DB_PORT=5432
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password

   SESSION_DRIVER=database
   SESSION_SECURE_COOKIE=true
   SESSION_SAME_SITE=strict

   # Use database for cache
   CACHE_DRIVER=database
   QUEUE_CONNECTION=database
   ```

2. **Create `render.yaml`** (for easy deployment):
   ```yaml
   services:
     - type: web
       name: sir-marvin-app
       env: php
       buildCommand: composer install --optimize-autoloader --no-dev
       startCommand: php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=$PORT
       envVars:
         - key: APP_ENV
           value: production
         - key: APP_DEBUG
           value: false
         - key: LOG_CHANNEL
           value: stderr
         - key: LOG_LEVEL
           value: error
   
     - type: pgsql
       name: sir-marvin-db
       plan: free
   ```

3. **Update `composer.json`** to ensure PHP version:
   ```json
   "require": {
       "php": "^8.1"
   }
   ```

4. **Create `Procfile`** (alternative to render.yaml):
   ```
   web: vendor/bin/heroku-php-apache2 public/
   ```

### Step 2: Deploy to Render

1. **Sign up**: Go to https://render.com (use GitHub account)

2. **Create New Web Service**:
   - Connect your GitHub repository
   - Select your repository
   - Choose "PHP" environment
   - Build Command: `composer install --optimize-autoloader --no-dev`
   - Start Command: `php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=$PORT`
   - Or use: `vendor/bin/heroku-php-apache2 public/`

3. **Create PostgreSQL Database**:
   - Go to "New" → "PostgreSQL"
   - Name: `sir-marvin-db`
   - Plan: Free
   - Copy connection string

4. **Configure Environment Variables**:
   ```
   APP_NAME="Sir Marvin"
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:your-generated-key
   APP_URL=https://your-app.onrender.com
   
   DB_CONNECTION=pgsql
   DB_HOST=your-db-host.onrender.com
   DB_PORT=5432
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   
   SESSION_DRIVER=database
   SESSION_SECURE_COOKIE=true
   SESSION_SAME_SITE=strict
   
   LOG_CHANNEL=stderr
   LOG_LEVEL=error
   ```

5. **Deploy**:
   - Click "Create Web Service"
   - Wait for deployment (5-10 minutes)
   - Your app will be live at: `https://your-app.onrender.com`

### Step 3: Post-Deployment

1. **Run Migrations**:
   ```bash
   # Via Render Shell or SSH
   php artisan migrate --force
   php artisan db:seed --force
   ```

2. **Create Storage Link**:
   ```bash
   php artisan storage:link
   ```

3. **Optimize**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Render Free Tier Limits:
- ✅ 750 hours/month (enough for testing)
- ✅ 512 MB RAM
- ✅ Free SSL
- ✅ Free PostgreSQL database (90 days, then $7/month)
- ⚠️ Spins down after 15 min inactivity
- ⚠️ Slower cold starts

---

## Option 2: Railway (Alternative)

### Why Railway?
- ✅ $5 free credit monthly
- ✅ MySQL support (native)
- ✅ Faster than Render
- ✅ No spin-down issues
- ✅ Easy GitHub deployment

### Setup Steps:

1. **Sign up**: https://railway.app (GitHub account)

2. **Create New Project**:
   - Connect GitHub repository
   - Add "PHP" service
   - Add "MySQL" database

3. **Configure Environment**:
   - Set environment variables
   - Railway auto-detects Laravel

4. **Deploy**:
   - Automatic deployment on git push
   - Get URL: `https://your-app.up.railway.app`

### Railway Free Tier:
- ✅ $5 free credit/month
- ✅ Enough for small apps
- ✅ MySQL included
- ⚠️ Need credit card (but free tier)

---

## Option 3: Fly.io (Advanced)

### Why Fly.io?
- ✅ Generous free tier
- ✅ Global edge deployment
- ✅ Fast performance
- ⚠️ More complex setup

### Setup Steps:

1. **Install Fly CLI**:
   ```bash
   # Windows
   powershell -Command "iwr https://fly.io/install.ps1 -useb | iex"
   
   # Mac/Linux
   curl -L https://fly.io/install.sh | sh
   ```

2. **Login**:
   ```bash
   fly auth login
   ```

3. **Initialize**:
   ```bash
   fly launch
   ```

4. **Deploy**:
   ```bash
   fly deploy
   ```

### Fly.io Free Tier:
- ✅ 3 shared-cpu VMs
- ✅ 3 GB persistent volume
- ✅ 160 GB outbound data transfer
- ✅ Free SSL

---

## Migration from MySQL to PostgreSQL (For Render)

Since Render uses PostgreSQL, you need to update your code:

### 1. Update `composer.json`:
```json
"require": {
    "doctrine/dbal": "^3.0"
}
```

Then run: `composer update`

### 2. Update Migrations (if needed):
- Most Laravel migrations work with both MySQL and PostgreSQL
- Check for MySQL-specific syntax

### 3. Update `.env`:
```env
DB_CONNECTION=pgsql
```

### 4. Test Locally with PostgreSQL:
```bash
# Install PostgreSQL locally (optional)
# Or use Docker
docker run --name postgres -e POSTGRES_PASSWORD=password -p 5432:5432 -d postgres
```

---

## Recommended Setup for Testing

### Phase 1: Initial Testing (Render)
- **Platform**: Render
- **Cost**: FREE
- **Duration**: Testing phase
- **Database**: PostgreSQL (free for 90 days)
- **Database Management**: pgAdmin (free, similar to phpMyAdmin)
- **Full System**: ✅ Live web app + ✅ Live database

### Phase 2: Extended Testing (Railway)
- **Platform**: Railway
- **Cost**: FREE ($5 credit/month)
- **Database**: MySQL (native)
- **Better for**: Longer testing periods

### Phase 3: Production (AWS)
- **Platform**: AWS Lightsail
- **Cost**: $20/month
- **Database**: MySQL
- **Best for**: Production deployment

---

## Quick Start: Render Deployment

### 1. Prepare Repository:
```bash
# Ensure all files are committed
git add .
git commit -m "Prepare for Render deployment"
git push origin main
```

### 2. Create Render Account:
- Go to https://render.com
- Sign up with GitHub

### 3. Create Web Service:
- New → Web Service
- Connect repository
- Settings:
  - **Name**: sir-marvin-app
  - **Environment**: PHP
  - **Build Command**: `composer install --optimize-autoloader --no-dev`
  - **Start Command**: `php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=$PORT`

### 4. Create Database:
- New → PostgreSQL
- Name: sir-marvin-db
- Plan: Free

### 5. Configure Environment:
- Add all environment variables
- Link database to web service

### 6. Deploy:
- Click "Create Web Service"
- Wait 5-10 minutes
- Your app is live!

---

## Troubleshooting

### Render Issues:

1. **App won't start**:
   - Check build logs
   - Verify PHP version (8.1+)
   - Check start command

2. **Database connection error**:
   - Verify database credentials
   - Check database is running
   - Ensure database is linked to web service

3. **Storage issues**:
   - Render uses ephemeral storage
   - Use S3 or external storage for files
   - Or use database for small files

4. **Slow cold starts**:
   - Normal for free tier
   - App spins down after 15 min inactivity
   - Takes 30-60 seconds to wake up

### Railway Issues:

1. **Deployment fails**:
   - Check build logs
   - Verify environment variables
   - Check PHP version

2. **Database connection**:
   - Verify MySQL credentials
   - Check database service is running

---

## File Storage on Free Hosting

Free hosting platforms use ephemeral storage (files deleted on restart). Options:

### Option 1: Use Database (Small Files)
- Store file paths in database
- Upload to external storage

### Option 2: Use Cloud Storage (Recommended)
- **AWS S3**: $0.023/GB/month
- **Cloudinary**: Free tier available
- **DigitalOcean Spaces**: $5/month

### Option 3: Use GitHub (Not Recommended)
- Store files in repository
- Not ideal for user uploads

---

## Environment Variables Template

### For Render:
```env
APP_NAME="Sir Marvin"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=https://your-app.onrender.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

LOG_CHANNEL=stderr
LOG_LEVEL=error

# Mail (Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Sir Marvin"
```

---

## Cost Comparison

| Platform | Cost | Database | Best For |
|----------|------|----------|----------|
| **Render** | FREE | PostgreSQL (90 days free) | **Testing** ⭐ |
| **Railway** | FREE ($5 credit) | MySQL | Extended testing |
| **Fly.io** | FREE | External needed | Advanced users |
| **Heroku** | FREE (limited) | Postgres | Legacy option |

---

## Final Recommendation

**For Testing Phase: Use Render**

**Why?**
1. ✅ Completely free
2. ✅ Easy setup
3. ✅ No credit card required
4. ✅ Perfect for testing
5. ✅ Easy migration to AWS later

**When to Move to AWS:**
- After testing is complete
- When ready for production
- When you need guaranteed uptime
- When you need MySQL (instead of PostgreSQL)

---

## Next Steps

1. **Choose Render** for free testing
2. **Follow Render setup steps** above
3. **Test your application** thoroughly
4. **Migrate to AWS** when ready for production
5. **See AWS_DEPLOYMENT_GUIDE.md** for production deployment

Good luck with your testing! 🚀

