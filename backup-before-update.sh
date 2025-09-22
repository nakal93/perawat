#!/bin/bash

# ===========================================
# Production Backup Script Before Update
# ===========================================

# Configuration
APP_DIR="/var/www/perawat"
BACKUP_DIR="/var/www/backups"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DB_NAME="perawat_db"
DB_USER="perawat_user"
DB_PASS="perawat_2024"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Check if running as root or with sudo
if [[ $EUID -eq 0 ]]; then
    warning "Running as root. Consider running as www-data user for better security."
fi

log "Starting backup process..."

# Create backup directory if not exists
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
    log "Created backup directory: $BACKUP_DIR"
fi

# Create timestamped backup directory
CURRENT_BACKUP_DIR="$BACKUP_DIR/backup_$TIMESTAMP"
mkdir -p "$CURRENT_BACKUP_DIR"

log "Backup directory: $CURRENT_BACKUP_DIR"

# 1. Backup Database
log "Backing up database..."
mariadb-dump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$CURRENT_BACKUP_DIR/database_$TIMESTAMP.sql"

if [ $? -eq 0 ]; then
    log "Database backup completed successfully"
else
    error "Database backup failed!"
    exit 1
fi

# 2. Backup Application Files (excluding cache and logs)
log "Backing up application files..."
tar -czf "$CURRENT_BACKUP_DIR/application_$TIMESTAMP.tar.gz" \
    --exclude="storage/logs/*" \
    --exclude="storage/framework/cache/*" \
    --exclude="storage/framework/sessions/*" \
    --exclude="storage/framework/views/*" \
    --exclude="node_modules" \
    --exclude="vendor" \
    --exclude=".git" \
    -C "/var/www" "perawat"

if [ $? -eq 0 ]; then
    log "Application files backup completed successfully"
else
    error "Application files backup failed!"
    exit 1
fi

# 3. Backup uploaded files and storage
log "Backing up storage files..."
tar -czf "$CURRENT_BACKUP_DIR/storage_$TIMESTAMP.tar.gz" \
    -C "$APP_DIR" \
    "storage/app/public" \
    "public/storage"

if [ $? -eq 0 ]; then
    log "Storage backup completed successfully"
else
    warning "Storage backup failed or no files to backup"
fi

# 4. Backup .env file
log "Backing up environment configuration..."
cp "$APP_DIR/.env" "$CURRENT_BACKUP_DIR/env_$TIMESTAMP.backup"

if [ $? -eq 0 ]; then
    log "Environment backup completed successfully"
else
    error "Environment backup failed!"
    exit 1
fi

# 5. Create Git commit info
log "Saving Git commit information..."
cd "$APP_DIR"
git log -1 --oneline > "$CURRENT_BACKUP_DIR/git_commit_$TIMESTAMP.txt"
git status --porcelain > "$CURRENT_BACKUP_DIR/git_status_$TIMESTAMP.txt"

# 6. Create restore script
log "Creating restore script..."
cat > "$CURRENT_BACKUP_DIR/restore.sh" << EOF
#!/bin/bash
# Restore script for backup created on $TIMESTAMP

BACKUP_DIR="$CURRENT_BACKUP_DIR"
APP_DIR="$APP_DIR"
DB_NAME="$DB_NAME"
DB_USER="$DB_USER"
DB_PASS="$DB_PASS"

echo "WARNING: This will restore the application to state from $TIMESTAMP"
echo "Current application will be OVERWRITTEN!"
read -p "Are you sure? (yes/no): " confirm

if [ "\$confirm" != "yes" ]; then
    echo "Restore cancelled."
    exit 1
fi

echo "Enabling maintenance mode..."
cd "\$APP_DIR"
php artisan down

echo "Restoring database..."
mariadb -u "\$DB_USER" -p"\$DB_PASS" "\$DB_NAME" < "\$BACKUP_DIR/database_$TIMESTAMP.sql"

echo "Restoring application files..."
cd /var/www
tar -xzf "\$BACKUP_DIR/application_$TIMESTAMP.tar.gz"

echo "Restoring storage files..."
cd "\$APP_DIR"
tar -xzf "\$BACKUP_DIR/storage_$TIMESTAMP.tar.gz"

echo "Restoring environment file..."
cp "\$BACKUP_DIR/env_$TIMESTAMP.backup" "\$APP_DIR/.env"

echo "Setting permissions..."
sudo chown -R www-data:www-data "\$APP_DIR"
sudo chmod -R 755 "\$APP_DIR"
sudo chmod -R 775 "\$APP_DIR/storage"
sudo chmod -R 775 "\$APP_DIR/bootstrap/cache"

echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Restarting services..."
sudo systemctl reload nginx
sudo systemctl restart php8.4-fpm

echo "Disabling maintenance mode..."
php artisan up

echo "Restore completed successfully!"
EOF

chmod +x "$CURRENT_BACKUP_DIR/restore.sh"

# 7. Create backup info file
cat > "$CURRENT_BACKUP_DIR/backup_info.txt" << EOF
Backup Information
==================
Date: $(date)
Timestamp: $TIMESTAMP
Application Directory: $APP_DIR
Database: $DB_NAME
Server: $(hostname)
Git Commit: $(cd "$APP_DIR" && git log -1 --oneline)

Files Included:
- database_$TIMESTAMP.sql (Database dump)
- application_$TIMESTAMP.tar.gz (Application files)
- storage_$TIMESTAMP.tar.gz (Uploaded files)
- env_$TIMESTAMP.backup (Environment configuration)
- git_commit_$TIMESTAMP.txt (Git commit info)
- git_status_$TIMESTAMP.txt (Git working tree status)
- restore.sh (Restore script)

To restore this backup:
cd $CURRENT_BACKUP_DIR
./restore.sh
EOF

# 8. Set proper permissions
sudo chown -R www-data:www-data "$CURRENT_BACKUP_DIR"
sudo chmod -R 755 "$CURRENT_BACKUP_DIR"

# 9. Calculate backup size
BACKUP_SIZE=$(du -sh "$CURRENT_BACKUP_DIR" | cut -f1)

# 10. Clean old backups (keep last 5)
log "Cleaning old backups (keeping last 5)..."
cd "$BACKUP_DIR"
ls -t | grep "backup_" | tail -n +6 | xargs -r rm -rf

log "Backup completed successfully!"
log "Backup location: $CURRENT_BACKUP_DIR"
log "Backup size: $BACKUP_SIZE"
log "To restore: cd $CURRENT_BACKUP_DIR && ./restore.sh"

# Success notification
echo
echo "================================================"
echo "✅ BACKUP COMPLETED SUCCESSFULLY"
echo "================================================"
echo "Backup ID: backup_$TIMESTAMP"
echo "Location: $CURRENT_BACKUP_DIR"
echo "Size: $BACKUP_SIZE"
echo "Files: Database, Application, Storage, Environment"
echo "================================================"
echo

exit 0