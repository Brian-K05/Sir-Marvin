# Change Default Admin Password

## ⚠️ SECURITY WARNING

**IMPORTANT**: After deploying to production, you MUST change the default admin password immediately!

## Current Default Admin Credentials

- **Email**: marvnbuena@gmail.com
- **Password**: Admin@2024!Secure#

**These credentials are for initial setup only. Change them immediately after first login!**

## How to Change Admin Password

### Method 1: Through Admin Panel (Recommended)

1. Log in to the admin panel using the default credentials
2. Navigate to **Admin Panel → Change Password**
3. Enter your current password
4. Enter a new strong password (minimum 8 characters with uppercase, lowercase, numbers, and special characters)
5. Confirm the new password
6. Click **Update Password**

### Method 2: Through Database Seeder

If you need to reset the admin password, you can update the `AdminSeeder.php` file:

```php
// In database/seeders/AdminSeeder.php
$strongPassword = 'YourNewStrongPassword123!@#';
```

Then run:
```bash
php artisan db:seed --class=AdminSeeder
```

### Method 3: Using Tinker (For Emergency Reset)

```bash
php artisan tinker
```

Then in the tinker console:
```php
$admin = App\Models\Admin::where('email', 'marvnbuena@gmail.com')->first();
$admin->password = Hash::make('YourNewStrongPassword123!@#');
$admin->save();
exit
```

## Password Requirements

Your new admin password must meet these requirements:
- Minimum 8 characters
- At least one uppercase letter (A-Z)
- At least one lowercase letter (a-z)
- At least one number (0-9)
- At least one special character (!@#$%^&*)

## Best Practices

1. **Use a unique password** - Don't reuse passwords from other accounts
2. **Use a password manager** - Consider using tools like LastPass, 1Password, or Bitwarden
3. **Enable two-factor authentication** - If available in future updates
4. **Regular password changes** - Change your password every 90 days
5. **Never share credentials** - Keep admin credentials confidential

## Additional Security Recommendations

1. **Create additional admin accounts** for team members instead of sharing one account
2. **Use different passwords** for each admin account
3. **Monitor admin login activity** regularly
4. **Implement IP whitelisting** if possible (future enhancement)
5. **Set up email alerts** for admin login attempts (future enhancement)

## After Changing Password

1. Log out and log back in with the new password to verify it works
2. Store the new password securely (password manager)
3. Delete or securely store any notes containing the old password
4. If you used Method 2 or 3, remove the password from the code/seeder

