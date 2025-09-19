# 🚀 Deploy Langsung ke Railway via CLI (Tanpa GitHub)

Dokumen ini menjelaskan cara deploy aplikasi Laravel ini langsung dari lokal menggunakan Railway CLI, tanpa harus menghubungkan GitHub repository.

---
## ✅ Prasyarat
- Node.js terinstall (untuk install CLI Railway)
- Akun Railway: https://railway.app
- Aplikasi sudah jalan normal di lokal

---
## 🔧 1. Install Railway CLI
```bash
npm i -g @railway/cli
```

Tes instalasi:
```bash
railway --version
```

Login:
```bash
railway login
```
Browser akan terbuka → authorize.

---
## 🏗 2. Inisialisasi Project Railway
Di root project (folder yang ada file artisan):
```bash
railway init
```
Pilih:
- Create New Project → Masukkan nama (misal: perawat-rs)

Atau jika sudah punya project Railway:
```bash
railway link
```

---
## 🗄 3. Tambah Database (Opsional via Dashboard)
Jika belum punya database:
1. Buka dashboard Railway → Project Anda
2. Add → MySQL (atau PostgreSQL)
3. Catat credentials di tab Variables

---
## 📄 4. Siapkan Environment Variables
Gunakan file `.env.railway.example` sebagai referensi.
Set variabel via CLI (contoh MySQL):
```bash
railway variables set \
APP_ENV=production \
APP_DEBUG=false \
APP_TIMEZONE=Asia/Jakarta \
DB_CONNECTION=mysql \
DB_HOST=containers-us-west-12.railway.app \
DB_PORT=12345 \
DB_DATABASE=railway \
DB_USERNAME=root \
DB_PASSWORD=xxxxxx \
MAIL_MAILER=smtp \
MAIL_HOST=sandbox.smtp.mailtrap.io \
MAIL_PORT=2525 \
MAIL_USERNAME=mailtrap_user \
MAIL_PASSWORD=mailtrap_pass \
MAIL_ENCRYPTION=tls \
MAIL_FROM_ADDRESS=noreply@rsdolopo.test \
MAIL_FROM_NAME="RS Dolopo" \
SEED_ON_BOOT=false \
RUN_QUEUE=false
```

Jika ingin seeding otomatis saat pertama kali deploy:
```bash
railway variables set SEED_ON_BOOT=true
```

> APP_KEY boleh dikosongkan. Script startup akan generate otomatis jika belum ada.

---
## 🧪 5. Test Build Lokal (Opsional)
Pastikan dependencies siap:
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

Commit hasil build (opsional; Railway bisa build sendiri jika Node terdeteksi).

---
## 🚀 6. Deploy Pertama Kali
```bash
railway up
```
Railway akan:
1. Upload source code
2. Jalankan build (composer install + npm build jika diperlukan)
3. Jalankan perintah dari `Procfile` → `scripts/start-railway.sh`

---
## 🧩 7. Apa yang Dilakukan Script Startup?
`scripts/start-railway.sh`:
- Generate `APP_KEY` kalau kosong
- `php artisan storage:link`
- Clear caches
- Jalankan migrations
- (Opsional) Jalankan seeders kalau `SEED_ON_BOOT=true`
- (Opsional) Jalankan queue worker kalau `RUN_QUEUE=true`
- Cache config/route/view/events
- Start server di `0.0.0.0:$PORT`

---
## 🔄 8. Redeploy Setelah Ada Perubahan
Setiap kali update code:
```bash
git add .
git commit -m "feat: update fitur x"
railway up
```
(Anda tidak wajib push ke GitHub untuk redeploy.)

---
## 🧪 9. Verifikasi Deployment
Buka URL yang diberikan Railway (contoh: https://perawat-rs.up.railway.app)
Cek:
- /login menampilkan halaman login
- Lupa password mengirim email (cek Mailtrap)
- Migrasi sukses (cek error 500 jika gagal)

---
## 🛠 10. Menjalankan Perintah Artisan Manual
Gunakan fitur "Actions" di dashboard Railway atau shell ephemeral (jika tersedia). Alternatif: tambahkan route sementara (hapus setelah selesai) untuk operasi khusus (misal re-run seeder).

Contoh eksekusi artisan via Railway CLI (jika shell tersedia):
```bash
railway run php artisan migrate --force
```

---
## 📦 11. Queue Worker (Opsional)
Set variabel agar worker otomatis jalan:
```bash
railway variables set RUN_QUEUE=true
```
Script akan menjalankan:
```
php artisan queue:work --tries=3 --timeout=90 &
```

---
## 🧹 12. Maintenance & Logs
Lihat logs:
```bash
railway logs
```
Filter error saja:
```bash
railway logs | grep -i error
```

---
## ⚠️ Troubleshooting Cepat
| Issue | Penyebab | Solusi |
|-------|----------|--------|
| 500 Error awal | APP_KEY kosong | Redeploy, script akan generate | 
| DB connection refused | DB_HOST/PORT salah | Copy ulang dari dashboard |
| Migrasi tidak jalan | Hak akses DB | Pastikan user DB benar |
| Email tidak terkirim | MAIL_* salah | Test dengan Mailtrap dulu |
| Static asset 404 | Belum build | Jalankan `npm run build` lalu deploy |
| Timeout | Cold start | Tunggu 1-2 menit |

---
## 🛡 Rekomendasi Production
- Set `APP_DEBUG=false`
- Set `LOG_LEVEL=warning` atau `error` untuk kurangi noise
- Tambah monitoring (Sentry / Logtail) jika perlu
- Gunakan Mail provider production (misal: SendGrid) sebelum go-live

---
## 🧾 Ringkasan Variabel Penting
| Nama | Wajib | Contoh |
|------|-------|--------|
| APP_ENV | Ya | production |
| APP_KEY | Opsional (auto) | base64:xxxx |
| DB_CONNECTION | Ya | mysql / pgsql |
| DB_HOST | Ya | containers-us-west-12.railway.app |
| DB_PORT | Ya | 3306 / 5432 |
| DB_DATABASE | Ya | railway |
| DB_USERNAME | Ya | root |
| DB_PASSWORD | Ya | ******** |
| MAIL_MAILER | Ya | smtp |
| MAIL_HOST | Ya | sandbox.smtp.mailtrap.io |
| MAIL_PORT | Ya | 2525 |
| MAIL_USERNAME | Ya | ******** |
| MAIL_PASSWORD | Ya | ******** |
| SEED_ON_BOOT | Opsional | true/false |
| RUN_QUEUE | Opsional | true/false |

---
## ✅ Selesai
Anda sekarang bisa deploy langsung tanpa GitHub. Jika ingin migrasi ke GitHub di kemudian hari, cukup push repository dan hubungkan di dashboard.

Butuh tambahan otomatisasi (misal backup DB harian)? Tinggal beri tahu saya. 😉
