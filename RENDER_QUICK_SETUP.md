# Render Quick Setup Checklist

## ✅ Files Created

The following files have been created for Render deployment:
- ✅ `render.yaml` - Render configuration file
- ✅ `.render-build.sh` - Build script (optional)
- ✅ `RENDER_DEPLOYMENT.md` - Complete deployment guide

## 📋 Quick Setup Steps

### 1. Push to GitHub
```bash
git add .
git commit -m "Add Render configuration"
git push origin main
```

### 2. Create Render Account
- Go to https://render.com
- Sign up with GitHub

### 3. Create Web Service
1. Click "New +" → "Web Service"
2. Connect your GitHub repository
3. Select `hospital-management-system`
4. Render will auto-detect `render.yaml`

### 4. Add PostgreSQL Database
1. Click "New +" → "PostgreSQL"
2. Name: `hospital-management-db`
3. Plan: Free
4. Create Database

### 5. Set Environment Variables

In Web Service → Environment tab, add:

```
APP_NAME="Hospital Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

# Database (from PostgreSQL service)
DB_CONNECTION=pgsql
DB_HOST=[from PostgreSQL]
DB_PORT=5432
DB_DATABASE=[from PostgreSQL]
DB_USERNAME=[from PostgreSQL]
DB_PASSWORD=[from PostgreSQL]

SESSION_DRIVER=database
CACHE_DRIVER=file
LOG_LEVEL=error
```

**Get DB credentials from:** PostgreSQL Service → "Connections" tab

### 6. Generate APP_KEY

**Option A:** Let Render generate (if `render.yaml` has `generateValue: true`)

**Option B:** Generate manually:
```bash
php artisan key:generate --show
```
Add output as `APP_KEY` in Render environment variables.

### 7. Deploy
- Click "Manual Deploy" → "Deploy latest commit"
- Watch build logs

### 8. Run Migrations (After Deployment)

In Render Shell:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### 9. Update APP_URL
- After deployment, get your URL
- Update `APP_URL` environment variable
- Redeploy if needed

## ⚠️ Important Notes

1. **PostgreSQL**: Render free tier uses PostgreSQL, not MySQL
2. **Sleep Mode**: Free services sleep after 15 min inactivity
3. **Cold Start**: First request after sleep takes ~50 seconds
4. **Environment**: Must be set to "PHP" in Render settings

## 🆘 Troubleshooting

**"composer: command not found"**
→ Set Environment to "PHP" in Render settings

**"Database connection failed"**
→ Check DB credentials, ensure `DB_CONNECTION=pgsql`

**"APP_KEY not set"**
→ Generate and add to environment variables

## 📚 Full Guide

See `RENDER_DEPLOYMENT.md` for detailed instructions.

