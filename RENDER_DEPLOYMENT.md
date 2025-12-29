# Render Deployment Guide - Step by Step

Complete guide to deploy your Laravel application to Render for FREE testing.

## Prerequisites

- GitHub account
- Your code pushed to GitHub repository
- 15-20 minutes

---

## Step 1: Prepare Your Code

### 1.1 Update `.env.example` for Render

Add these to your `.env.example`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

# PostgreSQL (Render uses PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Use database for sessions and cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

### 1.2 Commit All Changes

```bash
git add .
git commit -m "Prepare for Render deployment"
git push origin main
```

---

## Step 2: Create Render Account

1. Go to https://render.com
2. Click "Get Started for Free"
3. Sign up with your **GitHub account** (recommended)
4. Authorize Render to access your repositories

---

## Step 3: Create PostgreSQL Database (LIVE DATABASE)

**This creates your LIVE database that will store all your data!**

1. In Render dashboard, click **"New +"**
2. Select **"PostgreSQL"**
3. Configure:
   - **Name**: `sir-marvin-db`
   - **Database**: `marvin_db`
   - **User**: `marvin_user`
   - **Region**: Choose closest to you
   - **PostgreSQL Version**: 15 (latest)
   - **Plan**: **Free**
4. Click **"Create Database"**
5. **Wait 2-3 minutes** for database to be created

**✅ Your LIVE database is now running!**

6. **Copy the connection details** (you'll need them later):
   - Internal Database URL
   - External Database URL
   - Host, Port, Database, Username, Password

**This database will:**
- ✅ Store all your application data
- ✅ Be accessible 24/7
- ✅ Persist all data (not deleted)
- ✅ Be connected to your web app

---

## Step 4: Create Web Service

1. In Render dashboard, click **"New +"**
2. Select **"Web Service"**
3. Connect your GitHub repository:
   - Click **"Connect account"** if not connected
   - Select your repository
   - Click **"Connect"**

4. Configure the service:

   **Basic Settings:**
   - **Name**: `sir-marvin-app` (or your preferred name)
   - **Region**: Same as database
   - **Branch**: `main` (or your default branch)
   - **Root Directory**: Leave empty (or `./` if needed)
   - **Environment**: **PHP**
   - **Build Command**: 
     ```
     composer install --optimize-autoloader --no-dev && php artisan key:generate --force
     ```
   - **Start Command**: 
     ```
     php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=$PORT
     ```
     OR (if using Apache):
     ```
     vendor/bin/heroku-php-apache2 public/
     ```
   - **Plan**: **Free**

5. **Add Environment Variables**:

   Click **"Advanced"** → **"Add Environment Variable"** and add:

   ```
   APP_NAME=Sir Marvin
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-app-name.onrender.com
   LOG_CHANNEL=stderr
   LOG_LEVEL=error
   SESSION_DRIVER=database
   CACHE_DRIVER=database
   QUEUE_CONNECTION=database
   ```

   **Database Variables** (from Step 3):
   ```
   DB_CONNECTION=pgsql
   DB_HOST=your-db-host.onrender.com
   DB_PORT=5432
   DB_DATABASE=marvin_db
   DB_USERNAME=marvin_user
   DB_PASSWORD=your-db-password
   ```

   **Mail Configuration** (if using):
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_app_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@gmail.com
   MAIL_FROM_NAME="Sir Marvin"
   ```

6. **Link Database**:
   - Scroll down to **"Link Resource"**
   - Select your PostgreSQL database
   - This automatically adds database environment variables

7. Click **"Create Web Service"**

---

## Step 5: Wait for Deployment

1. Render will start building your application
2. This takes **5-10 minutes** for first deployment
3. Watch the build logs for any errors
4. Once deployed, you'll get a URL: `https://your-app-name.onrender.com`

---

## Step 6: Run Database Migrations (Create Tables in Live Database)

**This will create all your tables in the LIVE database!**

### Option 1: Using Render Shell

1. Go to your web service
2. Click **"Shell"** tab
3. Run:
   ```bash
   php artisan migrate --force
   ```
   **This creates all tables in your live database:**
   - ✅ users table
   - ✅ admins table
   - ✅ services table
   - ✅ submissions table
   - ✅ payments table
   - ✅ feedbacks table
   - ✅ All other tables

4. Seed initial data:
   ```bash
   php artisan db:seed --force
   ```
   **This adds:**
   - ✅ Default admin account
   - ✅ Sample services
   - ✅ Any other seed data

5. Complete setup:
   ```bash
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

**✅ Your live database now has all tables and data!**

### Option 2: Using SSH (if available)

```bash
ssh your-app@your-app.onrender.com
php artisan migrate --force
php artisan db:seed --force
```

---

## Step 7: Verify Deployment

1. Visit your app URL: `https://your-app-name.onrender.com`
2. Test the following:
   - ✅ Homepage loads
   - ✅ Login works
   - ✅ Registration works
   - ✅ File uploads work (if configured)
   - ✅ Database operations work

---

## Step 8: Configure Custom Domain (Optional)

1. Go to your web service settings
2. Click **"Custom Domains"**
3. Add your domain
4. Follow DNS configuration instructions
5. Render provides free SSL automatically

---

## Troubleshooting

### Issue: Build Fails

**Solution:**
- Check build logs for errors
- Verify PHP version (needs 8.1+)
- Ensure `composer.json` is correct
- Check for missing dependencies

### Issue: App Won't Start

**Solution:**
- Verify start command is correct
- Check environment variables
- Look at runtime logs
- Ensure `APP_KEY` is set

### Issue: Database Connection Error

**Solution:**
- Verify database is running
- Check database credentials
- Ensure database is linked to web service
- Use internal database URL (not external)

### Issue: 500 Internal Server Error

**Solution:**
- Check application logs
- Verify `.env` variables are set
- Run `php artisan config:clear`
- Check file permissions

### Issue: Storage Not Working

**Solution:**
- Render uses ephemeral storage (files deleted on restart)
- Use external storage (S3, Cloudinary) for production
- For testing, files will persist during active session

### Issue: Slow Cold Starts

**Solution:**
- Normal for free tier
- App spins down after 15 minutes of inactivity
- First request takes 30-60 seconds
- Subsequent requests are fast

---

## Important Notes

### Free Tier Limitations:

1. **Spins Down**: App sleeps after 15 minutes of inactivity
2. **Cold Starts**: Takes 30-60 seconds to wake up
3. **Database**: PostgreSQL free for 90 days, then $7/month
4. **Storage**: Ephemeral (files deleted on restart)
5. **Bandwidth**: 100 GB/month free

### For Production:

- Use AWS Lightsail ($20/month) for production
- Guaranteed uptime
- No spin-downs
- MySQL support
- Persistent storage

---

## Updating Your Application

### Automatic Deployment:

Render automatically deploys when you push to your main branch:

```bash
git add .
git commit -m "Update application"
git push origin main
```

Render will detect the push and redeploy automatically.

### Manual Deployment:

1. Go to your web service
2. Click **"Manual Deploy"**
3. Select branch
4. Click **"Deploy"**

---

## Environment Variables Reference

### Required Variables:

```
APP_NAME
APP_ENV=production
APP_DEBUG=false
APP_KEY (auto-generated)
APP_URL
DB_CONNECTION=pgsql
DB_HOST
DB_PORT=5432
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

### Recommended Variables:

```
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

---

## Migration from Render to AWS

When ready to move to production:

1. **Export Database**:
   ```bash
   pg_dump -h your-db-host -U your-user -d your-db > backup.sql
   ```

2. **Follow AWS_DEPLOYMENT_GUIDE.md**

3. **Import Database**:
   ```bash
   mysql -h aws-db-host -u user -p database < backup.sql
   ```

4. **Update DNS** to point to AWS

---

## Database Management

**Important**: Render uses PostgreSQL (not MySQL), so phpMyAdmin is not available.

**Database Management Options:**
1. **Render Dashboard** - Built-in SQL editor (easiest)
2. **pgAdmin** - Free tool similar to phpMyAdmin (recommended)
3. **DBeaver** - Universal database tool
4. **TablePlus** - Beautiful UI for database management

**See `RENDER_DATABASE_ACCESS.md` for detailed database access guide.**

---

## Support

- Render Documentation: https://render.com/docs
- Render Community: https://community.render.com
- Laravel Deployment: https://laravel.com/docs/deployment

---

## Quick Checklist

- [ ] Code pushed to GitHub
- [ ] Render account created
- [ ] PostgreSQL database created
- [ ] Web service created
- [ ] Environment variables configured
- [ ] Database linked
- [ ] Migrations run
- [ ] Application tested
- [ ] Custom domain configured (optional)

**You're all set! Your app is live on Render! 🚀**

