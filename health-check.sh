#!/bin/bash

# =============================================================================
# Production Health Check Script
# =============================================================================
# Memeriksa status kesehatan aplikasi Laravel di production
# Gunakan script ini setelah setiap deployment untuk memastikan semuanya berjalan normal
# =============================================================================

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
APP_DIR="/var/www/perawat"
APP_URL="https://perawat.cloudrsdm.my.id"
LOG_FILE="$APP_DIR/storage/logs/health-check.log"

echo -e "${BLUE}🔍 Production Health Check Started$(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo "=============================================================="

# Function to log results
log_result() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" >> "$LOG_FILE"
}

# Function to check service status
check_service() {
    local service_name=$1
    if systemctl is-active --quiet "$service_name"; then
        echo -e "✅ ${GREEN}$service_name is running${NC}"
        log_result "SUCCESS: $service_name is running"
        return 0
    else
        echo -e "❌ ${RED}$service_name is not running${NC}"
        log_result "ERROR: $service_name is not running"
        return 1
    fi
}

# Function to check database connection
check_database() {
    echo -e "${BLUE}📊 Checking Database Connection...${NC}"
    
    cd "$APP_DIR"
    if php artisan migrate:status > /dev/null 2>&1; then
        echo -e "✅ ${GREEN}Database connection successful${NC}"
        log_result "SUCCESS: Database connection working"
        return 0
    else
        echo -e "❌ ${RED}Database connection failed${NC}"
        log_result "ERROR: Database connection failed"
        return 1
    fi
}

# Function to check disk space
check_disk_space() {
    echo -e "${BLUE}💾 Checking Disk Space...${NC}"
    
    local usage=$(df -h / | awk 'NR==2 {print $5}' | sed 's/%//')
    
    if [ "$usage" -lt 80 ]; then
        echo -e "✅ ${GREEN}Disk usage: ${usage}% (OK)${NC}"
        log_result "SUCCESS: Disk usage ${usage}% is normal"
        return 0
    elif [ "$usage" -lt 90 ]; then
        echo -e "⚠️ ${YELLOW}Disk usage: ${usage}% (Warning)${NC}"
        log_result "WARNING: Disk usage ${usage}% is high"
        return 1
    else
        echo -e "❌ ${RED}Disk usage: ${usage}% (Critical)${NC}"
        log_result "CRITICAL: Disk usage ${usage}% is critical"
        return 1
    fi
}

# Function to check website accessibility
check_website() {
    echo -e "${BLUE}🌐 Checking Website Accessibility...${NC}"
    
    local http_code=$(curl -s -o /dev/null -w "%{http_code}" "$APP_URL")
    
    if [ "$http_code" -eq 200 ]; then
        echo -e "✅ ${GREEN}Website is accessible (HTTP $http_code)${NC}"
        log_result "SUCCESS: Website accessible with HTTP $http_code"
        return 0
    else
        echo -e "❌ ${RED}Website is not accessible (HTTP $http_code)${NC}"
        log_result "ERROR: Website not accessible, HTTP code: $http_code"
        return 1
    fi
}

# Function to check Laravel application
check_laravel_app() {
    echo -e "${BLUE}🚀 Checking Laravel Application...${NC}"
    
    cd "$APP_DIR"
    
    # Check if artisan is working
    if php artisan --version > /dev/null 2>&1; then
        echo -e "✅ ${GREEN}Laravel Artisan is working${NC}"
        log_result "SUCCESS: Laravel Artisan working"
    else
        echo -e "❌ ${RED}Laravel Artisan is not working${NC}"
        log_result "ERROR: Laravel Artisan not working"
        return 1
    fi
    
    # Check if app is in production mode
    local app_env=$(php artisan env:get APP_ENV 2>/dev/null || echo "unknown")
    if [ "$app_env" = "production" ]; then
        echo -e "✅ ${GREEN}App is in production mode${NC}"
        log_result "SUCCESS: App in production mode"
    else
        echo -e "⚠️ ${YELLOW}App environment: $app_env${NC}"
        log_result "WARNING: App environment is $app_env, not production"
    fi
    
    # Check if caches are optimized
    if [ -f "bootstrap/cache/config.php" ] && [ -f "bootstrap/cache/routes-v7.php" ]; then
        echo -e "✅ ${GREEN}Application is optimized${NC}"
        log_result "SUCCESS: Application caches are optimized"
    else
        echo -e "⚠️ ${YELLOW}Application caches not optimized${NC}"
        log_result "WARNING: Application caches not optimized"
    fi
}

# Function to check logs for recent errors
check_recent_errors() {
    echo -e "${BLUE}📋 Checking Recent Errors...${NC}"
    
    local error_count=$(find "$APP_DIR/storage/logs" -name "*.log" -mtime -1 -exec grep -c "ERROR\|CRITICAL\|emergency" {} + 2>/dev/null | awk '{sum+=$1} END {print sum+0}')
    
    if [ "$error_count" -eq 0 ]; then
        echo -e "✅ ${GREEN}No recent errors found${NC}"
        log_result "SUCCESS: No recent errors in logs"
        return 0
    elif [ "$error_count" -lt 10 ]; then
        echo -e "⚠️ ${YELLOW}Found $error_count recent errors${NC}"
        log_result "WARNING: Found $error_count recent errors"
        return 1
    else
        echo -e "❌ ${RED}Found $error_count recent errors (Critical)${NC}"
        log_result "CRITICAL: Found $error_count recent errors"
        return 1
    fi
}

# Function to check SSL certificate
check_ssl() {
    echo -e "${BLUE}🔒 Checking SSL Certificate...${NC}"
    
    local ssl_info=$(curl -s -I "$APP_URL" | grep -i "HTTP")
    
    if echo "$ssl_info" | grep -q "200"; then
        echo -e "✅ ${GREEN}SSL is working properly${NC}"
        log_result "SUCCESS: SSL certificate working"
        return 0
    else
        echo -e "❌ ${RED}SSL certificate issue${NC}"
        log_result "ERROR: SSL certificate issue"
        return 1
    fi
}

# Main health check execution
main() {
    local total_checks=0
    local passed_checks=0
    
    echo -e "${BLUE}Starting comprehensive health check...${NC}\n"
    
    # System Services
    echo -e "${BLUE}🔧 System Services${NC}"
    ((total_checks++)); check_service "nginx" && ((passed_checks++))
    ((total_checks++)); check_service "php8.4-fpm" && ((passed_checks++))
    ((total_checks++)); check_service "mariadb" && ((passed_checks++))
    echo ""
    
    # Database
    ((total_checks++)); check_database && ((passed_checks++))
    echo ""
    
    # System Resources
    ((total_checks++)); check_disk_space && ((passed_checks++))
    echo ""
    
    # Website & Application
    ((total_checks++)); check_website && ((passed_checks++))
    echo ""
    ((total_checks++)); check_laravel_app && ((passed_checks++))
    echo ""
    
    # Security & Logs
    ((total_checks++)); check_ssl && ((passed_checks++))
    echo ""
    ((total_checks++)); check_recent_errors && ((passed_checks++))
    
    # Summary
    echo "=============================================================="
    echo -e "${BLUE}📊 Health Check Summary${NC}"
    echo "Total Checks: $total_checks"
    echo "Passed: $passed_checks"
    echo "Failed: $((total_checks - passed_checks))"
    
    local success_rate=$((passed_checks * 100 / total_checks))
    
    if [ "$success_rate" -eq 100 ]; then
        echo -e "🎉 ${GREEN}Overall Status: EXCELLENT ($success_rate%)${NC}"
        log_result "SUCCESS: Health check passed $passed_checks/$total_checks tests"
        return 0
    elif [ "$success_rate" -ge 80 ]; then
        echo -e "⚠️ ${YELLOW}Overall Status: GOOD ($success_rate%)${NC}"
        log_result "WARNING: Health check passed $passed_checks/$total_checks tests"
        return 1
    else
        echo -e "❌ ${RED}Overall Status: POOR ($success_rate%)${NC}"
        log_result "CRITICAL: Health check passed only $passed_checks/$total_checks tests"
        return 2
    fi
}

# Run main function
main "$@"

# Exit with appropriate code
exit $?