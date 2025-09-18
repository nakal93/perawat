#!/usr/bin/env bash

# A simple, production-friendly start script for Laravel on Railway.
# - Ensures APP_KEY is set (generates ephemeral key if missing)
# - Links storage, runs migrations, and caches config/routes/views/events
# - Boots the Laravel dev server binding to 0.0.0.0:$PORT (expected by Railway)

set -euo pipefail

echo "[start-railway] PHP version: $(php -v | head -n1)"
echo "[start-railway] Node version: $(node -v 2>/dev/null || echo 'not installed')"
echo "[start-railway] NPM version: $(npm -v 2>/dev/null || echo 'not installed')"

# Ensure we are in project root (directory containing artisan)
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."

# Honor Railway PORT variable, default to 8000 for local runs
export PORT="${PORT:-8000}"
export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"

echo "[start-railway] APP_ENV=$APP_ENV APP_DEBUG=$APP_DEBUG PORT=$PORT"

# If APP_KEY is not provided by environment, generate an ephemeral one for this process
if [ -z "${APP_KEY:-}" ]; then
  echo "[start-railway] APP_KEY is empty; generating ephemeral key for runtime..."
  GENERATED_KEY=$(php artisan key:generate --show)
  export APP_KEY="$GENERATED_KEY"
  echo "[start-railway] Generated APP_KEY. For persistent deployments, set APP_KEY in Railway Variables."
fi

echo "[start-railway] Running storage:link (will ignore if already exists)"
php artisan storage:link || true

echo "[start-railway] Clearing caches (fresh start)"
php artisan optimize:clear || true

echo "[start-railway] Running database migrations"
php artisan migrate --force --no-interaction || true

if [ "${SEED_ON_BOOT:-false}" = "true" ]; then
  echo "[start-railway] Running database seeders (SEED_ON_BOOT=true)"
  php artisan db:seed --force --no-interaction || true
fi

echo "[start-railway] Building caches"
php artisan config:cache
php artisan route:cache || true
php artisan view:cache || true
php artisan event:cache || true

echo "[start-railway] Starting Laravel server on 0.0.0.0:$PORT"
exec php artisan serve --host=0.0.0.0 --port="$PORT"
