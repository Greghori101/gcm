# GCM Docker Deployment

This branch contains Docker configuration for deploying the GCM (General Clinic Management) Laravel application using Docker and docker-compose.

## 🚀 Quick Start

### Prerequisites
- Docker
- Docker Compose
- Git

### Deployment Steps

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd gcm
   git checkout hosting
   ```

2. **Configure environment**
   ```bash
   cp .env.production .env
   # Edit .env with your actual values
   ```

3. **Build and start containers**
   ```bash
   docker-compose up -d --build
   ```

4. **Run deployment script**
   ```bash
   chmod +x deploy.sh
   ./deploy.sh
   ```

## 🏗️ Architecture

The Docker setup includes:

- **App Container**: PHP 8.2-FPM + Nginx + Laravel application
- **Database Container**: MySQL 8.0
- **Redis Container**: Redis for caching and sessions

## 📁 Docker Files

- `Dockerfile`: Main application container configuration
- `docker-compose.yml`: Multi-container setup
- `docker/nginx.conf`: Nginx web server configuration
- `docker/supervisord.conf`: Process manager configuration
- `docker/php.ini`: PHP configuration
- `.env.production`: Production environment template
- `deploy.sh`: Deployment automation script

## ⚙️ Configuration

### Environment Variables

Key environment variables to configure in `.env`:

```bash
APP_URL=https://yourdomain.com
DB_PASSWORD=your-secure-password
MAIL_HOST=your-smtp-host
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-email-password
```

### Database

The MySQL container creates:
- Database: `gcm`
- User: `gcm_user`
- Password: Set in `DB_PASSWORD`

### Volumes

Persistent data is stored in:
- `db_data`: MySQL database files
- `./storage`: Laravel storage directory
- `./bootstrap/cache`: Laravel cache directory

## 🔧 Management Commands

### Start services
```bash
docker-compose up -d
```

### Stop services
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f app
```

### Access application container
```bash
docker-compose exec app bash
```

### Run Artisan commands
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
```

### Backup database
```bash
docker-compose exec db mysqldump -u gcm_user -p gcm > backup.sql
```

## 🌐 Coolify Deployment

For Coolify deployment:

1. Add your repository to Coolify
2. Select the `hosting` branch
3. Set build context to repository root
4. Configure environment variables in Coolify dashboard
5. Deploy!

## 🔍 Troubleshooting

### Permission Issues
```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage
```

### Clear Cache
```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
```

### Database Connection Issues
- Verify database container is running: `docker-compose ps`
- Check database logs: `docker-compose logs db`
- Ensure `.env` has correct database credentials

## 📊 Monitoring

Monitor your application:
- Application logs: `docker-compose logs -f app`
- Database logs: `docker-compose logs -f db`
- Redis logs: `docker-compose logs -f redis`

## 🔐 Security Considerations

- Change default database passwords
- Use strong `APP_KEY`
- Configure proper SSL certificates
- Set `APP_DEBUG=false` in production
- Regular security updates of base images

## 🆘 Support

If you encounter issues:
1. Check container logs
2. Verify environment configuration
3. Ensure all required services are running
4. Check file permissions

---

**Note**: This Docker configuration is optimized for production deployment with Coolify but can be used with any Docker hosting platform.
