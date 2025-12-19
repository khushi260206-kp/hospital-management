# Quick Railway Setup Checklist

## ✅ Automated Steps (Already Done)

The following files have been created for you:
- ✅ `Procfile` - Tells Railway how to start your app
- ✅ `railway.json` - Railway configuration
- ✅ `nixpacks.toml` - Build configuration
- ✅ `.env.example` - Environment template
- ✅ `DEPLOYMENT.md` - Full deployment guide

## 📋 Manual Steps You Need to Complete

### 1. Push Code to GitHub
```bash
# If not already done:
git init
git add .
git commit -m "Prepare for Railway deployment"
git remote add origin https://github.com/YOUR_USERNAME/hospital-management-system.git
git push -u origin main
```

### 2. Create Railway Account & Project
1. Go to https://railway.app
2. Sign up with GitHub
3. Click "New Project" → "Deploy from GitHub repo"
4. Select your repository

### 3. Add MySQL Database
1. In Railway dashboard, click **"+ New"**
2. Select **"Database"** → **"MySQL"**
3. Wait for database to be created

### 4. Configure Environment Variables
1. Click on your **Web Service** → **"Variables"** tab
2. Add these variables (get DB values from MySQL service):

```
APP_NAME="Hospital Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=[from MySQL service]
DB_PORT=[from MySQL service]
DB_DATABASE=[from MySQL service]
DB_USERNAME=[from MySQL service]
DB_PASSWORD=[from MySQL service]

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_LEVEL=error
```

3. **Generate APP_KEY**:
   - Run locally: `php artisan key:generate --show`
   - Copy the output and add as `APP_KEY` variable

### 5. Link Database to Web Service
1. Web Service → **"Settings"** → **"Service Connections"**
2. Click **"Add Service Connection"**
3. Select your MySQL service

### 6. Run Migrations
After first deployment, run:
```bash
# Option 1: Railway Shell
# Go to Web Service → Deployments → Shell tab
php artisan migrate --force

# Option 2: Railway CLI
railway run php artisan migrate --force
```

### 7. Seed Database (Optional)
```bash
php artisan db:seed --force
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Update APP_URL
1. After deployment, Railway gives you a URL
2. Update `APP_URL` variable with your actual URL
3. Redeploy if needed

## 🎯 Quick Reference

**Get Database Credentials:**
- MySQL Service → Variables tab
- Copy: `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`

**Get Your App URL:**
- Web Service → Settings → Domains
- Or check deployment logs

**View Logs:**
- Web Service → Deployments → View Logs

**Run Commands:**
- Web Service → Deployments → Shell tab
- Or use Railway CLI: `railway run php artisan [command]`

## ⚠️ Important Notes

1. **APP_KEY**: Must be generated and set before first deployment
2. **Database**: Must be linked via Service Connections
3. **APP_URL**: Update after getting your Railway domain
4. **Migrations**: Run manually after first deployment
5. **Storage**: Run `storage:link` command

## 🆘 Need Help?

- Full guide: See `DEPLOYMENT.md`
- Railway Docs: https://docs.railway.app
- Check logs in Railway dashboard for errors

