# 🚀 Step-by-Step Coolify Deployment Guide (Without Domain)

## Prerequisites
- A server/VPS with Docker installed
- Coolify installed on your server
- Access to your server's IP address

## Step 1: Setup Coolify Server

### 1.1 Install Coolify on your server
```bash
# On your server, run:
curl -fsSL https://cdn.coollabs.io/coolify/install.sh | bash
```

### 1.2 Access Coolify Dashboard
- Open browser and go to: `http://YOUR_SERVER_IP:8000`
- Complete the initial setup
- Create your admin account

## Step 2: Deploy Your Application

### 2.1 Add Your Repository
1. In Coolify dashboard, click **"+ New Resource"**
2. Select **"Public Repository"**
3. Enter your repository URL: `https://github.com/Greghori101/gcm.git`
4. Select branch: `hosting`
5. Click **"Continue"**

### 2.2 Configure Build Settings
1. **Build Pack**: Select "Dockerfile"
2. **Dockerfile Location**: Leave as `Dockerfile` (default)
3. **Build Context**: Leave as `/` (root directory)
4. **Port**: Set to `80`

### 2.3 Configure Environment Variables
In the **Environment Variables** section, add these variables:

**Required Variables:**
```
APP_NAME=GCM
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:WILL_BE_GENERATED_AUTOMATICALLY
APP_URL=http://YOUR_SERVER_IP
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=gcm
DB_USERNAME=gcm_user
DB_PASSWORD=your_secure_password123
SESSION_DRIVER=database
CACHE_STORE=redis
REDIS_HOST=redis
REDIS_PORT=6379
QUEUE_CONNECTION=database
```

**Optional but Recommended:**
```
MAIL_MAILER=log
LOG_LEVEL=error
BCRYPT_ROUNDS=12
```

### 2.4 Add Database Service
1. Click **"+ Add Service"**
2. Select **"MySQL"**
3. Configure:
   - **Service Name**: `mysql`
   - **Database Name**: `gcm`
   - **Username**: `gcm_user`
   - **Password**: `your_secure_password123` (same as DB_PASSWORD above)
   - **Root Password**: `root_password123`

### 2.5 Add Redis Service (Optional but Recommended)
1. Click **"+ Add Service"**
2. Select **"Redis"**
3. Configure:
   - **Service Name**: `redis`
   - **Port**: `6379`

## Step 3: Deploy

### 3.1 Start Deployment
1. Click **"Deploy"** button
2. Wait for the build process to complete (5-10 minutes)
3. Monitor logs in the **"Deployments"** tab

### 3.2 Post-Deployment Setup
Once deployment is successful, run these commands in Coolify's **Terminal**:

```bash
# Generate application key
php artisan key:generate --force

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## Step 4: Access Your Application

### 4.1 Get Your Application URL
- Your app will be available at: `http://YOUR_SERVER_IP`
- Check the **"Domains"** section in Coolify for the exact URL

### 4.2 First Login
1. Open your application URL
2. Register the first admin account
3. Configure your application settings

## Step 5: Optional Configurations

### 5.1 Setup Custom Port (if needed)
If port 80 is taken, you can:
1. Go to **"Domains"** in Coolify
2. Change the port to something like `8080`
3. Access via: `http://YOUR_SERVER_IP:8080`

### 5.2 Enable HTTPS (without domain)
1. In Coolify, go to **"Domains"**
2. Enable **"Force HTTPS"**
3. Coolify will generate a self-signed certificate
4. Access via: `https://YOUR_SERVER_IP` (accept security warning)

### 5.3 Backup Setup
1. Go to **"Backups"** in Coolify
2. Enable database backups
3. Set backup frequency (daily recommended)

## Troubleshooting

### Application Won't Start
1. Check **"Logs"** tab in Coolify
2. Verify all environment variables are set
3. Ensure database service is running

### Database Connection Issues
1. Verify MySQL service is running
2. Check database credentials match in env vars
3. Ensure DB_HOST is set to your MySQL service name

### Permission Issues
Run in terminal:
```bash
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
```

### View Application Logs
```bash
tail -f storage/logs/laravel.log
```

## Production Tips

1. **Change Default Passwords**: Update DB_PASSWORD to something secure
2. **Regular Backups**: Enable automatic database backups
3. **Monitor Resources**: Check server resources regularly
4. **Update Regularly**: Keep Coolify and your app updated
5. **Security**: Consider using a firewall to restrict access

## Quick Commands Reference

```bash
# Restart application
# (Use Coolify's restart button)

# View logs
docker logs -f container_name

# Access container shell
docker exec -it container_name bash

# Run artisan commands
php artisan migrate
php artisan cache:clear
php artisan queue:work
```

---

**Your GCM application should now be running at `http://YOUR_SERVER_IP`!** 🎉

Need help? Check the logs in Coolify dashboard or contact support.
