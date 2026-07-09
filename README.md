# Loan Management System

A complete Laravel-based Loan Management System with automated application processing, identity verification, and admin dashboard.

## Features

✨ **Core Features:**
- 📝 Online loan application form with multi-step process
- 🔍 OCR-based document scanning and verification
- 📊 Comprehensive admin dashboard with analytics
- 💳 Bank detail verification and management
- 📧 Automated email notifications
- 🔒 Secure user authentication
- 📱 Responsive design for all devices
- 💰 Loan calculator with real-time calculations
- 📈 Application tracking system
- 🗂️ Document management
- 👤 Role-based access control
- 📋 Audit logging for all transactions

## Technology Stack

- **Backend:** Laravel 12
- **Database:** MySQL 8.0+
- **Frontend:** Bootstrap 5, Alpine.js
- **OCR:** Tesseract OCR (optional)
- **Email:** SMTP/Mailtrap
- **Storage:** Local/Cloud Storage

## Requirements

- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js 18+ (for assets)
- npm or yarn

## Installation

### Option 1: Using the Installer (Recommended)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Officialsky54/loan-management-system.git
   cd loan-management-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Access the installer:**
   - Open your browser and go to `http://your-domain/install`
   - Fill in the database and admin credentials
   - Click "Complete Installation"

### Option 2: Manual Installation

1. **Clone and install:**
   ```bash
   git clone https://github.com/Officialsky54/loan-management-system.git
   cd loan-management-system
   composer install
   npm install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database in `.env`:**
   ```
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=loan_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations and seeders:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets:**
   ```bash
   npm run build
   ```

6. **Create admin user:**
   ```bash
   php artisan tinker
   >>> App\Models\User::create(['name' => 'admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'is_active' => true])
   >>> exit
   ```

## Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="Loan Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=loan_system
DB_USERNAME=root
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

OCR_ENABLED=true
OCR_PROVIDER=tesseract
```

### Email Configuration

1. Go to Admin Settings
2. Configure SMTP settings (Mailtrap, SendGrid, etc.)
3. Customize email templates
4. Test email delivery

### OCR Setup (Optional)

If using Tesseract OCR:

```bash
# Ubuntu/Debian
sudo apt-get install tesseract-ocr

# macOS
brew install tesseract

# Windows
# Download from: https://github.com/UB-Mannheim/tesseract/wiki
```

## Usage

### For Applicants

1. **Visit the website:** `https://yourdomain.com`
2. **Click "Apply Now"** to start the application
3. **Fill the multi-step form:**
   - Personal Information
   - Address Details
   - Employment Information
   - Loan Details
   - Document Upload
4. **Submit and get reference ID**
5. **Track application status** using reference ID and email

### For Administrators

1. **Login:** Go to `/admin` (or `/login` then redirect to admin)
2. **Dashboard:** View key metrics and recent applications
3. **Manage Applications:**
   - View all applications
   - Approve/Reject applications
   - Review identity verification
   - Manage bank details
4. **Email Templates:** Customize and manage email communications
5. **Settings:** Configure system settings and email
6. **Export Data:** Export applications as Excel/PDF

## Database Schema

### Key Tables

- `users` - System users and admins
- `applications` - Loan applications
- `application_documents` - Uploaded documents
- `bank_details` - Bank account information
- `email_templates` - Email templates
- `email_logs` - Email sending history
- `website_settings` - System configuration
- `audits` - Activity logs

## API Endpoints (if enabled)

```
POST   /api/applications              - Submit application
GET    /api/applications/{id}         - Get application details
GET    /api/applications/track        - Track application
GET    /api/loan/calculate            - Calculate loan payment
```

## Application Workflow

```
1. Application Submitted
   ↓
2. Identity Verification (OCR/Manual)
   ├─ Verified → Proceed
   └─ Rejected → Notify Applicant
   ↓
3. Request Bank Details
   ↓
4. Bank Details Review
   ├─ Approved → Loan Approved
   ├─ Rejected → Loan Rejected
   └─ Manual Review → Admin Decision
   ↓
5. Loan Disbursement
   ↓
6. Completed
```

## Security Features

- 🔐 Password hashing with bcrypt
- 🔒 CSRF protection
- 🛡️ SQL injection prevention
- 🚫 XSS protection
- 🔑 JWT token support (optional)
- 📝 Audit logging
- 🔍 Input validation and sanitization
- 🚀 Rate limiting (optional)

## File Structure

```
loan-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Web/
│   │   │   └── Installer/
│   ├── Models/
│   ├── Services/
│   ├── Jobs/
│   └── Events/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── web/
│   │   ├── installer/
│   │   └── auth/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── config/
├── storage/
└── public/
```

## Troubleshooting

### Installation Issues

**Problem:** "Class not found" error
```bash
composer dump-autoload
```

**Problem:** Storage permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

**Problem:** Database connection failed
- Check `.env` database credentials
- Ensure MySQL is running
- Create database: `mysql -u root -p -e "CREATE DATABASE loan_system"`

### Email Issues

- Test SMTP credentials in Settings
- Check email logs in Admin Dashboard
- Verify firewall allows SMTP port (usually 587 or 2525)

### OCR Issues

- Verify Tesseract is installed: `tesseract --version`
- Check file permissions for storage/app
- Review OCR results in application details

## Performance Optimization

1. **Enable Caching:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Optimization:**
   - Index frequently searched columns
   - Regular backups
   - Purge old email logs

3. **Asset Optimization:**
   ```bash
   npm run build
   ```

## Maintenance

### Regular Tasks

- Backup database weekly
- Monitor application logs
- Update dependencies: `composer update`
- Clear cache regularly: `php artisan cache:clear`

### Clearing Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Support & Contributions

For issues, feature requests, or contributions:
- GitHub Issues: https://github.com/Officialsky54/loan-management-system/issues
- Pull Requests: https://github.com/Officialsky54/loan-management-system/pulls

## License

This project is proprietary software. All rights reserved.

## Author

Created by Officialsky54

## Version

Current Version: 1.0.0
Last Updated: 2024

---

**Need Help?** Check the [Documentation](./docs) or [FAQ](./FAQ.md)
