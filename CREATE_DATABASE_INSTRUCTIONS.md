# How to Create MySQL Database: marvin_site

## Method 1: Using phpMyAdmin (Easiest - Recommended)

### If you have XAMPP:
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Open your browser and go to: `http://localhost/phpmyadmin`
4. Login with:
   - Username: `root`
   - Password: (leave blank) or `password`
5. Click **"New"** in the left sidebar
6. Enter database name: `marvin_site`
7. Collation: `utf8mb4_unicode_ci` (or leave default)
8. Click **"Create"** button

### If you have WAMP:
1. Open WAMP Control Panel
2. Make sure both services are running (green icon)
3. Click on WAMP icon → **phpMyAdmin**
4. Follow steps 4-8 above

---

## Method 2: Using MySQL Command Line

### Step 1: Find MySQL Installation
Common locations:
- **XAMPP**: `C:\xampp\mysql\bin\`
- **WAMP**: `C:\wamp64\bin\mysql\mysql8.x.x\bin\`
- **Standalone**: `C:\Program Files\MySQL\MySQL Server 8.0\bin\`

### Step 2: Open Command Prompt/PowerShell
Navigate to MySQL bin directory:
```powershell
cd C:\xampp\mysql\bin
# OR
cd C:\wamp64\bin\mysql\mysql8.x.x\bin
```

### Step 3: Connect to MySQL
```bash
mysql -u root -p
```
Enter password when prompted (or press Enter if no password)

### Step 4: Create Database
In the MySQL prompt, type:
```sql
CREATE DATABASE marvin_site;
EXIT;
```

---

## Method 3: Using MySQL Workbench

1. Open **MySQL Workbench**
2. Connect to your MySQL server (usually `localhost`)
3. Click the **"Create a new schema"** icon (or Database → Create Schema)
4. Name: `marvin_site`
5. Collation: `utf8mb4_unicode_ci`
6. Click **"Apply"**

---

## Method 4: Using SQL File (Alternative)

Create a file `create_database.sql`:
```sql
CREATE DATABASE IF NOT EXISTS marvin_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run:
```bash
mysql -u root -p < create_database.sql
```

---

## After Creating the Database

Once the database is created, run Laravel migrations:

```bash
php artisan migrate --seed
```

This will:
- Create all necessary tables
- Populate initial data (admin user and services)

---

## Troubleshooting

### "Access denied" error:
- Check your MySQL username and password in `.env`
- Make sure MySQL service is running

### "Database already exists" error:
- The database is already created, you can proceed with migrations

### Can't find MySQL:
- Check if XAMPP/WAMP is installed
- Check if MySQL is installed separately
- You may need to add MySQL to your system PATH

