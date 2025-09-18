# 🚀 Panduan Deploy ke Railway

Panduan lengkap untuk deploy aplikasi Laravel 12 + Breeze ke Railway menggunakan Nixpacks builder. Termasuk setup database, environment variables, build commands, dan start commands.

## 📋 Prasyarat
- Akun Railway dan Railway CLI (opsional tapi direkomendasikan)
- Repository ini sudah di-push ke GitHub (atau gunakan integrasi GitHub Railway)

## 🏗️ Setup Awal di Railway
1. Buat project baru dan pilih "Deploy from GitHub repo". Pilih repository ini.
2. Railway akan otomatis mendeteksi service untuk aplikasi. Gunakan default Nixpacks builder.
3. Tambahkan service database PostgreSQL atau MySQL (direkomendasikan: PostgreSQL di Railway). Catat informasi koneksinya.

## ⚙️ Environment Variables
Set variabel berikut di Railway → Variables untuk app service:

### Konfigurasi Dasar (Wajib)
- `APP_NAME=Perawat`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://<your-subdomain>.up.railway.app`
- `APP_KEY=base64:...` (generate lokal dengan `php artisan key:generate --show` atau biarkan start script generate ephemeral key; persistent direkomendasikan)

### Database (Pilih salah satu)
**Untuk PostgreSQL (default Railway):**
- `DB_CONNECTION=pgsql`
- `DB_HOST=<dari Railway DB>`
- `DB_PORT=5432`
- `DB_DATABASE=<dari Railway DB>`
- `DB_USERNAME=<dari Railway DB>`
- `DB_PASSWORD=<dari Railway DB>`

**Untuk MySQL:**
- `DB_CONNECTION=mysql`
- `DB_HOST=<dari Railway DB>`
- `DB_PORT=3306`
- `DB_DATABASE=<dari Railway DB>`
- `DB_USERNAME=<dari Railway DB>`
- `DB_PASSWORD=<dari Railway DB>`
- `MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt` (opsional untuk managed MySQL)

### Cache/Queue (default sudah baik)
- `CACHE_DRIVER=file` (atau redis jika menambahkan Redis)
- `SESSION_DRIVER=file`
- `QUEUE_CONNECTION=database` (atau sync)

### Email (jika ingin email real di production)
- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp.gmail.com`
- `MAIL_PORT=587`
- `MAIL_USERNAME=<your@gmail.com>`
- `MAIL_PASSWORD=<your app password>`
- `MAIL_ENCRYPTION=tls`
- `MAIL_FROM_ADDRESS=<your@gmail.com>`
- `MAIL_FROM_NAME="Reset Password"`

### PHP/Nixpacks
- `NIXPACKS_PHP_ROOT_DIR=/app/public`

## 🔨 Build & Start Commands
Railway Nixpacks akan mendeteksi PHP dan Node dari composer.json dan package.json.

### Build command (Railway → Settings → Build)
- `composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader`
- `npm ci --no-audit --no-fund`
- `npm run build`

### Start command (Railway → Settings → Start)
- `bash scripts/start-railway.sh` (atau andalkan `Procfile` yang sudah mendefinisikan `web`)

Start script akan:
- Memastikan APP_KEY ada (generate ephemeral jika hilang)
- Menjalankan storage:link, optimize:clear
- Menjalankan migrate --force (dan opsional seed ketika SEED_ON_BOOT=true)
- Cache config/routes/views/events
- Start Laravel server yang bind ke 0.0.0.0:$PORT

## 🎨 Assets (Vite)
`npm run build` menghasilkan production assets yang dikonsumsi oleh `laravel-vite-plugin`. Pastikan APP_URL di-set dengan benar agar asset URLs dapat resolve.
Juga set `NIXPACKS_PHP_ROOT_DIR=/app/public` di Railway Variables agar Nixpacks serve dari direktori `public/`.

## 💾 File Storage
- Aplikasi menggunakan `storage/app` dan `public/storage`. Filesystem Railway bersifat ephemeral. Untuk upload persisten, gunakan cloud disk (S3, dll) dan set FILESYSTEM_DISK=s3 dengan kredensial yang sesuai. Untuk demo cepat, local storage sudah cukup tapi akan reset saat redeploy.

## ❤️ Health Check
- Opsional: Konfigurasi healthcheck ke `GET /` di Railway. Pastikan routes Anda return 200.

## 🔧 Troubleshooting
- **500 errors setelah deploy**: cek logs. Masalah umum adalah APP_KEY hilang atau kredensial DB salah.
- **"could not find driver" (PDO)**: pastikan driver extension DB ter-install. Nixpacks PHP provider auto-install driver umum. Jika masih ada masalah, double-check DB_CONNECTION.
- **Asset 404s**: verifikasi `npm run build` berjalan dan `APP_URL` di-set.
- **Migrations stuck**: pastikan variabel DB di-set pada app service (bukan hanya pada DB service).
- **Email tidak terkirim**: verifikasi variabel SMTP dan provider mengizinkan outbound SMTP.

## 🌐 Custom Domain (Opsional)
- Tambahkan domain di Railway, set APP_URL ke https://yourdomain dan update OAuth redirects jika applicable.

---

🎉 **Selamat deploy!** Jika perlu, kita juga bisa membuat GitHub Actions workflow minimal untuk deploy on push ke `main` via Railway CLI.

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
