#!/bin/bash

# ===========================================
# Environment Management Script
# ===========================================

# Configuration
APP_DIR="/var/www/perawat"
ENV_BACKUP_DIR="/var/www/backups/env-backups"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
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

info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Help function
show_help() {
    echo "Environment Management Script"
    echo "============================="
    echo
    echo "Usage: $0 [COMMAND]"
    echo
    echo "Commands:"
    echo "  backup      Create backup of current .env file"
    echo "  restore     Restore .env from backup"
    echo "  list        List available .env backups"
    echo "  diff        Show differences between environments"
    echo "  validate    Validate current .env configuration"
    echo "  template    Create .env template with required variables"
    echo "  help        Show this help message"
    echo
    echo "Examples:"
    echo "  $0 backup"
    echo "  $0 restore backup_20241222_143052"
    echo "  $0 validate"
    echo
}

# Create backup directory if not exists
ensure_backup_dir() {
    if [ ! -d "$ENV_BACKUP_DIR" ]; then
        mkdir -p "$ENV_BACKUP_DIR"
        log "Created environment backup directory: $ENV_BACKUP_DIR"
    fi
}

# Backup current .env file
backup_env() {
    ensure_backup_dir
    
    if [ ! -f "$APP_DIR/.env" ]; then
        error ".env file not found in $APP_DIR"
        return 1
    fi
    
    local timestamp=$(date +"%Y%m%d_%H%M%S")
    local backup_file="$ENV_BACKUP_DIR/env_backup_$timestamp"
    
    cp "$APP_DIR/.env" "$backup_file"
    
    if [ $? -eq 0 ]; then
        log "Environment backup created: env_backup_$timestamp"
        echo "Backup location: $backup_file"
        
        # Create info file
        cat > "$backup_file.info" << EOF
Environment Backup Information
==============================
Created: $(date)
Source: $APP_DIR/.env
Git Commit: $(cd "$APP_DIR" && git log -1 --oneline 2>/dev/null || echo "Not available")
Server: $(hostname)
User: $(whoami)

Key Variables:
APP_NAME=$(grep "^APP_NAME=" "$APP_DIR/.env" | cut -d'=' -f2-)
APP_ENV=$(grep "^APP_ENV=" "$APP_DIR/.env" | cut -d'=' -f2-)
APP_URL=$(grep "^APP_URL=" "$APP_DIR/.env" | cut -d'=' -f2-)
DB_DATABASE=$(grep "^DB_DATABASE=" "$APP_DIR/.env" | cut -d'=' -f2-)
EOF
        
        return 0
    else
        error "Failed to create environment backup"
        return 1
    fi
}

# List available backups
list_backups() {
    ensure_backup_dir
    
    echo "Available Environment Backups:"
    echo "=============================="
    
    if [ ! "$(ls -A $ENV_BACKUP_DIR 2>/dev/null)" ]; then
        warning "No environment backups found"
        return 0
    fi
    
    for backup in "$ENV_BACKUP_DIR"/env_backup_*; do
        if [ -f "$backup" ]; then
            local filename=$(basename "$backup")
            local size=$(stat -c%s "$backup")
            local date=$(stat -c%y "$backup" | cut -d' ' -f1,2 | cut -d'.' -f1)
            
            echo "📁 $filename"
            echo "   Size: $size bytes"
            echo "   Date: $date"
            
            # Show info if available
            if [ -f "$backup.info" ]; then
                local app_env=$(grep "^APP_ENV=" "$backup.info" | cut -d'=' -f2-)
                local app_url=$(grep "^APP_URL=" "$backup.info" | cut -d'=' -f2-)
                echo "   Environment: $app_env"
                echo "   URL: $app_url"
            fi
            echo
        fi
    done
}

# Restore .env from backup
restore_env() {
    local backup_name="$1"
    
    if [ -z "$backup_name" ]; then
        error "Backup name required. Use 'list' command to see available backups."
        return 1
    fi
    
    local backup_file="$ENV_BACKUP_DIR/$backup_name"
    
    if [ ! -f "$backup_file" ]; then
        error "Backup file not found: $backup_file"
        echo "Available backups:"
        list_backups
        return 1
    fi
    
    # Create current backup before restore
    warning "Creating backup of current .env before restore..."
    backup_env
    
    echo "Restoring environment from: $backup_name"
    read -p "Are you sure? This will overwrite current .env (yes/no): " confirm
    
    if [ "$confirm" != "yes" ]; then
        log "Restore cancelled"
        return 0
    fi
    
    cp "$backup_file" "$APP_DIR/.env"
    
    if [ $? -eq 0 ]; then
        log "Environment restored successfully from $backup_name"
        
        # Clear Laravel caches
        cd "$APP_DIR"
        php artisan config:clear
        php artisan cache:clear
        
        log "Laravel caches cleared"
        warning "Remember to restart web services if needed"
        return 0
    else
        error "Failed to restore environment"
        return 1
    fi
}

# Validate current .env configuration
validate_env() {
    if [ ! -f "$APP_DIR/.env" ]; then
        error ".env file not found in $APP_DIR"
        return 1
    fi
    
    echo "Validating Environment Configuration"
    echo "===================================="
    
    # Required variables for Laravel
    local required_vars=(
        "APP_NAME"
        "APP_ENV"
        "APP_KEY"
        "APP_DEBUG"
        "APP_URL"
        "DB_CONNECTION"
        "DB_HOST"
        "DB_PORT"
        "DB_DATABASE"
        "DB_USERNAME"
        "DB_PASSWORD"
    )
    
    local missing_vars=()
    local validation_passed=true
    
    for var in "${required_vars[@]}"; do
        if ! grep -q "^${var}=" "$APP_DIR/.env"; then
            missing_vars+=("$var")
            validation_passed=false
        fi
    done
    
    if [ "$validation_passed" = true ]; then
        log "✅ All required environment variables are present"
    else
        error "❌ Missing required environment variables:"
        for var in "${missing_vars[@]}"; do
            echo "  - $var"
        done
    fi
    
    # Check specific values
    echo
    info "Current Configuration:"
    echo "APP_ENV: $(grep "^APP_ENV=" "$APP_DIR/.env" | cut -d'=' -f2-)"
    echo "APP_DEBUG: $(grep "^APP_DEBUG=" "$APP_DIR/.env" | cut -d'=' -f2-)"
    echo "APP_URL: $(grep "^APP_URL=" "$APP_DIR/.env" | cut -d'=' -f2-)"
    echo "DB_DATABASE: $(grep "^DB_DATABASE=" "$APP_DIR/.env" | cut -d'=' -f2-)"
    
    # Security checks
    echo
    info "Security Checks:"
    
    local app_env=$(grep "^APP_ENV=" "$APP_DIR/.env" | cut -d'=' -f2-)
    local app_debug=$(grep "^APP_DEBUG=" "$APP_DIR/.env" | cut -d'=' -f2-)
    
    if [ "$app_env" = "production" ]; then
        log "✅ APP_ENV is set to production"
    else
        warning "⚠️ APP_ENV is not set to production ($app_env)"
    fi
    
    if [ "$app_debug" = "false" ]; then
        log "✅ APP_DEBUG is disabled in production"
    else
        warning "⚠️ APP_DEBUG should be false in production ($app_debug)"
    fi
    
    # Test database connection
    echo
    info "Testing database connection..."
    cd "$APP_DIR"
    
    if php artisan tinker --execute="DB::connection()->getPdo();" 2>/dev/null; then
        log "✅ Database connection successful"
    else
        error "❌ Database connection failed"
        validation_passed=false
    fi
    
    return $validation_passed
}

# Show differences between environments
diff_env() {
    local backup_name="$1"
    
    if [ -z "$backup_name" ]; then
        error "Backup name required for comparison"
        echo "Usage: $0 diff BACKUP_NAME"
        list_backups
        return 1
    fi
    
    local backup_file="$ENV_BACKUP_DIR/$backup_name"
    
    if [ ! -f "$backup_file" ]; then
        error "Backup file not found: $backup_file"
        return 1
    fi
    
    echo "Comparing current .env with $backup_name"
    echo "========================================"
    
    diff -u "$backup_file" "$APP_DIR/.env" || true
}

# Create .env template
create_template() {
    local template_file="$APP_DIR/.env.template"
    
    cat > "$template_file" << 'EOF'
# Laravel Application Configuration Template
# ==========================================

# Application
APP_NAME="Perawat Management System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perawat_db
DB_USERNAME=perawat_user
DB_PASSWORD=your_secure_password

# Cache
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=true

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Security
BCRYPT_ROUNDS=12

# File Storage
FILESYSTEM_DISK=local

# Broadcasting
BROADCAST_DRIVER=log

# Optional Services
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
EOF

    log "Environment template created: $template_file"
    info "Copy this template to .env and configure your values"
}

# Main script logic
case "$1" in
    "backup")
        backup_env
        ;;
    "restore")
        restore_env "$2"
        ;;
    "list")
        list_backups
        ;;
    "diff")
        diff_env "$2"
        ;;
    "validate")
        validate_env
        ;;
    "template")
        create_template
        ;;
    "help"|"")
        show_help
        ;;
    *)
        error "Unknown command: $1"
        show_help
        exit 1
        ;;
esac