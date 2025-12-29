# Security Documentation

This document outlines the security measures implemented in this Laravel application to protect against common attacks and vulnerabilities.

## Database Security

### 1. SQL Injection Prevention
- **Prepared Statements**: All database queries use Laravel's Eloquent ORM, which automatically uses prepared statements
- **PDO Configuration**: Database connection configured with:
  - `PDO::ATTR_EMULATE_PREPARES => false` - Forces real prepared statements
  - `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` - Throws exceptions on errors
  - `PDO::ATTR_PERSISTENT => false` - Prevents connection hijacking
- **Strict Mode**: MySQL strict mode enabled to prevent invalid data insertion
- **Input Validation**: All user inputs are validated before database operations

### 2. Database Connection Security
- Database credentials stored in `.env` file (never commit to version control)
- Use strong database passwords
- Limit database user permissions (only grant necessary privileges)
- Use SSL connections in production (configure `MYSQL_ATTR_SSL_CA` in `.env`)

## Application Security

### 1. Authentication Security
- **Rate Limiting**: 
  - Login: 5 attempts per minute per IP
  - Registration: 5 attempts per minute per IP
  - Password Reset: 3 attempts per minute per IP
- **Password Requirements**:
  - Minimum 8 characters
  - Must contain uppercase, lowercase, numbers, and special characters
  - Passwords are hashed using bcrypt
- **Session Security**:
  - Sessions encrypted by default
  - HTTP-only cookies (prevents JavaScript access)
  - Secure cookies in production (HTTPS only)
  - Same-site cookie protection
  - Session lifetime: 120 minutes (configurable)

### 2. CSRF Protection
- All POST/PUT/DELETE requests require CSRF token
- Token automatically included in forms via `@csrf` directive
- Token validated on every state-changing request

### 3. XSS (Cross-Site Scripting) Protection
- Blade templates automatically escape output: `{{ $variable }}`
- Raw output only when necessary: `{!! $variable !!}`
- Input sanitization helper functions available
- Content Security Policy (CSP) headers implemented

### 4. File Upload Security
- **File Type Validation**: Only allowed MIME types accepted
- **File Size Limits**: Maximum file sizes enforced
- **Filename Sanitization**: Dangerous characters removed from filenames
- **Path Traversal Prevention**: Filenames sanitized to prevent directory traversal
- **Storage Location**: Files stored outside web root in `storage/app/public`
- **MIME Type Verification**: Extension must match actual file type

### 5. Security Headers
The application includes security headers middleware that adds:
- `X-Frame-Options: SAMEORIGIN` - Prevents clickjacking
- `X-Content-Type-Options: nosniff` - Prevents MIME type sniffing
- `X-XSS-Protection: 1; mode=block` - Legacy XSS protection
- `Referrer-Policy: strict-origin-when-cross-origin` - Controls referrer information
- `Permissions-Policy` - Restricts browser features
- `Content-Security-Policy` - Controls resource loading
- `Strict-Transport-Security` - Forces HTTPS in production

### 6. Input Validation & Sanitization
- All user inputs validated using Laravel's validation rules
- Custom sanitization helpers available:
  - `sanitize_input()` - Removes HTML tags and encodes special characters
  - `sanitize_filename()` - Sanitizes filenames for safe storage
  - `validate_file_upload()` - Comprehensive file upload validation

### 7. Authorization
- Route-level authorization using middleware
- Resource-level authorization (users can only access their own data)
- Admin-only routes protected with `admin` middleware
- 403 errors for unauthorized access attempts

## Environment Security

### 1. Environment Variables
- Sensitive data stored in `.env` file (never commit to version control)
- `.env.example` provided as template (no sensitive data)
- `APP_KEY` must be unique and kept secret
- Database credentials never hardcoded

### 2. Debug Mode
- `APP_DEBUG=false` in production
- Error details hidden from users in production
- Detailed errors only shown in development

## Deployment Security Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY` if not already set
- [ ] Use strong database passwords
- [ ] Enable HTTPS/SSL
- [ ] Set `SESSION_SECURE_COOKIE=true` in `.env`
- [ ] Set `SESSION_SAME_SITE=strict` in `.env` (if using HTTPS)
- [ ] Configure database SSL connection
- [ ] Set proper file permissions (storage: 775, bootstrap/cache: 775)
- [ ] Remove default admin credentials
- [ ] Review and restrict file upload limits
- [ ] Configure proper server security headers
- [ ] Set up regular backups
- [ ] Enable firewall rules
- [ ] Keep Laravel and dependencies updated
- [ ] Monitor error logs regularly
- [ ] Set up intrusion detection if possible

## Security Monitoring

### Logging
- Security events logged to `storage/logs/laravel.log`
- Failed authentication attempts logged
- File upload validation failures logged
- Unauthorized access attempts logged

### Regular Maintenance
- Update Laravel framework regularly
- Update Composer dependencies
- Review security logs weekly
- Monitor for suspicious activity
- Keep server software updated

## Additional Recommendations

1. **Database**:
   - Use a dedicated database user with minimal privileges
   - Regularly backup database
   - Monitor database access logs
   - Use database encryption at rest

2. **Server**:
   - Keep PHP updated
   - Configure PHP security settings (disable dangerous functions)
   - Use firewall (UFW, iptables, etc.)
   - Regular security patches

3. **Application**:
   - Implement two-factor authentication (future enhancement)
   - Regular security audits
   - Penetration testing
   - Security headers validation

## Security Helper Functions

The application includes helper functions in `app/Helpers/SecurityHelper.php`:

- `sanitize_input($input)` - Sanitize user input
- `sanitize_filename($filename)` - Sanitize filenames
- `validate_file_upload($file, $allowedMimes, $maxSize)` - Validate file uploads
- `log_security_event($event, $context)` - Log security events

## Reporting Security Issues

If you discover a security vulnerability, please report it responsibly. Do not create public GitHub issues for security vulnerabilities.

