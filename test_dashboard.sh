#!/bin/bash

echo "Testing admin dashboard..."

# Login admin dan simpan cookies
COOKIES=$(curl -s -c cookies.txt 
  -d "email=admin@rs.com&password=admin123&_token=$(curl -s http://10.10.10.44/login | grep '_token' | sed 's/.*value="\([^"]*\)".*/\1/')" 
  http://10.10.10.44/login | grep -o 'laravel_session=[^;]*')

# Test dashboard
curl -b cookies.txt -s http://10.10.10.44/admin/dashboard | head -c 500Testing admin dashboard access..."

# Login as admin and get session cookie
SESSION=$(curl -c cookies.txt -s -X POST \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@rs.com&password=admin123&_token=$(curl -s http://localhost:8000/login | grep '_token' | sed 's/.*value="\([^"]*\)".*/\1/')" \
  http://localhost:8000/login | grep -o 'laravel_session=[^;]*')

# Test dashboard access with session
curl -b cookies.txt -s http://localhost:8000/admin/dashboard | head -c 500

echo ""
echo "Dashboard test completed"

# Cleanup
rm -f cookies.txt
