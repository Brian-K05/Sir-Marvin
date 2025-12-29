# Professional Grammar & Editing Service - Laravel Application

A full-stack Laravel 10 web application for Marvin Dominic B. Buena's professional grammar and editing service. This application features a premium Awwwards-inspired frontend design and robust backend functionality for managing service bookings, payments, and submissions.

## Features

- **Public Frontend**: Awwwards-inspired design with custom CSS
- **Service Booking System**: Document upload, deadline selection, payment workflow
- **Two-Phase Payment**: Initial 50% and final 50% via GCash with manual verification
- **Admin Panel**: Secure admin authentication, dashboard, payment management
- **Chatbot**: Rule-based FAQ with Messenger redirect
- **Email Notifications**: Admin and client notifications (structure ready)

## Tech Stack

- Laravel 10
- Blade Templates
- Custom CSS (no frameworks)
- Vanilla JavaScript
- MySQL
- Laravel Breeze (admin authentication)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd "Sir  Marvin"
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Build assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

8. **Start the server**
   ```bash
   php artisan serve
   ```

## Default Admin Credentials

- **Email**: marvnbuena@gmail.com
- **Password**: Admin@2024!Secure#

**Important**: Change these credentials immediately after first login! See `CHANGE_ADMIN_PASSWORD.md` for instructions.

## Deployment Options

### Free Testing Phase (Recommended First)

For testing before production deployment:
- **FREE_HOSTING_GUIDE.md** - Free hosting options comparison
- **RENDER_DEPLOYMENT.md** - Step-by-step Render deployment (FREE)

**Recommended for Testing**: Render (completely free, perfect for testing)

### Production Deployment

For production deployment:
- **AWS_DEPLOYMENT_GUIDE.md** - Complete AWS deployment guide
- **AWS_COST_ESTIMATOR.md** - Cost breakdown and recommendations

**Recommended for Production**: AWS Lightsail at $20/month (most cost-effective option)

## Services

The application comes pre-seeded with the following services:

1. **Grammar Validation** - ₱5,000.00
2. **Paraphrasing** - ₱6,000.00
3. **Thematic Analysis** - ₱8,000.00
4. **Methodology Assistance** - ₱10,000.00
5. **Research Consultancy** - ₱15,000.00

## File Storage

Files are stored in `storage/app/public/`:
- Documents: `storage/app/public/documents/`
- Payment Proofs: `storage/app/public/proofs/`
- Corrected Files: `storage/app/public/corrected/`

Make sure the storage link is created: `php artisan storage:link`

## Configuration

### Messenger URL
Set the Messenger URL in `.env`:
```env
MESSENGER_URL=https://m.me/yourpage
```

### Mail Configuration
Configure mail settings in `.env` for email notifications:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Workflow

1. **Client submits service request** with document and initial payment proof
2. **Admin verifies initial payment** and approves/rejects
3. **Admin uploads corrected file** when work is completed
4. **Client uploads final payment proof**
5. **Admin verifies final payment** and approves
6. **Client downloads corrected file** after final payment approval

## Security

- CSRF protection enabled
- Input validation on all forms
- File upload validation (type and size)
- Admin authentication middleware
- Secure password hashing

## Development

### Running in development mode
```bash
npm run dev
php artisan serve
```

### Building for production
```bash
npm run build
```

## License

This project is proprietary software for Marvin Dominic B. Buena's professional editing service.

## Support

For support, contact:
- Email: marvin@seameo-innotech.org
- Phone: (02) 924 7681
