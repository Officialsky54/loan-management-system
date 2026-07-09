# Laravel Loan Management System

A complete, production-ready Loan Management System built with Laravel 12, PHP 8.3+, MySQL, Bootstrap 5, and AdminLTE.

## Features

### Installation
- Web-based installer - no terminal/SSH required
- Automatic database setup
- Environment configuration
- Admin account creation

### Dashboard
- Application statistics
- Pending applications tracking
- Manual review queue
- Email logs
- Website statistics

### Loan Application System
- Multi-step application form
- OCR verification (optional)
- Automatic email workflow
- Application tracking
- Bank details submission

### Admin Panel
- Website settings management
- Language configuration
- Email template editor
- OCR settings
- User management
- Application management
- Export to Excel/PDF
- Audit logs

### Security Features
- CSRF Protection
- Rate Limiting
- Input Validation
- XSS Protection
- SQL Injection Protection
- Secure File Uploads
- Password Hashing
- Authentication & Authorization

## System Requirements

- PHP 8.3 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & npm (for frontend assets)

## Installation Instructions

### Method 1: Web-Based Installer (Recommended for cPanel)

1. Upload the project to your cPanel/hosting
2. Visit `https://yourdomain.com/install`
3. Fill in the database and admin details
4. Click Install
5. The system will:
   - Create `.env` file
   - Generate application key
   - Run migrations
   - Seed database
   - Create admin account
   - Disable the installer

### Method 2: Manual Installation (Local Development)

```bash
# Clone the repository
git clone https://github.com/Officialsky54/loan-management-system.git
cd loan-management-system

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

## Default Credentials (After Installation)

**Admin Panel URL:** `/admin`

```
Email: admin@example.com
Password: (as set during installation)
```

## Directory Structure

```
loan-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Services/
│   ├── Jobs/
│   └── Mail/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── public/
│   │   └── installer/
│   ├── css/
│   └── js/
├── routes/
├── public/
├── storage/
└── bootstrap/
```

## Configuration

### Admin Panel Settings

Navigate to **Admin > Settings** to configure:

- Company Name & Logo
- Contact Information
- Loan Parameters (min/max amounts, duration, interest rate)
- Currency & Language
- SMTP Email Settings
- OCR Settings
- Maintenance Mode

### Email Templates

Customize all emails in **Admin > Email Templates**:

- Application Received
- Application Verified
- Bank Details Request
- Approval/Rejection Emails

Supported placeholders:
- `{customer_name}`
- `{reference_id}`
- `{loan_amount}`
- `{monthly_payment}`
- `{interest_rate}`
- `{total_repayment}`
- `{tracking_link}`
- `{company_name}`

## API Documentation

### Application Tracking

```
GET /track
Parameters:
- reference_id
- email

Returns:
- Application status
- Current step
- Loan details
- Uploaded documents
```

### Loan Calculator

```
GET /api/loan-calculator
Parameters:
- loan_amount (required)
- loan_duration (required)
- interest_rate (optional)

Returns:
- monthly_payment
- total_interest
- total_repayment
```

## Database Schema

Key tables:
- `users` - Admin users
- `applications` - Loan applications
- `application_documents` - Uploaded files
- `bank_details` - Customer bank information
- `email_logs` - Email tracking
- `website_settings` - Configuration
- `email_templates` - Editable email templates

## Security Considerations

1. Keep `.env` file secure and never commit it
2. Regularly update dependencies: `composer update`
3. Enable two-factor authentication for admin accounts
4. Use strong passwords
5. Implement SSL/HTTPS
6. Set up regular database backups
7. Monitor audit logs
8. Keep PHP and MySQL updated

## Troubleshooting

### Installer Issues

If you see "Installer already completed":
- The installer is disabled after first setup
- Delete `storage/app/installer_completed` to re-run

### Permission Errors

```bash
chmod -R 775 storage bootstrap/cache
```

### Database Connection Error

Check `.env` file for correct database credentials

### Email Not Sending

- Verify SMTP settings in Admin > Settings
- Check email logs in Admin > Email Logs
- Ensure port 587 or 465 is open

## Support

For issues or questions, please check:
1. Application logs: `storage/logs/`
2. Email logs: Admin > Email Logs
3. Audit logs: Admin > Audit Logs

## License

This project is proprietary and confidential.

## Version

Current Version: 1.0.0
Laravel: 12.x
PHP: 8.3+
