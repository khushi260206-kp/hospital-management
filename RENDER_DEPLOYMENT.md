# Render Deployment Guide

This guide will help you deploy the Hospital Management System to Render.com.

## Prerequisites

1. A GitHub account
2. A Render account (sign up at https://render.com)
3. Your project pushed to a GitHub repository

## Step-by-Step Deployment Instructions

### Step 1: Push Code to GitHub

```bash
cd /home/nirmalgoswami/Documents/clg-projects/Hospital-management
git add .
git commit -m "Add Render configuration"
git push origin main
```

### Step 2: Create Render Account & Project

1. Go to https://render.com
2. Sign up with your GitHub account
3. Click "New +" → "Web Service"
4. Connect your GitHub repository
5. Select your `hospital-management-system` repository

### Step 3: Configure Web Service

Render should auto-detect the `render.yaml` file. If not, configure manually:

**Basic Settings:**
- **Name**: hospital-management
- **Environment**: PHP
- **Region**: Oregon (or closest to you)
- **Branch**: main
- **Root Directory**: Leave empty (or `.`)

**Build & Deploy:**
- **Build Command**: `composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist`
- **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Step 4: Add PostgreSQL Database

1. In Render Dashboard, click "New +" → "PostgreSQL"
2. Configure:
   - **Name**: hospital-management-db
   - **Database**: hospital_management
   - **User**: hospital_user
   - **Plan**: Free
3. Click "Create Database"
4. **Note**: Render free tier uses PostgreSQL, not MySQL

### Step 5: Configure Environment Variables

Go to your Web Service → "Environment" tab and add:

```
APP_NAME="Hospital Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

# Database (from PostgreSQL service)
DB_CONNECTION=pgsql
DB_HOST=[from PostgreSQL Internal Database URL]
DB_PORT=5432
DB_DATABASE=[from PostgreSQL database name]
DB_USERNAME=[from PostgreSQL user]
DB_PASSWORD=[from PostgreSQL password]

# Or use the Internal Database URL directly:
# DATABASE_URL=[from PostgreSQL Internal Database URL]

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_LEVEL=error
```

**To get database credentials:**
1. Go to your PostgreSQL service
2. Click on it
3. Copy the "Internal Database URL" or individual values

### Step 6: Generate APP_KEY

**Option A: Let Render generate it**
- Render will auto-generate if `APP_KEY` is set to `generateValue: true` in `render.yaml`

**Option B: Generate manually**
```bash
php artisan key:generate --show
```
Copy the output and add as `APP_KEY` in Render environment variables.

### Step 7: Update Database Configuration for PostgreSQL

Since Render free tier uses PostgreSQL, you need to update your Laravel config:

1. The `render.yaml` already sets `DB_CONNECTION=pgsql` via environment variables
2. Make sure PostgreSQL driver is available in `composer.json` (it should be by default)

### Step 8: Deploy

1. Click "Manual Deploy" → "Deploy latest commit"
2. Watch the build logs
3. Wait for deployment to complete

### Step 9: Run Migrations

After first successful deployment:

**Option A: Using Render Shell**
1. Go to your Web Service
2. Click "Shell" tab
3. Run:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

**Option B: Using Render CLI**
```bash
# Install Render CLI
npm install -g render-cli

# Login
render login

# Run migrations
render exec -s hospital-management -- php artisan migrate --force
```

### Step 10: Update APP_URL

1. After deployment, Render gives you a URL like: `https://hospital-management.onrender.com`
2. Update `APP_URL` environment variable with your actual URL
3. Redeploy if needed

## Important Notes

### PostgreSQL vs MySQL
- Render free tier uses **PostgreSQL**, not MySQL
- Laravel supports PostgreSQL out of the box
- Your migrations should work without changes
- Only difference: `DB_CONNECTION=pgsql` instead of `mysql`

### Free Tier Limitations
- **Sleep Mode**: Free services sleep after 15 minutes of inactivity
- **Cold Start**: First request after sleep takes ~50 seconds
- **Database**: PostgreSQL free tier has limitations
- **Build Time**: Limited build minutes per month

### Environment Variables Reference

**Required:**
- `APP_KEY` - Application encryption key
- `APP_URL` - Your Render app URL
- `DB_*` - Database connection details

**Recommended:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `LOG_LEVEL=error`
- `SESSION_DRIVER=database`

## Troubleshooting

### Error: "composer: command not found"
**Solution**: Make sure Environment is set to "PHP" in Render settings.

### Error: "Database connection failed"
**Solution**: 
- Check database credentials in Environment variables
- Ensure PostgreSQL service is running
- Verify `DB_CONNECTION=pgsql` is set

### Error: "APP_KEY not set"
**Solution**: 
- Generate key: `php artisan key:generate --show`
- Add to Render environment variables

### Error: "Migration failed"
**Solution**:
- Run migrations manually in Shell
- Check database permissions
- Verify all migrations are in `database/migrations/`

### Service keeps sleeping
**Solution**: 
- This is normal for free tier
- First request after sleep takes ~50 seconds
- Consider upgrading to paid plan for always-on service

## Post-Deployment Checklist

- [ ] Database migrations run successfully
- [ ] Database seeded (optional)
- [ ] Storage link created
- [ ] APP_URL updated
- [ ] Can access login page
- [ ] Can login with default accounts
- [ ] All features working

## Default Login Credentials

After seeding:
- **Admin**: admin@hospital.com / password
- **Doctor**: doctor1@hospital.com / password
- **Receptionist**: receptionist@hospital.com / password
- **Patient**: patient1@hospital.com / password

## Support

- Render Documentation: https://render.com/docs
- Render Community: https://community.render.com
- Laravel Documentation: https://laravel.com/docs

---

**Note**: Render free tier services sleep after inactivity. For production use, consider upgrading to a paid plan.

