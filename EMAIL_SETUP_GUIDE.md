# 📧 Panduan Konfigurasi Email untuk Sistem RS

Panduan lengkap setup email SMTP untuk fitur forgot password dan notifikasi sistem.

## 🎯 Pilihan Provider Email

### 1. **Gmail (Gratis & Mudah) - DIREKOMENDASIKAN**
✅ Gratis dan mudah setup  
✅ Reliable dan cepat  
✅ Cocok untuk development dan production kecil  
⚠️ Rate limit: 500 email/hari untuk akun gratis

### 2. **Mailtrap (Gratis untuk testing)**
✅ Khusus untuk testing email  
✅ Interface yang bagus untuk debug  
✅ Tidak mengirim email ke user real  
❌ Hanya untuk development

### 3. **SendGrid (Gratis 100 email/hari)**
✅ Professional email service  
✅ Analytics dan tracking  
✅ Rate limit tinggi  
⚠️ Perlu verifikasi domain untuk produksi

### 4. **Mailgun (Gratis untuk domain terverifikasi)**
✅ Powerful email API  
✅ Good untuk high volume  
✅ Advanced features  
⚠️ Setup lebih kompleks

---

## 📧 METODE 1: Gmail SMTP (Termudah)

### 🔑 Langkah 1: Buat App Password Gmail
1. **Login ke Gmail** Anda
2. **Klik foto profil** → "Kelola Akun Google Anda"
3. **Keamanan** → "Verifikasi 2 langkah" (aktifkan jika belum)
4. **Sandi aplikasi** → "Buat sandi aplikasi"
5. **Pilih aplikasi**: Mail
6. **Pilih perangkat**: Computer/Other
7. **Copy password** yang di-generate (16 karakter tanpa spasi)

### ⚙️ Langkah 2: Update File .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your-16-char-app-password
### 🧪 Langkah 3: Test Email Configuration
```bash
# Clear cache konfigurasi
php artisan config:clear

# Test dengan Tinker
php artisan tinker

# Di dalam Tinker, jalankan:
Mail::raw('Test email dari sistem RS', function ($msg) {
    $msg->to('your-test-email@gmail.com')
        ->subject('Test Email Configuration');
});

# Jika berhasil, akan return null tanpa error
# Cek inbox Gmail Anda untuk email test
```

---

## 📧 METODE 2: Mailtrap (Testing Only)

### 🔧 Langkah 1: Setup Mailtrap
1. **Kunjungi**: https://mailtrap.io
2. **Sign up** gratis
3. **Buat inbox** baru
4. **Copy SMTP credentials** dari dashboard

### ⚙️ Langkah 2: Update File .env
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@sistemrs.test"
MAIL_FROM_NAME="Sistem RS Dolopo"
```

> ⚠️ **Note**: Mailtrap tidak mengirim email ke user real. Email akan tampil di inbox Mailtrap untuk testing.

---

## 📧 METODE 3: SendGrid (Production)

### 🔑 Langkah 1: Setup SendGrid Account
1. **Kunjungi**: https://sendgrid.com
2. **Sign up** gratis (100 email/hari, unlimited contacts)
3. **Verify email** dan **complete onboarding**
4. **Settings** → "API Keys" → "Create API Key"
5. **Full Access** atau **Restricted Access** dengan Mail Send permission
6. **Copy API key** yang di-generate

### 🌐 Langkah 2: Verifikasi Domain (Production)
1. **Settings** → "Sender Authentication"
2. **Domain Authentication** → "Authenticate Your Domain"
3. **Follow DNS setup** sesuai provider domain Anda
4. **Verify domain** setelah DNS propagate

### ⚙️ Langkah 3: Update File .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Sistem RS Dolopo"
```

---

## 📧 METODE 4: Mailgun (Advanced)

### 🔑 Langkah 1: Setup Mailgun
1. **Kunjungi**: https://www.mailgun.com
2. **Sign up** dengan kartu kredit (ada free tier)
3. **Add domain** Anda
4. **Verify domain** dengan DNS records
5. **Copy SMTP credentials**

### ⚙️ Langkah 2: Update File .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain.com
MAIL_PASSWORD=your-mailgun-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="Sistem RS Dolopo"
```

---

## � Testing & Troubleshooting

### ✅ Test Email Berhasil
```bash
# Setelah konfigurasi, test dengan:
php artisan config:clear
php artisan test --filter=EmailTest  # jika ada test

# Atau manual test:
php artisan tinker
> Mail::raw('Test berhasil!', fn($m) => $m->to('test@gmail.com')->subject('Test'));
```

### 🔧 Common Issues & Solutions

| ❌ Error | 💡 Solusi |
|----------|-----------|
| **Authentication failed** | Periksa username/password, pastikan App Password Gmail aktif |
| **Connection timeout** | Periksa firewall, coba port 25 atau 465 |
| **SSL certificate problem** | Tambahkan `MAIL_ENCRYPTION=tls` atau `ssl` |
| **Rate limit exceeded** | Gunakan provider dengan limit lebih tinggi |
| **Domain not verified** | Verifikasi domain di SendGrid/Mailgun |

### 📊 Best Practices

#### 🔒 Security
- **Jangan hardcode** credentials di code
- **Gunakan App Passwords** untuk Gmail, bukan password utama
- **Rotate credentials** secara berkala
- **Monitor email usage** untuk deteksi spam

#### ⚡ Performance
- **Cache email templates** untuk high volume
- **Use queues** untuk async email sending
- **Monitor bounce rates** dan blacklist

#### 📈 Production Tips
- **Setup SPF/DKIM** records untuk deliverability
- **Use dedicated IP** untuk high volume
- **Monitor analytics** dari provider
- **Setup bounce handling**

---

## 🎯 Recommendations by Use Case

### 🧪 **Development/Testing**
**Rekomendasi**: Mailtrap atau Gmail
- Mailtrap untuk testing tanpa spam user
- Gmail untuk test dengan email real

### 🏢 **Small Production (< 100 emails/hari)**
**Rekomendasi**: Gmail SMTP
- Gratis dan reliable
- Easy setup
- Good untuk startup

### 🏭 **Medium Production (100-1000 emails/hari)**
**Rekomendasi**: SendGrid atau Mailgun
- Better analytics
- Higher rate limits
- Professional features

### 🚀 **Enterprise (> 1000 emails/hari)**
**Rekomendasi**: Dedicated SMTP atau API
- Custom infrastructure
- White-label options
- Advanced features

---

## 🛠 Setup Script Otomatis

Gunakan script yang sudah disediakan untuk setup email dengan mudah:

```bash
# Jalankan script interaktif
bash setup-email-simple.sh

# Script akan membantu:
# 1. Pilih provider email
# 2. Input credentials
# 3. Update .env file
# 4. Test email configuration
```

📧 **Happy emailing!** Jika ada pertanyaan atau issue, check Laravel logs di `storage/logs/laravel.log`.