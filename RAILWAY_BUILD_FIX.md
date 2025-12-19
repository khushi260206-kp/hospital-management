# Railway Build Error Fix

## Issue
Railway build fails with "composer.json not found" error.

## Solution

### Option 1: Set Build Command in Railway Dashboard (Recommended)

1. Go to your Railway project
2. Click on your **Web Service**
3. Go to **"Settings"** tab
4. Scroll to **"Build & Deploy"** section
5. Set the following:

   **Build Command:**
   ```bash
   composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
   ```

   **Start Command:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

6. **Root Directory:** Leave empty (Railway will auto-detect)

### Option 2: Verify Root Directory

If Railway is building from wrong directory:

1. In Railway Web Service → **Settings**
2. Check **"Root Directory"** field
3. Should be empty or set to: `.` (current directory)
4. Railway should detect `composer.json` automatically

### Option 3: Check Repository Structure

Make sure your GitHub repository has this structure:
```
hospital-management-system/
├── composer.json          ← Must be at root
├── composer.lock
├── artisan
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── Procfile
├── railway.json
└── nixpacks.toml
```

## Common Build Errors & Fixes

### Error: "composer.json not found"
**Fix:** Ensure `composer.json` is in the repository root and pushed to GitHub.

### Error: "PHP version not found"
**Fix:** Railway auto-detects PHP from `composer.json`. Ensure you have:
```json
"require": {
    "php": "^8.1"
}
```

### Error: "Build timeout"
**Fix:** The build might be taking too long. Check:
- Remove unnecessary files from repository
- Ensure `.railwayignore` excludes large files
- Check build logs for specific errors

## Verification Steps

1. **Check GitHub Repository:**
   ```bash
   git ls-files | grep composer.json
   ```
   Should show: `composer.json`

2. **Verify Railway Detection:**
   - Railway should auto-detect Laravel
   - Check build logs for "Detected Laravel" message

3. **Manual Build Test:**
   ```bash
   cd /path/to/project
   composer install --no-dev --optimize-autoloader
   ```
   Should complete without errors

## Updated Configuration Files

The following files have been updated:
- ✅ `nixpacks.toml` - Enhanced build configuration
- ✅ `.railway/build.sh` - Alternative build script (optional)

## Next Steps

1. **Push changes to GitHub:**
   ```bash
   git add .
   git commit -m "Fix Railway build configuration"
   git push
   ```

2. **In Railway Dashboard:**
   - Set Build Command (see Option 1 above)
   - Trigger new deployment
   - Watch build logs

3. **If still failing:**
   - Check Railway build logs for specific error
   - Verify all files are committed to GitHub
   - Ensure `composer.json` is in repository root

## Build Command Reference

**For Railway Dashboard:**
```
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
```

**Start Command:**
```
php artisan serve --host=0.0.0.0 --port=$PORT
```

