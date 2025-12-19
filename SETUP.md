# Setup Instructions

## Prerequisites

Before setting up the Hospital Management System, ensure you have the following installed:

1. **PHP 8.1 or higher**
   ```bash
   php -v
   ```

2. **Composer** (PHP dependency manager)
   ```bash
   composer --version
   ```

3. **MySQL 5.7 or higher**
   ```bash
   mysql --version
   ```

4. **Node.js and NPM** (optional, for frontend assets)
   ```bash
   node -v
   npm -v
   ```

## Step-by-Step Setup

### 1. Navigate to Project Directory
```bash
cd Hospital-management
```

### 2. Install PHP Dependencies
```bash
composer install
```

This will install all Laravel framework dependencies and packages.

### 3. Environment Configuration

Copy the example environment file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Configure Database

Edit the `.env` file and update database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Create Database

Create a new MySQL database:

```sql
CREATE DATABASE hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or using command line:
```bash
mysql -u root -p -e "CREATE DATABASE hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 6. Run Migrations

Create all database tables:
```bash
php artisan migrate
```

### 7. Seed Database

Populate database with initial data (admin, doctors, patients):
```bash
php artisan db:seed
```

### 8. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Login Credentials

After seeding, you can login with:

### Admin Account
- **Email:** admin@hospital.com
- **Password:** password
- **Access:** Full system access

### Doctor Account
- **Email:** doctor1@hospital.com
- **Password:** password
- **Access:** Doctor dashboard, appointments, medical records

### Patient Account
- **Email:** patient1@hospital.com
- **Password:** password
- **Access:** Patient dashboard, appointments, medical records, bills

### Receptionist Account
- **Email:** receptionist@hospital.com
- **Password:** password
- **Access:** Patient registration, appointment booking, billing

## Troubleshooting

### Issue: Composer dependencies not installing
**Solution:** Ensure PHP version is 8.1+ and Composer is up to date:
```bash
composer self-update
```

### Issue: Database connection error
**Solution:** 
1. Verify MySQL is running
2. Check database credentials in `.env`
3. Ensure database exists
4. Check user permissions

### Issue: Permission denied errors
**Solution:** Set proper permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Issue: Class not found errors
**Solution:** Clear and regenerate autoload files:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Issue: Route not found
**Solution:** Clear route cache:
```bash
php artisan route:clear
php artisan route:cache
```

## Production Deployment

### 1. Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Set Environment
Update `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

### 4. Configure Web Server
Point your web server (Apache/Nginx) to the `public` directory.

## Additional Commands

### Clear All Caches
```bash
php artisan optimize:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Create New Migration
```bash
php artisan make:migration create_table_name
```

### Create New Model
```bash
php artisan make:model ModelName
```

### Create New Controller
```bash
php artisan make:controller ControllerName
```

## Development Tips

1. **Enable Debug Mode** (development only):
   ```env
   APP_DEBUG=true
   ```

2. **Use Laravel Telescope** (optional):
   ```bash
   composer require laravel/telescope --dev
   php artisan telescope:install
   php artisan migrate
   ```

3. **Enable Query Logging**:
   Add to `AppServiceProvider`:
   ```php
   DB::listen(function ($query) {
       Log::info($query->sql);
   });
   ```

## Support

For issues or questions:
1. Check Laravel documentation: https://laravel.com/docs
2. Review error logs: `storage/logs/laravel.log`
3. Check database logs for SQL errors

