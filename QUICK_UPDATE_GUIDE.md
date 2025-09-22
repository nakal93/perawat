# 🚀 Quick Reference: Update Production

## ⚡ Alur Cepat untuk Update Production

### 📱 Di Laptop Anda:
```bash
# 1. Update & Edit
cd ~/projects/perawat
git pull origin main
# [Edit file-file yang diperlukan]
# [Test dengan: php artisan serve]

# 2. Commit & Push
git add .
git commit -m "Deskripsi perubahan"
git push origin main
```

### 🖥️ Di Server Production:
```bash
# 1. Login ke server
ssh user@your-server-ip

# 2. Masuk ke direktori aplikasi
cd /var/www/perawat

# 3. Backup (WAJIB!)
./backup-before-update.sh

# 4. Deploy
./deploy.sh

# 5. Verifikasi
./health-check.sh
```

## 🚨 Jika Ada Error:
```bash
# Rollback segera
cd /var/www/perawat/storage/backups
ls -la  # lihat backup terbaru
./restore-backup-YYYYMMDD-HHMMSS.sh
```

## ✅ Checklist Cepat:
- [ ] Code tested di localhost ✓
- [ ] Pushed ke GitHub ✓  
- [ ] Backup production ✓
- [ ] Deploy berhasil ✓
- [ ] Website normal ✓

---
📖 **Dokumentasi lengkap**: `PRODUCTION_UPDATE_WORKFLOW.md`