# 📧 Panduan Setting Email Production - Sistem RS

## 🎯 Setup Gmail SMTP (Tercepat & Terpercaya)

### 📋 Langkah 1: Generate App Password Gmail

1. **Akses Gmail** di browser dengan akun RS/organisasi
2. **Klik foto profil** (pojok kanan atas) → "Kelola Akun Google Anda"  
3. **Pilih tab "Keamanan"** di menu kiri
4. **Scroll ke "Cara Anda masuk ke Google"**
5. **Aktifkan "Verifikasi 2 Langkah"** jika belum (wajib untuk App Password)
6. **Klik "Sandi aplikasi"** setelah 2-Step aktif
7. **Pilih aplikasi**: "Email" 
8. **Pilih perangkat**: "Lainnya" → ketik "Laravel Sistem RS"
9. **Klik "Buat"**
10. **SIMPAN password 16 digit** yang muncul (format: `xxxx xxxx xxxx xxxx`)

💡 **Tips**: Simpan App Password di password manager untuk keamanan

### ⚙️ Langkah 2: Konfigurasi Laravel .env

Edit file `.env` di root project, ubah section MAIL:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com  
MAIL_PORT=587
MAIL_USERNAME=admin@rsdolopo.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@rsdolopo.com"
MAIL_FROM_NAME="Sistem Informasi RS Dolopo"
```

**⚠️ PENTING - Ganti dengan data Anda:**
- `admin@rsdolopo.com` → Email Gmail organisasi RS
- `xxxx xxxx xxxx xxxx` → App Password 16 digit dari langkah 1
- `"Sistem Informasi RS Dolopo"` → Nama pengirim sesuai RS

### 🔄 Langkah 3: Restart Configuration

Jalankan command untuk apply konfigurasi baru:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### ✅ Langkah 4: Test Functionality

**Test email dengan fitur lupa password:**

1. Akses `http://localhost:8000/forgot-password`
2. Masukkan email user terdaftar (contoh: `admin@rsdolopo.com`)
3. Klik "Kirim Link Reset Password"  
4. Periksa inbox email → klik link reset
5. Set password baru → login dengan password baru

**✅ Indikator sukses:**
- Email masuk ke inbox (bukan spam)
- Link reset berfungsi dengan baik
- Reset password berhasil dan bisa login

---

## 🧪 Alternatif: Mailtrap (Development/Testing)

Untuk testing development tanpa kirim email real:

### 📝 Setup Mailtrap (Free)

1. **Daftar akun** di https://mailtrap.io (gratis)
2. **Buat inbox baru** untuk project
3. **Copy kredensial SMTP** dari dashboard
4. **Update .env untuk testing**:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525  
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@rsdolopo.test"
MAIL_FROM_NAME="RS Dolopo Testing"
```

**💡 Keuntungan Mailtrap:**
- Email tidak dikirim ke inbox real
- Preview semua email di dashboard Mailtrap
- Test HTML email rendering
- Perfect untuk development environment

---

## ⚡ Automation Script

Script otomatis untuk setup Gmail SMTP:

```bash
#!/bin/bash
# Gmail SMTP Auto Setup

# Backup existing .env
cp .env .env.backup

# Update MAIL configuration
sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/' .env  
sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=587/' .env
sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env

# Clear cache
php artisan config:clear
php artisan cache:clear

echo "✅ SMTP setup selesai!"
echo "⚠️  Jangan lupa edit manual:"
echo "   - MAIL_USERNAME=gmail_rs@domain.com"
echo "   - MAIL_PASSWORD=app_password_16_digit"  
echo "   - MAIL_FROM_ADDRESS & MAIL_FROM_NAME"
```

**Jalankan dengan:** `bash setup-gmail.sh`

---

## � Troubleshooting

### ❌ "Failed to authenticate on SMTP server"

**Penyebab umum:**
- App Password salah atau expired
- 2-Step Verification belum aktif
- Username email tidak sesuai dengan App Password

**Solusi:**
1. Generate ulang App Password di Gmail
2. Pastikan copy-paste tanpa spasi extra
3. Restart `php artisan config:clear`
4. Test dengan email sederhana dulu

### ❌ "Connection could not be established"

**Kemungkinan masalah:**
- Port 587 diblokir ISP/firewall
- Koneksi internet tidak stabil
- Server Gmail down (rare)

**Solusi:**
1. Coba port alternatif: `MAIL_PORT=465` dengan `MAIL_ENCRYPTION=ssl`
2. Test koneksi: `telnet smtp.gmail.com 587`
3. Bypass firewall untuk domain gmail.com

### ❌ Email masuk ke Spam

**Penyebab:**
- Domain pengirim tidak trusted
- Content email terlalu promotional
- Volume email tinggi dari IP yang sama

**Solusi:**
1. Setup SPF record untuk domain
2. Gunakan email dengan domain yang sama
3. Avoid spam keywords dalam subject/body
4. Monitor sender reputation

### ❌ Rate limiting

**Laravel batasi 60 emails/hour** secara default untuk security

**Jika perlu lebih:**
```php
// config/mail.php  
'rate_limit' => [
    'attempts' => 100,  // emails per hour
    'decay' => 3600,    // time window
],
```

---

## � Production Checklist

### ✅ Sebelum Go-Live

- [ ] **Email credentials** configured dengan benar
- [ ] **Test forgot password** end-to-end  
- [ ] **Test user registration** email verification
- [ ] **Monitor email delivery** rate dan bounces
- [ ] **Setup email alerts** untuk admin system
- [ ] **Backup email configuration** untuk disaster recovery
- [ ] **Document email troubleshooting** untuk support team

### ✅ Monitoring & Maintenance

- [ ] **Weekly check** email delivery success rate
- [ ] **Monthly review** email logs untuk errors
- [ ] **Update App Password** jika expired (usually 1 year)
- [ ] **Monitor Gmail quotas** dan usage limits
- [ ] **Setup email forwarding** untuk notifikasi penting

---

## 🚀 Hasil Akhir

Setelah setup sukses, sistem email akan support:

✅ **Forgot Password Flow**
- Email reset dikirim ke inbox user
- Link aman dengan expiry 60 menit  
- Password validation kuat
- Auto-redirect setelah reset sukses

✅ **User Registration** 
- Email verification untuk akun baru
- Welcome email dengan informasi login
- Account activation workflow

✅ **System Notifications**
- Alert email untuk admin
- Document approval notifications  
- System maintenance announcements

✅ **Security Features**
- Rate limiting untuk prevent spam
- Email validation untuk security
- Audit trail untuk email activities

**🔗 Test endpoint:** `http://localhost:8000/forgot-password`

**📊 Monitoring:** Check `storage/logs/laravel.log` untuk email debugging