# 🚀 Development Environment - Production Simulation

## Overview
Development environment yang mensimulasikan production server menggunakan NGINX dengan IP **10.10.10.44** untuk konsistensi dan eliminasi CORS issues.

## ⚡ Quick Start

### 1. Setup Environment (One-time)
```bash
# Run automated setup
sudo ./setup-nginx-dev.sh

# Verify services
sudo systemctl status nginx
sudo systemctl status php8.3-fpm
sudo systemctl status mysql
```

### 2. Daily Development
```bash
# Start services
sudo systemctl start nginx php8.3-fpm mysql

# Stop services
sudo systemctl stop nginx php8.3-fpm mysql

# Restart if needed
sudo systemctl restart nginx php8.3-fpm
```

### 3. Access Application
- **Main App**: http://10.10.10.44
- **phpMyAdmin**: http://10.10.10.44/phpmyadmin
- **Storage Files**: http://10.10.10.44/storage/...

## 🔧 Architecture

### NGINX Configuration
```nginx
server {
    listen 80;
    server_name 10.10.10.44 localhost _;
    root /var/www/public;
    index index.php index.html;

    # Laravel public files
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Direct storage access (eliminates CORS)
    location /storage/ {
        alias /var/www/storage/app/public/;
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Laravel Environment
```env
APP_URL=http://10.10.10.44
ASSET_URL=http://10.10.10.44
```

## 🎯 Benefits vs Traditional `php artisan serve`

### ✅ Advantages
1. **Production-like Environment**: NGINX + PHP-FPM mirrors real server
2. **CORS Elimination**: Single origin (10.10.10.44) for all resources
3. **Better Performance**: NGINX static file serving + PHP-FPM process management
4. **Persistent Services**: No need to restart manually
5. **Storage Access**: Direct file serving without Laravel routing overhead
6. **Real URL Structure**: `/storage/` works exactly like production
7. **Team Consistency**: Same IP for all developers
8. **Database Integration**: phpMyAdmin accessible at same domain

### ⚠️ Considerations
1. **System Dependencies**: Requires NGINX and PHP-FPM installation
2. **sudo Privileges**: Service management needs root access
3. **Port 80**: May conflict with other web servers
4. **Network Configuration**: Fixed IP requires network setup

## 🛠 Troubleshooting

### Service Issues
```bash
# Check service status
sudo systemctl status nginx php8.3-fpm mysql

# Check logs
sudo tail -f /var/log/nginx/error.log
sudo journalctl -u php8.3-fpm -f

# Restart services
sudo systemctl restart nginx php8.3-fpm
```

### Permission Issues
```bash
# Fix storage permissions
sudo chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
sudo chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Recreate storage symlink
php artisan storage:link
```

### NGINX Configuration Test
```bash
# Test NGINX config
sudo nginx -t

# Reload configuration
sudo systemctl reload nginx
```

### Laravel Cache Issues
```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild optimized caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔄 Development Workflow

### 1. Code Changes
```bash
# Edit files normally
# No need to restart NGINX for PHP changes
```

### 2. Asset Changes
```bash
# After CSS/JS changes
npm run build

# For development with hot reload
npm run dev
```

### 3. Configuration Changes
```bash
# After .env changes
php artisan config:cache

# After route changes
php artisan route:cache
```

### 4. Database Changes
```bash
# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```

## 📊 Performance Comparison

| Feature | `php artisan serve` | NGINX + PHP-FPM |
|---------|-------------------|------------------|
| **Static Files** | PHP routing | Direct NGINX serving |
| **Concurrent Requests** | Single-threaded | Multi-process |
| **Memory Usage** | Higher | Optimized |
| **Production Similarity** | Low | High |
| **CORS Issues** | Common | Eliminated |
| **Setup Complexity** | Simple | Moderate |

## 🔐 Security Notes

### Production-like Security Headers
```nginx
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
```

### File Access Control
```nginx
location ~ /\. {
    deny all;
}

location ~ \.(env|log)$ {
    deny all;
}
```

## 📝 Development Guidelines

### 1. Always Use Environment URLs
```php
// ✅ Good - uses APP_URL from .env
$url = asset('storage/document.pdf');

// ❌ Bad - hardcoded localhost
$url = 'http://localhost:8000/storage/document.pdf';
```

### 2. Test with Production-like Data
```bash
# Use realistic file sizes and types
# Test upload limits and timeouts
# Verify storage permissions
```

### 3. Monitor Resource Usage
```bash
# Check PHP-FPM processes
sudo systemctl status php8.3-fpm

# Monitor NGINX connections
sudo ss -tuln | grep :80
```

## 🚀 Deployment Readiness

This development setup closely mirrors production:
- ✅ NGINX web server configuration
- ✅ PHP-FPM process management  
- ✅ Direct storage file serving
- ✅ Production-like URL structure
- ✅ Optimized static file handling
- ✅ Real database connections

**Result**: Smoother transition to production with fewer environment-specific issues.

---

**RS Dolopo Development Environment** - Production simulation with NGINX + PHP-FPM
