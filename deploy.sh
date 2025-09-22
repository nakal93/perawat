#!/bin/bash

# ===========================================
# Production Deployment Script
# ===========================================

# Configuration
APP_DIR="/var/www/perawat"
BACKUP_SCRIPT="$APP_DIR/backup-before-update.sh"
LOG_FILE="/var/log/deployment.log"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging function
log() {
    local message="[$(date +'%Y-%m-%d %H:%M:%S')] $1"
    echo -e "${GREEN}$message${NC}"
    echo "$message" >> "$LOG_FILE"
}

error() {
    local message="[ERROR] $1"
    echo -e "${RED}$message${NC}"
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] $message" >> "$LOG_FILE"
}

warning() {
    local message="[WARNING] $1"
    echo -e "${YELLOW}$message${NC}"
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] $message" >> "$LOG_FILE"
}

info() {
    local message="[INFO] $1"
    echo -e "${BLUE}$message${NC}"
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] $message" >> "$LOG_FILE"
}

# Function to check if command was successful
check_status() {
    if [ $? -eq 0 ]; then
        log "✅ $1 completed successfully"
    else
        error "❌ $1 failed!"
        error "Deployment aborted. Check logs for details."
        exit 1
    fi
}

# Function to rollback on failure
rollback() {
    error "Deployment failed! Starting rollback process..."
    
    # Find latest backup
    LATEST_BACKUP=$(ls -t /var/www/backups/ | grep "backup_" | head -n 1)
    
    if [ -n "$LATEST_BACKUP" ]; then
        warning "Rolling back to: $LATEST_BACKUP"
        cd "/var/www/backups/$LATEST_BACKUP"
        ./restore.sh
    else
        error "No backup found for rollback!"
    fi
    
    exit 1
}

# Trap errors for automatic rollback
trap rollback ERR

# Start deployment
echo
echo "================================================"
echo "🚀 STARTING PRODUCTION DEPLOYMENT"
echo "================================================"
echo "Timestamp: $(date)"
echo "Application: $APP_DIR"
echo "================================================"
echo

# Check if we're in the right directory
if [ ! -f "$APP_DIR/artisan" ]; then
    error "Laravel application not found in $APP_DIR"
    exit 1
fi

cd "$APP_DIR"

# Check Git status
log "Checking Git repository status..."
git fetch origin main
BEHIND=$(git rev-list HEAD..origin/main --count)

if [ "$BEHIND" -eq 0 ]; then
    warning "No new commits to deploy. Application is up to date."
    echo "Current commit: $(git log -1 --oneline)"
    exit 0
fi

info "Found $BEHIND new commit(s) to deploy"
echo "Current commit: $(git log -1 --oneline)"
echo "Latest commit: $(git log origin/main -1 --oneline)"

# Confirmation prompt
echo
read -p "Continue with deployment? (yes/no): " confirm
if [ "$confirm" != "yes" ]; then
    log "Deployment cancelled by user."
    exit 0
fi

echo
log "Starting deployment process..."

# Step 1: Create backup
log "Step 1/12: Creating backup before update..."
if [ -f "$BACKUP_SCRIPT" ]; then
    $BACKUP_SCRIPT
    check_status "Backup creation"
else
    error "Backup script not found: $BACKUP_SCRIPT"
    exit 1
fi

# Step 2: Enable maintenance mode
log "Step 2/12: Enabling maintenance mode..."
php artisan down --message="Sedang update aplikasi, mohon tunggu..." --retry=60
check_status "Maintenance mode activation"

# Step 3: Pull latest changes
log "Step 3/12: Pulling latest changes from Git..."
git pull origin main
check_status "Git pull"

# Step 4: Update Composer dependencies
log "Step 4/12: Updating Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction
check_status "Composer install"

# Step 5: Update NPM dependencies
log "Step 5/12: Updating NPM dependencies..."
npm ci --production --silent
check_status "NPM install"

# Step 6: Clear all caches
log "Step 6/12: Clearing application caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
check_status "Cache clearing"

# Step 7: Run database migrations
log "Step 7/12: Running database migrations..."
php artisan migrate --force
check_status "Database migrations"

# Step 8: Rebuild optimized files
log "Step 8/12: Rebuilding optimized files..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
check_status "Cache rebuilding"

# Step 9: Build frontend assets
log "Step 9/12: Building frontend assets..."
npm run build
check_status "Frontend build"

# Step 10: Set proper permissions
log "Step 10/12: Setting proper file permissions..."
sudo chown -R www-data:www-data "$APP_DIR"
sudo chmod -R 755 "$APP_DIR"
sudo chmod -R 775 "$APP_DIR/storage"
sudo chmod -R 775 "$APP_DIR/bootstrap/cache"
check_status "Permission setting"

# Step 11: Restart services
log "Step 11/12: Restarting web services..."
sudo systemctl reload nginx
sudo systemctl restart php8.4-fpm
check_status "Service restart"

# Step 12: Disable maintenance mode
log "Step 12/12: Disabling maintenance mode..."
php artisan up
check_status "Maintenance mode deactivation"

# Post-deployment checks
log "Running post-deployment checks..."

# Check if website is accessible
info "Testing website accessibility..."
sleep 5
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://perawat.cloudrsdm.my.id)

if [ "$HTTP_CODE" = "200" ]; then
    log "✅ Website is accessible (HTTP $HTTP_CODE)"
else
    warning "⚠️ Website returned HTTP code: $HTTP_CODE"
fi

# Check application logs for errors
info "Checking for recent errors in logs..."
ERROR_COUNT=$(tail -n 100 "$APP_DIR/storage/logs/laravel.log" 2>/dev/null | grep -i error | wc -l)

if [ "$ERROR_COUNT" -eq 0 ]; then
    log "✅ No recent errors in application logs"
else
    warning "⚠️ Found $ERROR_COUNT recent error(s) in logs"
fi

# Display deployment summary
echo
echo "================================================"
echo "✅ DEPLOYMENT COMPLETED SUCCESSFULLY"
echo "================================================"
echo "Deployment Time: $(date)"
echo "New Commit: $(git log -1 --oneline)"
echo "Website Status: HTTP $HTTP_CODE"
echo "Recent Errors: $ERROR_COUNT"
echo "================================================"
echo

# Log deployment completion
log "Deployment completed successfully!"
log "New commit deployed: $(git log -1 --oneline)"

# Optional: Send notification (uncomment if needed)
# curl -X POST -H 'Content-type: application/json' \
#     --data '{"text":"✅ Production deployment completed successfully!"}' \
#     YOUR_SLACK_WEBHOOK_URL

echo "🎉 Deployment finished! Application is now live with latest changes."
echo

exit 0