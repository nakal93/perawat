# 🚀 Alur Update Production yang Benar
## Panduan Lengkap: Localhost → Production Server

### 🎯 Tujuan
Dokumen ini menjelaskan cara yang **BENAR** dan **AMAN** untuk mengupdate aplikasi production yang sudah online dengan file development dari laptop/localhost Anda.

---

## � PERINGATAN PENTING
**JANGAN PERNAH:**
- Upload file langsung ke server production via FTP/SFTP
- Edit file langsung di server production
- Copy-paste code manual ke server
- Update tanpa backup terlebih dahulu

**SELALU GUNAKAN:**
- Git workflow yang proper
- Script backup otomatis
- Testing di environment terpisah

---

## 📋 Prasyarat Setup

### 1. Setup Development Environment di Laptop
```bash
# 1. Clone repository ke laptop Anda
cd ~/Documents/projects  # atau folder development Anda
git clone https://github.com/nakal93/perawat.git
cd perawat

# 2. Install dependencies
composer install
npm install

# 3. Setup environment development
cp .env.example .env.local
php artisan key:generate

# 4. Setup database lokal (opsional untuk testing)
# Edit .env.local dengan database lokal Anda
php artisan migrate
php artisan db:seed
```

### 2. Konfigurasi Git di Laptop
```bash
# Setup Git credentials
git config user.name "Nama Anda"
git config user.email "email@anda.com"

# Pastikan remote origin sudah benar
git remote -v
# Origin harus menunjuk ke: https://github.com/nakal93/perawat.git
```

---

## 🔄 ALUR UPDATE PRODUCTION YANG BENAR

### Step 1: Development di Laptop
```bash
# 1. Pastikan di branch yang benar
git checkout main
git pull origin main  # ambil update terbaru

# 2. Buat perubahan di laptop Anda
# - Edit file yang perlu diubah
# - Test di localhost dengan: php artisan serve

# 3. Commit perubahan
git add .
git commit -m "Deskripsi perubahan yang jelas"

# 4. Push ke GitHub
git push origin main
```

### Step 2: Backup Production (WAJIB!)
```bash
# Login ke server production
ssh user@server-ip

# Jalankan backup otomatis
cd /var/www/perawat
./backup-before-update.sh

# Script ini akan:
# - Backup database
# - Backup semua file aplikasi
# - Simpan backup dengan timestamp
# - Buat script restore otomatis
```

### Step 3: Deploy ke Production
```bash
# Masih di server production
# Jalankan script deploy otomatis
./deploy.sh

# Script ini akan:
# 1. Enable maintenance mode
# 2. Backup current state
# 3. Pull latest code dari GitHub
# 4. Update dependencies (composer)
# 5. Run database migrations
# 6. Clear all caches
# 7. Optimize application
# 8. Fix permissions
# 9. Restart services
# 10. Disable maintenance mode
# 11. Verify deployment
# 12. Log deployment status
```

### Step 4: Verifikasi Update
```bash
# 1. Cek status aplikasi
./health-check.sh

# 2. Test website di browser
# https://perawat.cloudrsdm.my.id

# 3. Monitor log untuk error
tail -f storage/logs/laravel.log

# 4. Cek database jika ada perubahan schema
php artisan migrate:status
```

---

## 🛠️ Contoh Workflow Lengkap

### Skenario: Anda ingin menambah fitur baru

#### Di Laptop (Development):
```bash
# 1. Update dari production
cd ~/Documents/projects/perawat
git pull origin main

# 2. Buat perubahan
# - Edit Controller, View, Model sesuai kebutuhan
# - Test dengan: php artisan serve

# 3. Commit & Push
git add .
git commit -m "Tambah fitur laporan karyawan baru"
git push origin main
```

#### Di Server Production:
```bash
# 1. Backup dulu (WAJIB!)
cd /var/www/perawat
./backup-before-update.sh

# 2. Deploy update
./deploy.sh

# 3. Verifikasi
./health-check.sh
```

---

## 🚨 Penanganan Error & Rollback

### Jika Deploy Gagal:
```bash
# 1. Cek log error
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log

# 2. Rollback ke backup terakhir
cd /var/www/perawat/storage/backups
ls -la  # cari backup terbaru

# 3. Jalankan script restore
./restore-backup-YYYYMMDD-HHMMSS.sh
```

### Jika Website Down:
```bash
# 1. Enable maintenance mode
php artisan down

# 2. Rollback database (jika perlu)
mysql -u perawat_user -p perawat_db < storage/backups/backup-YYYYMMDD-HHMMSS.sql

# 3. Restore file (jika perlu)
tar -xzf storage/backups/files-backup-YYYYMMDD-HHMMSS.tar.gz -C /var/www/

# 4. Disable maintenance mode
php artisan up
```

---

## ✅ Best Practices

### DO (Lakukan):
1. **Selalu backup** sebelum update
2. **Test di localhost** sebelum push
3. **Gunakan commit message** yang jelas
4. **Monitor log** setelah deploy
5. **Test website** setelah update
6. **Update di jam sepi** (misal: dini hari)

### DON'T (Jangan):
1. **Jangan edit langsung** di server production
2. **Jangan skip backup** meskipun update kecil
3. **Jangan deploy** tanpa test di localhost
4. **Jangan update** di jam sibuk
5. **Jangan panik** jika ada error (ada backup!)

---

## 📊 Monitoring & Maintenance

### Cek Status Rutin:
```bash
# Setiap hari
./health-check.sh

# Setiap minggu
df -h  # cek disk space
du -sh storage/logs/  # cek ukuran log
```

### Cleanup Rutin:
```bash
# Bersihkan log lama (setiap bulan)
php artisan log:clear

# Bersihkan backup lama (simpan 7 hari terakhir)
find storage/backups/ -name "*.tar.gz" -mtime +7 -delete
find storage/backups/ -name "*.sql" -mtime +7 -delete
```

---

## 🆘 Kontak Darurat

Jika terjadi masalah serius:
1. **Segera rollback** ke backup terakhir
2. **Enable maintenance mode**
3. **Simpan log error** untuk analisis
4. **Hubungi developer** dengan detail error

---

## 📋 Checklist Update

Sebelum setiap update:
- [ ] Code sudah ditest di localhost
- [ ] Commit message sudah jelas
- [ ] Code sudah di-push ke GitHub
- [ ] Backup production sudah dibuat
- [ ] Waktu update sudah tepat (jam sepi)

Setelah update:
- [ ] Deploy script berhasil
- [ ] Website bisa diakses
- [ ] Fitur baru berfungsi
- [ ] Tidak ada error di log
- [ ] Performance masih baik

---

**Ingat: Keamanan dan stabilitas production adalah prioritas utama!**
git pull origin main

# Merge feature branch
git merge feature/nama-fitur

# Push to main
git push origin main

# Hapus feature branch (optional)
git branch -d feature/nama-fitur
git push origin --delete feature/nama-fitur
```

### 2. 🖥️ Update Production Server

#### a) Pre-Deployment Checklist
- [ ] Backup database current
- [ ] Backup files current
- [ ] Test di staging environment (jika ada)
- [ ] Pastikan maintenance window
- [ ] Siapkan rollback plan

#### b) Deployment Process
```bash
# 1. Masuk ke production server
ssh user@server

# 2. Masuk ke application directory
cd /var/www/perawat

# 3. Enable maintenance mode
php artisan down --message="Sedang update aplikasi, mohon tunggu..." --retry=60

# 4. Backup current state
./backup-before-update.sh

# 5. Pull latest changes
git pull origin main

# 6. Update dependencies
composer install --no-dev --optimize-autoloader
npm ci --production

# 7. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 8. Run migrations (if any)
php artisan migrate --force

# 9. Rebuild optimized files
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 10. Build frontend assets
npm run build

# 11. Set proper permissions
sudo chown -R www-data:www-data /var/www/perawat
sudo chmod -R 755 /var/www/perawat
sudo chmod -R 775 /var/www/perawat/storage
sudo chmod -R 775 /var/www/perawat/bootstrap/cache

# 12. Restart services
sudo systemctl reload nginx
sudo systemctl restart php8.4-fpm

# 13. Disable maintenance mode
php artisan up

# 14. Test application
curl -I https://perawat.cloudrsdm.my.id
```

### 3. 🛡️ Safety Measures

#### a) Automated Backup Script
Lokasi: `/var/www/perawat/backup-before-update.sh`

#### b) Rollback Process
```bash
# Jika terjadi masalah, rollback:
# 1. Enable maintenance mode
php artisan down

# 2. Restore from backup
./rollback-to-previous.sh

# 3. Restart services
sudo systemctl reload nginx
sudo systemctl restart php8.4-fpm

# 4. Disable maintenance mode
php artisan up
```

### 4. 📁 File Management

#### Files yang TIDAK boleh di-commit:
- `.env` (environment file production)
- `storage/logs/*` (log files)
- `storage/app/public/*` (uploaded files)
- `node_modules/`
- `vendor/` (akan di-install via composer)

#### Files yang harus di-commit:
- Source code aplikasi
- Migration files
- Seeder files (sample data)
- Configuration files
- Frontend assets (before build)

### 5. 🔧 Best Practices

#### a) Environment Management
- Development: `.env.local`
- Staging: `.env.staging` 
- Production: `.env.production`

#### b) Database Migrations
```bash
# Selalu test migration di local dulu
php artisan migrate --pretend

# Di production, gunakan --force
php artisan migrate --force
```

#### c) Testing Workflow
1. Test di local development
2. Test di staging server (jika ada)
3. Deploy ke production saat traffic rendah
4. Monitor logs setelah deployment

### 6. 🚨 Emergency Procedures

#### a) Hotfix Process
```bash
# Untuk bug critical yang perlu fix cepat:
git checkout main
git checkout -b hotfix/nama-bug
# Fix bug...
git commit -m "Hotfix: Deskripsi bug fix"
git checkout main
git merge hotfix/nama-bug
git push origin main
# Deploy ke production immediately
```

#### b) Quick Rollback Commands
```bash
# Rollback ke commit sebelumnya
git reset --hard HEAD~1
git push --force-with-lease origin main

# Atau rollback ke commit specific
git reset --hard COMMIT_HASH
git push --force-with-lease origin main
```

### 7. 📊 Monitoring

#### a) Post-Deployment Checks
- [ ] Website accessible
- [ ] Login functionality working
- [ ] Database connections active
- [ ] No errors in logs
- [ ] SSL certificate valid
- [ ] Performance metrics normal

#### b) Log Monitoring
```bash
# Monitor application logs
tail -f /var/www/perawat/storage/logs/laravel.log

# Monitor nginx logs
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log

# Monitor PHP-FPM logs
tail -f /var/log/php8.4-fpm.log
```

## 🎯 Summary Commands

### Laptop Development:
```bash
git pull origin main
# ... development work ...
git add .
git commit -m "Description"
git push origin main
```

### Production Update:
```bash
cd /var/www/perawat
php artisan down
./backup-before-update.sh
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
npm run build
sudo chown -R www-data:www-data .
sudo systemctl reload nginx
php artisan up
```

## 📞 Support Contacts
- Repository: https://github.com/nakal93/perawat.git
- Production URL: https://perawat.cloudrsdm.my.id
- Server: Ubuntu dengan Nginx + PHP-FPM