# Railway Deployment Guide

This guide will help you deploy the Hospital Management System to Railway.

## Prerequisites

1. A GitHub account
2. A Railway account (sign up at https://railway.app)
3. Your project pushed to a GitHub repository

## Step-by-Step Deployment Instructions

### Step 1: Prepare Your GitHub Repository

1. **Initialize Git** (if not already done):
   ```bash
   git init
   git add .
   git commit -m "Initial commit - Hospital Management System"
   ```

2. **Create a GitHub repository**:
   - Go to https://github.com/new
   - Create a new repository (e.g., `hospital-management-system`)
   - **DO NOT** initialize with README, .gitignore, or license

3. **Push your code to GitHub**:
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/hospital-management-system.git
   git branch -M main
   git push -u origin main
   ```

### Step 2: Set Up Railway Account

1. Go to https://railway.app
2. Sign up with your GitHub account
3. Click "New Project"
4. Select "Deploy from GitHub repo"
5. Authorize Railway to access your GitHub repositories
6. Select your `hospital-management-system` repository

### Step 3: Add MySQL Database Service

1. In your Railway project dashboard, click **"+ New"**
2. Select **"Database"**
3. Choose **"MySQL"**
4. Railway will automatically create a MySQL database
5. **Note down the connection details** (you'll need them in the next step)

### Step 4: Configure Environment Variables

1. In your Railway project, click on your **Web Service**
2. Go to the **"Variables"** tab
3. Add the following environment variables:

   ```
   APP_NAME="Hospital Management System"
   APP_ENV=production
   APP_KEY=base64:YOUR_APP_KEY_HERE
   APP_DEBUG=false
   APP_URL=https://your-app-name.up.railway.app
   
   DB_CONNECTION=mysql
   DB_HOST=containers-us-west-XXX.railway.app
   DB_PORT=3306
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=YOUR_DB_PASSWORD
   
   LOG_CHANNEL=stack
   LOG_LEVEL=error
   
   CACHE_DRIVER=file
   SESSION_DRIVER=database
   QUEUE_CONNECTION=sync
   ```

4. **Important**: 
   - Get `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` from your MySQL service's **"Variables"** tab
   - Generate `APP_KEY` by running locally: `php artisan key:generate --show` (copy the output)
   - Update `APP_URL` with your actual Railway domain (you'll get this after first deployment)

### Step 5: Link Database to Web Service

1. In your Railway project dashboard
2. Click on your **Web Service**
3. Go to **"Settings"** tab
4. Scroll down to **"Service Connections"**
5. Click **"Add Service Connection"**
6. Select your **MySQL service**
7. Railway will automatically add the database connection variables

### Step 6: Deploy the Application

1. Railway will automatically start building and deploying your app
2. You can watch the build logs in real-time
3. Once deployment is complete, Railway will provide you with a URL like: `https://your-app-name.up.railway.app`

### Step 7: Run Database Migrations

1. In your Railway project, click on your **Web Service**
2. Go to the **"Deployments"** tab
3. Click on the three dots (⋯) next to your latest deployment
4. Select **"View Logs"**
5. Or use Railway CLI:

   ```bash
   # Install Railway CLI
   npm i -g @railway/cli
   
   # Login
   railway login
   
   # Link to your project
   railway link
   
   # Run migrations
   railway run php artisan migrate --force
   ```

6. **Alternative**: Use Railway's one-click shell:
   - Go to your Web Service
   - Click **"Deployments"** → **"View Logs"**
   - Click **"Shell"** tab
   - Run: `php artisan migrate --force`

### Step 8: Seed Database (Optional)

If you want to populate initial data:

```bash
railway run php artisan db:seed --force
```

Or use Railway's shell:
```bash
php artisan db:seed --force
```

### Step 9: Set Up Storage Link

Run this command to create a symbolic link for storage:

```bash
railway run php artisan storage:link
```

### Step 10: Verify Deployment

1. Visit your Railway URL: `https://your-app-name.up.railway.app`
2. You should see the login page
3. Try logging in with the seeded accounts:
   - **Admin**: admin@hospital.com / password
   - **Doctor**: doctor1@hospital.com / password
   - **Receptionist**: receptionist@hospital.com / password
   - **Patient**: patient1@hospital.com / password

## Post-Deployment Configuration

### Custom Domain (Optional)

1. In Railway, go to your Web Service → **"Settings"**
2. Scroll to **"Domains"**
3. Click **"Generate Domain"** or **"Custom Domain"**
4. Follow the instructions to set up your custom domain

### Environment Variables Reference

Make sure these are set correctly in production:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` - Your Railway domain
- `DB_*` - Database connection details from MySQL service
- `SESSION_DRIVER=database` (recommended for production)

## Troubleshooting

### Issue: Application shows 500 error
- **Solution**: Check logs in Railway dashboard
- Make sure `APP_KEY` is set
- Verify database connection variables are correct

### Issue: Database connection failed
- **Solution**: 
  - Verify database service is running
  - Check database credentials in Variables tab
  - Ensure service connection is linked

### Issue: Migrations fail
- **Solution**: 
  - Run `php artisan migrate --force` in Railway shell
  - Check database permissions
  - Verify all migrations are in `database/migrations/`

### Issue: Assets not loading
- **Solution**: 
  - Run `php artisan config:cache`
  - Run `php artisan route:cache`
  - Run `php artisan view:cache`

### Issue: Storage files not accessible
- **Solution**: 
  - Run `php artisan storage:link`
  - Consider using cloud storage (S3) for production

## Railway CLI Commands (Optional)

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link project
railway link

# View logs
railway logs

# Run commands
railway run php artisan migrate
railway run php artisan db:seed
railway run php artisan storage:link

# Open shell
railway shell
```

## Cost Information

- Railway offers $5 free credit per month
- MySQL database: ~$5/month (may use free credit)
- Web service: Free tier available (with limitations)
- Monitor usage in Railway dashboard

## Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production`
- [ ] Strong database passwords
- [ ] HTTPS enabled (automatic with Railway)
- [ ] Environment variables secured
- [ ] `.env` file not committed to Git

## Support

- Railway Documentation: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Laravel Documentation: https://laravel.com/docs

---

**Note**: After deployment, your app will be publicly accessible. Make sure to:
1. Change default passwords
2. Review security settings
3. Monitor usage and costs
4. Set up proper backups

