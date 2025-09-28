# Production .env checklist

Set these in your production .env (or secrets manager):

Core
- APP_ENV=production
- APP_DEBUG=false
- APP_URL=https://your-domain.example
- APP_TIMEZONE=Asia/Jakarta
- APP_KEY=base64:... (non-empty)

Session & Cookies
- SESSION_DRIVER=database
- SESSION_SECURE_COOKIE=true
- SESSION_SAME_SITE=lax
- SESSION_LIFETIME=120

Logging
- LOG_CHANNEL=daily
- LOG_LEVEL=info
- LOG_DAILY_DAYS=30

Database & Cache
- DB_CONNECTION=mysql
- CACHE_DRIVER=redis (recommended) or database/file
- QUEUE_CONNECTION=database or redis

Security & Observability
- TELESCOPE_ENABLED=false
- LOG_STACK=daily
- MAIL_MAILER=smtp (for alerts)

Proxy / HTTPS
- TRUSTED_PROXIES=10.10.10.9,127.0.0.1,10.10.10.0/24

Optional
- SESSION_ENCRYPT=true
- AUTH_PASSWORD_TIMEOUT=10800
- AUTH_PASSWORD_BROKER=users

Notes
- Enforce HTTPS at the proxy and enable HSTS in Nginx.
- Rotate APP_PREVIOUS_KEYS when rotating APP_KEY.
- Run migrations and storage:link as part of your deploy.
