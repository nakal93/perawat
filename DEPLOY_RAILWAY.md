# Deploy to Railway

This guide walks you through deploying this Laravel 12 + Breeze app to Railway using the default Nixpacks builder. It includes database setup, environment variables, build, and start commands.

## Prerequisites
- Railway account and CLI (optional but recommended)
- This repository pushed to GitHub (or use Railway GitHub integration)

## One-time setup in Railway
1. Create a new project and select "Deploy from GitHub repo". Choose this repo.
2. Railway will auto-detect a service for the app. Keep the default Nixpacks builder.
3. Add a PostgreSQL or MySQL database service (recommended: PostgreSQL on Railway). Note its connection info.

## Environment Variables
Set these in Railway → Variables for the app service:

Required basics
- APP_NAME=Perawat
- APP_ENV=production
- APP_DEBUG=false
- APP_URL=https://<your-subdomain>.up.railway.app
- APP_KEY=base64:... (generate locally with `php artisan key:generate --show` or let the start script generate an ephemeral one; persistent is recommended)

Database (choose one)
- For PostgreSQL (Railway managed DB):
  - DB_CONNECTION=pgsql
  - DB_HOST=<from Railway DB>
  - DB_PORT=5432
  - DB_DATABASE=<from Railway DB>
  - DB_USERNAME=<from Railway DB>
  - DB_PASSWORD=<from Railway DB>
- For MySQL:
  - DB_CONNECTION=mysql
  - DB_HOST=<from Railway DB>
  - DB_PORT=3306
  - DB_DATABASE=<from Railway DB>
  - DB_USERNAME=<from Railway DB>
  - DB_PASSWORD=<from Railway DB>
  - MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt (optional for managed MySQL)

Cache/Queue (defaults are fine)
- CACHE_DRIVER=file (or redis if you add Redis)
- SESSION_DRIVER=file
- QUEUE_CONNECTION=database (or sync)

Mail (if you want real emails in production)
- MAIL_MAILER=smtp
- MAIL_HOST=smtp.gmail.com
- MAIL_PORT=587
- MAIL_USERNAME=<your@gmail.com>
- MAIL_PASSWORD=<your app password>
- MAIL_ENCRYPTION=tls
- MAIL_FROM_ADDRESS=<your@gmail.com>
- MAIL_FROM_NAME="Reset Password"

## Build & Start Commands
Railway Nixpacks will detect PHP and Node from composer.json and package.json.

Build command (Railway → Settings → Build)
- composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader
- npm ci --no-audit --no-fund
- npm run build

Start command (Railway → Settings → Start)
- bash scripts/start-railway.sh (or rely on `Procfile` which already defines `web`)

The start script will:
- Ensure APP_KEY exists (generates ephemeral if missing)
- Run storage:link, optimize:clear
- Run migrate --force (and optionally seed when SEED_ON_BOOT=true)
- Cache config/routes/views/events
- Start the Laravel server bound to 0.0.0.0:$PORT

## Assets (Vite)
`npm run build` produces production assets consumed by `laravel-vite-plugin`. Ensure APP_URL is set correctly so asset URLs resolve.
Also set `NIXPACKS_PHP_ROOT_DIR=/app/public` in Railway Variables so Nixpacks serves from the `public/` directory.

## File Storage
- The app uses `storage/app` and `public/storage`. Railway’s filesystem is ephemeral. For persistent uploads, use a cloud disk (S3, etc.) and set FILESYSTEM_DISK=s3 with corresponding credentials. For quick demos, local storage is fine but will reset on redeploy.

## Health Check
- Optional: Configure a healthcheck to `GET /` in Railway. Ensure your routes return 200.

## Troubleshooting
- 500 errors after deploy: check logs. Common issues are missing APP_KEY or wrong DB credentials.
- "could not find driver" (PDO): ensure the DB driver extension is installed. We include `nixpacks.toml` to install `pdo_mysql` and `pdo_pgsql`. If you still see issues, double-check DB_CONNECTION.
- Asset 404s: verify `npm run build` ran and `APP_URL` is set.
- Migrations stuck: ensure DB variables are set on the app service (not only on the DB service).
- Email not sending: verify SMTP variables and provider allows outbound SMTP.

## Optional: Custom Domain
- Add a domain in Railway, set APP_URL to https://yourdomain and update any OAuth redirects if applicable.

---

Happy shipping! If you’d like, we can also create a minimal GitHub Actions workflow to deploy on push to `main` via Railway CLI.
