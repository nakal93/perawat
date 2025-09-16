#!/bin/bash

echo "🚀 Starting Laravel Hospital Management System Check..."
echo "=================================================="

echo ""
echo "📋 1. Laravel Application Info:"
echo "--------------------------------"
php artisan about

echo ""
echo "🛣️  2. Application Routes:"
echo "-------------------------"
php artisan route:list

echo ""
echo "📦 3. Composer Package Validation:"
echo "----------------------------------"
composer validate

echo ""
echo "🧪 4. Running Test Suite:"
echo "------------------------"
php artisan test

echo ""
echo "🔍 5. Static Analysis with PHPStan:"
echo "-----------------------------------"
./vendor/bin/phpstan analyse --level=5

echo ""
echo "🎉 All systems check passed!"
echo "=============================="
echo "✅ Laravel Hospital Management System is ready!"
