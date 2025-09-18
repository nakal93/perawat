# 📧 Cara Setting Email Sungguhan - STEP BY STEP

## 🎯 Opsi Termudah: Gmail

### Langkah 1: Setup Gmail App Password

1. **Buka Gmail** Anda di browser
2. **Klik foto profil** (pojok kanan atas) → "Manage your Google Account"
3. **Pilih "Security"** di menu kiri
4. **Scroll ke bawah** hingga menemukan "How you sign in to Google"
5. **Klik "2-Step Verification"** → Ikuti setup jika belum aktif
6. **Setelah 2-Step aktif**, klik "App passwords" 
7. **Select app**: Choose "Mail"
8. **Select device**: Choose "Other" → ketik "Laravel RS Dolopo"
9. **Klik "Generate"**
10. **COPY password 16 karakter** yang muncul (contoh: `abcd efgh ijkl mnop`)

### Langkah 2: Edit File .env

Buka file `.env` dan ubah bagian MAIL menjadi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="RS Dolopo"
```

**GANTI:**
- `emailanda@gmail.com` dengan email Gmail Anda
- `abcd efgh ijkl mnop` dengan App Password yang Anda copy

### Langkah 3: Clear Cache Laravel

```bash
php artisan config:clear
php artisan cache:clear
```

### Langkah 4: Test Email

Buka `http://localhost:8000/forgot-password` dan masukkan email yang terdaftar.

---

## 🧪 Alternatif: Mailtrap (Untuk Testing)

Jika ingin test tanpa kirim email sungguhan:

1. **Daftar gratis** di https://mailtrap.io
2. **Buat inbox** baru
3. **Copy SMTP settings** dari inbox
4. **Update .env**:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username_dari_mailtrap
MAIL_PASSWORD=password_dari_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@rsdolopo.test"
MAIL_FROM_NAME="RS Dolopo"
```

Email akan muncul di inbox Mailtrap Anda, bukan dikirim sungguhan.

---

## ⚡ Quick Setup Script

Jalankan command ini untuk setup otomatis:

```bash
# Untuk Gmail
cp .env .env.backup
sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/' .env
sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=587/' .env
echo "MAIL_ENCRYPTION=tls" >> .env
php artisan config:clear
```

Lalu edit manual:
- `MAIL_USERNAME=gmail_anda@gmail.com`
- `MAIL_PASSWORD=app_password_16_karakter`
- `MAIL_FROM_ADDRESS="gmail_anda@gmail.com"`

---

## 🔍 Troubleshooting

### "Failed to authenticate on SMTP server"
- Pastikan App Password benar (16 karakter)
- Pastikan 2-Step Verification aktif di Gmail
- Coba generate App Password baru

### "Connection could not be established"
- Periksa koneksi internet
- Pastikan port 587 tidak diblokir

### Email tidak sampai
- Periksa folder Spam
- Pastikan email penerima valid
- Cek log Laravel: `tail -f storage/logs/laravel.log`

---

## 🎉 Hasil Akhir

Setelah setup berhasil, fitur forgot password akan:
- ✅ Kirim email sungguhan ke inbox penerima
- ✅ Link reset password yang aman
- ✅ Password baru dengan validasi kuat
- ✅ Redirect ke login setelah berhasil

**Test di**: `http://localhost:8000/forgot-password`