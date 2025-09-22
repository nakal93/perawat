#!/bin/bash

# =============================================================================
# Production Monitoring & Alerting Script
# =============================================================================
# Script untuk monitoring berkelanjutan dan alerting otomatis
# Jalankan sebagai cron job untuk monitoring 24/7
# =============================================================================

# Configuration
APP_DIR="/var/www/perawat"
MONITOR_LOG="$APP_DIR/storage/logs/monitoring.log"
ALERT_LOG="$APP_DIR/storage/logs/alerts.log"
HEALTH_CHECK_SCRIPT="$APP_DIR/health-check.sh"

# Alert thresholds
DISK_THRESHOLD=85
MEMORY_THRESHOLD=80
CPU_THRESHOLD=80
ERROR_THRESHOLD=5

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Function to log with timestamp
log_with_timestamp() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" >> "$MONITOR_LOG"
}

# Function to send alert
send_alert() {
    local alert_type=$1
    local message=$2
    
    echo "$(date '+%Y-%m-%d %H:%M:%S') - ALERT [$alert_type]: $message" >> "$ALERT_LOG"
    
    # You can add email notification here if needed
    # echo "$message" | mail -s "Production Alert: $alert_type" admin@yourdomain.com
    
    echo -e "${RED}🚨 ALERT [$alert_type]: $message${NC}"
}

# Function to check system resources
check_system_resources() {
    # Check disk usage
    local disk_usage=$(df -h / | awk 'NR==2 {print $5}' | sed 's/%//')
    if [ "$disk_usage" -gt "$DISK_THRESHOLD" ]; then
        send_alert "DISK" "Disk usage is $disk_usage% (threshold: $DISK_THRESHOLD%)"
    fi
    
    # Check memory usage
    local memory_usage=$(free | awk 'NR==2{printf "%.0f", $3*100/$2}')
    if [ "$memory_usage" -gt "$MEMORY_THRESHOLD" ]; then
        send_alert "MEMORY" "Memory usage is $memory_usage% (threshold: $MEMORY_THRESHOLD%)"
    fi
    
    # Check CPU load average
    local cpu_load=$(uptime | awk -F'load average:' '{print $2}' | awk '{print $1}' | sed 's/,//')
    local cpu_cores=$(nproc)
    local cpu_percentage=$(echo "scale=0; $cpu_load * 100 / $cpu_cores" | bc 2>/dev/null || echo "0")
    
    if [ "$cpu_percentage" -gt "$CPU_THRESHOLD" ]; then
        send_alert "CPU" "CPU load is $cpu_percentage% (threshold: $CPU_THRESHOLD%)"
    fi
    
    log_with_timestamp "Resources - Disk: $disk_usage%, Memory: $memory_usage%, CPU: $cpu_percentage%"
}

# Function to check services
check_critical_services() {
    local services=("nginx" "php8.4-fpm" "mariadb")
    
    for service in "${services[@]}"; do
        if ! systemctl is-active --quiet "$service"; then
            send_alert "SERVICE" "$service is not running!"
            
            # Try to restart the service
            echo "Attempting to restart $service..."
            systemctl restart "$service"
            
            # Check if restart was successful
            sleep 5
            if systemctl is-active --quiet "$service"; then
                log_with_timestamp "Successfully restarted $service"
            else
                send_alert "SERVICE" "Failed to restart $service - manual intervention required"
            fi
        else
            log_with_timestamp "$service is running normally"
        fi
    done
}

# Function to check application health
check_application_health() {
    cd "$APP_DIR"
    
    # Run health check script
    if [ -f "$HEALTH_CHECK_SCRIPT" ]; then
        local health_result=$("$HEALTH_CHECK_SCRIPT" 2>&1)
        local health_exit_code=$?
        
        if [ $health_exit_code -eq 0 ]; then
            log_with_timestamp "Application health check passed"
        elif [ $health_exit_code -eq 1 ]; then
            log_with_timestamp "Application health check passed with warnings"
        else
            send_alert "APP" "Application health check failed - critical issues detected"
        fi
    fi
    
    # Check for recent errors in Laravel logs
    local recent_errors=$(find storage/logs -name "*.log" -mtime -0.1 -exec grep -c "ERROR\|CRITICAL" {} + 2>/dev/null | awk '{sum+=$1} END {print sum+0}')
    
    if [ "$recent_errors" -gt "$ERROR_THRESHOLD" ]; then
        send_alert "ERRORS" "High error rate detected: $recent_errors errors in last 2.4 hours"
    fi
    
    log_with_timestamp "Recent errors: $recent_errors"
}

# Function to check SSL certificate expiration
check_ssl_expiry() {
    local domain="perawat.cloudrsdm.my.id"
    local expiry_date=$(echo | openssl s_client -servername "$domain" -connect "$domain":443 2>/dev/null | openssl x509 -noout -dates | grep notAfter | cut -d= -f2)
    
    if [ -n "$expiry_date" ]; then
        local expiry_timestamp=$(date -d "$expiry_date" +%s)
        local current_timestamp=$(date +%s)
        local days_until_expiry=$(( (expiry_timestamp - current_timestamp) / 86400 ))
        
        if [ "$days_until_expiry" -lt 7 ]; then
            send_alert "SSL" "SSL certificate expires in $days_until_expiry days"
        elif [ "$days_until_expiry" -lt 30 ]; then
            log_with_timestamp "SSL certificate expires in $days_until_expiry days"
        fi
    fi
}

# Function to check backup integrity
check_backup_status() {
    local backup_dir="$APP_DIR/storage/backups"
    local latest_backup=$(find "$backup_dir" -name "*.tar.gz" -type f -printf '%T@ %p\n' 2>/dev/null | sort -n | tail -1 | cut -d' ' -f2-)
    
    if [ -n "$latest_backup" ]; then
        local backup_age=$(( ($(date +%s) - $(stat -c %Y "$latest_backup")) / 86400 ))
        
        if [ "$backup_age" -gt 2 ]; then
            send_alert "BACKUP" "Latest backup is $backup_age days old"
        else
            log_with_timestamp "Latest backup is $backup_age days old (OK)"
        fi
    else
        send_alert "BACKUP" "No backups found in backup directory"
    fi
}

# Function to cleanup old logs
cleanup_logs() {
    # Keep monitoring logs for 30 days
    find "$APP_DIR/storage/logs" -name "monitoring.log*" -mtime +30 -delete 2>/dev/null
    
    # Keep alert logs for 90 days
    find "$APP_DIR/storage/logs" -name "alerts.log*" -mtime +90 -delete 2>/dev/null
    
    # Rotate current logs if they're too large (>50MB)
    if [ -f "$MONITOR_LOG" ] && [ $(stat -f%z "$MONITOR_LOG" 2>/dev/null || stat -c%s "$MONITOR_LOG" 2>/dev/null || echo 0) -gt 52428800 ]; then
        mv "$MONITOR_LOG" "$MONITOR_LOG.$(date +%Y%m%d_%H%M%S)"
        touch "$MONITOR_LOG"
    fi
    
    if [ -f "$ALERT_LOG" ] && [ $(stat -f%z "$ALERT_LOG" 2>/dev/null || stat -c%s "$ALERT_LOG" 2>/dev/null || echo 0) -gt 52428800 ]; then
        mv "$ALERT_LOG" "$ALERT_LOG.$(date +%Y%m%d_%H%M%S)"
        touch "$ALERT_LOG"
    fi
}

# Main monitoring function
main() {
    echo -e "${BLUE}🔍 Production Monitoring Check - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
    
    log_with_timestamp "=== Monitoring Check Started ==="
    
    # Run all checks
    check_system_resources
    check_critical_services
    check_application_health
    check_ssl_expiry
    check_backup_status
    
    # Cleanup old logs
    cleanup_logs
    
    log_with_timestamp "=== Monitoring Check Completed ==="
    
    echo -e "${GREEN}✅ Monitoring check completed${NC}"
}

# Show usage if no arguments
if [ $# -eq 0 ]; then
    echo "Usage: $0 [check|monitor|status]"
    echo ""
    echo "Commands:"
    echo "  check   - Run one-time monitoring check"
    echo "  monitor - Run continuous monitoring (for cron)"
    echo "  status  - Show monitoring status and recent alerts"
    echo ""
    echo "Add to crontab for continuous monitoring:"
    echo "*/5 * * * * $APP_DIR/monitor.sh monitor"
    exit 1
fi

# Handle command line arguments
case "$1" in
    "check"|"monitor")
        main
        ;;
    "status")
        echo -e "${BLUE}📊 Monitoring Status${NC}"
        echo "==================="
        
        if [ -f "$MONITOR_LOG" ]; then
            echo "Last monitoring check:"
            tail -1 "$MONITOR_LOG"
            echo ""
        fi
        
        if [ -f "$ALERT_LOG" ]; then
            echo "Recent alerts (last 24 hours):"
            grep "$(date -d '1 day ago' '+%Y-%m-%d')\|$(date '+%Y-%m-%d')" "$ALERT_LOG" 2>/dev/null | tail -10
        else
            echo "No recent alerts"
        fi
        ;;
    *)
        echo "Unknown command: $1"
        exit 1
        ;;
esac