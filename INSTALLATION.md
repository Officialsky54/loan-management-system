# Loan Management System - Installation Guide

## Quick Start (5 minutes)

### Prerequisites
- PHP 8.3 or higher
- MySQL 8.0 or higher
- Composer
- Node.js 18+

### Step 1: Download & Setup

```bash
# Clone the repository
git clone https://github.com/Officialsky54/loan-management-system.git
cd loan-management-system

# Install dependencies
composer install
npm install
```

### Step 2: Run Installer

```bash
# Start the application
php artisan serve

# In your browser, visit:
# http://localhost:8000/install
```

Fill in the installation form:
- **Database Configuration** (Host, Name, User, Password)
- **Website Configuration** (URL)
- **Admin Account** (Email, Username, Password)

Click "Complete Installation" and wait for it to finish.

### Step 3: Login

```
URL: http://localhost:8000/admin
Email: [your admin email]
Password: [your admin password]
```

## Installation Methods

### Method 1: Installer UI (Easiest)

1. Visit `/install` page
2. Fill the form
3. Click "Complete Installation"
4. Done!

### Method 2: Manual Installation

```bash
# 1. Clone repository
git clone https://github.com/Officialsky54/loan-management-system.git
cd loan-management-system

# 2. Install dependencies
composer install
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Update .env with database details
# Edit .env and set:
# DB_HOST=127.0.0.1
# DB_DATABASE=loan_system
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 6. Run migrations
php artisan migrate

# 7. Seed database
php artisan db:seed

# 8. Build assets
npm run build

# 9. Start the server
php artisan serve
```

## Configuration

### Database Setup

Create a database:
```bash
mysql -u root -p
CREATE DATABASE loan_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loan_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Email Configuration

1. Get SMTP credentials from Mailtrap/SendGrid/etc.
2. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_FROM_ADDRESS=noreply@example.com
   ```

### Storage Setup

```bash
# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache
chmod -R 755 public/storage
```

## Deployment

### Shared Hosting (cPanel)

1. **Upload Files:**
   - Extract ZIP to public_html
   - Make sure public folder contents are in root

2. **Create Database:**
   - Use cPanel MySQL Databases
   - Create user with all privileges

3. **Update .env:**
   - Set DB credentials
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`

4. **Run Migrations:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Set Permissions:**
   ```bash
   chmod -R 755 .
   chmod -R 777 storage bootstrap/cache
   ```

### VPS/Server

1. **SSH into server**
   ```bash
   ssh user@your-server-ip
   ```

2. **Install requirements:**
   ```bash
   sudo apt update
   sudo apt install php8.3 php8.3-mysql php8.3-fpm nginx mysql-server
   ```

3. **Install Composer & Node:**
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt install nodejs
   ```

4. **Clone and setup:**
   ```bash
   cd /var/www
   git clone https://github.com/Officialsky54/loan-management-system.git
   cd loan-management-system
   composer install
   npm install
   ```

5. **Configure Nginx:**
   Create `/etc/nginx/sites-available/loan-system` with your configuration

6. **Setup SSL (Let's Encrypt):**
   ```bash
   sudo certbot certonly -a nginx -d yourdomain.com
   ```

## Troubleshooting

### Common Issues

**1. "Class not found" Error**
```bash
composer dump-autoload
php artisan clear-compiled
```

**2. Storage Permission Denied**
```bash
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

**3. Database Connection Failed**
- Verify MySQL is running: `mysql -u root -p`
- Check .env database credentials
- Create database if missing

**4. Email Not Sending**
- Test SMTP in admin settings
- Check email logs
- Verify SMTP credentials

**5. 404 Pages Not Found (Nginx)**
- Add to location block in nginx config:
  ```
  try_files $uri $uri/ /index.php?$query_string;
  ```

## Post-Installation

### 1. Admin Dashboard
- Login at `/admin`
- Configure system settings
- Customize email templates
- Review applications

### 2. Email Setup
- Go to Admin Settings
- Configure SMTP
- Customize email templates
- Send test emails

### 3. Security Checklist
- [ ] Change admin password
- [ ] Set `APP_DEBUG=false` in production
- [ ] Enable HTTPS/SSL
- [ ] Set up regular backups
- [ ] Configure firewall

### 4. Optimization
```bash
# Cache configuration
php artisan config:cache
php artisan route:cache

# Build assets for production
npm run build
```

## Backup & Maintenance

### Database Backup
```bash
mysqldump -u root -p loan_system > backup.sql
```

### Restore Backup
```bash
mysql -u root -p loan_system < backup.sql
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Support

For help:
1. Check the README.md
2. Review error logs: `storage/logs/laravel.log`
3. Visit GitHub Issues: https://github.com/Officialsky54/loan-management-system/issues

## Next Steps

1. Customize website content
2. Configure email templates
3. Set up OCR (optional)
4. Configure payment gateway (optional)
5. Launch and promote

Happy lending! 💰
