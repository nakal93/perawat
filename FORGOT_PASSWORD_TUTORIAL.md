# 🔐 Tutorial: Fitur Lupa Password Sistem RS

Panduan lengkap penggunaan fitur reset password untuk karyawan yang lupa password akun mereka.

## 📋 Gambaran Umum

Fitur "Lupa Password" memungkinkan karyawan untuk mereset password akun mereka secara mandiri tanpa perlu bantuan admin. Sistem menggunakan email verification untuk memastikan keamanan proses reset.

### � Keamanan Built-in
- **Token-based security**: Link reset menggunakan token unik
- **Time-limited**: Link otomatis expire setelah 60 menit
- **Single-use**: Token hanya bisa digunakan sekali
- **Strong password policy**: Password baru harus memenuhi kriteria keamanan

## � Cara Menggunakan

### 1️⃣ Akses Halaman Lupa Password
**Dari halaman login:**
- Buka `http://localhost:8000/login`
- Klik link **"Lupa Password?"** di bawah tombol Login

**Atau akses langsung:**
- Kunjungi: `http://localhost:8000/forgot-password`

### 2️⃣ Masukkan Email Terdaftar
- Ketik alamat email yang digunakan saat mendaftar
- Pastikan email sudah terdaftar di sistem
- Klik tombol **"Kirim Link Reset Password"**

![Halaman Forgot Password]

### 3️⃣ Cek Email untuk Link Reset

#### 🌐 Mode Production (Email Sungguhan)
- Buka inbox email Anda
- Cari email dari "Sistem RS Dolopo" 
- Subject: "Reset Your Password"
- Klik tombol **"Reset Password"** di email

#### 🧪 Mode Development (Log File)
- Buka file: `storage/logs/laravel.log`
- Cari entry terbaru dengan text "password reset"
- Copy URL yang ada dalam log tersebut
- Paste URL ke browser

**Contoh URL di log:**
```
http://localhost:8000/reset-password/TOKEN-DISINI?email=user@example.com
```

### 4️⃣ Buat Password Baru
**Persyaratan password baru:**
- ✅ **Minimal 6 karakter**
- ✅ **Minimal 1 huruf besar** (A-Z)
- ✅ **Minimal 1 huruf kecil** (a-z)  
- ✅ **Minimal 1 angka** (0-9)

**Form reset password:**
- Email akan otomatis terisi (read-only)
- Masukkan password baru sesuai kriteria
- Konfirmasi password di field kedua
- Sistem akan menampilkan real-time validation
- Klik **"Reset Password"**

### 5️⃣ Login dengan Credentials Baru
- Setelah berhasil reset, akan diarahkan ke halaman login
- Login menggunakan email dan password baru
- Akses sistem seperti biasa

## 🔒 Aspek Keamanan

### 🛡️ Validasi & Proteksi
- **Single use**: Token hanya bisa digunakan sekali
- **Email verification**: Hanya email terdaftar yang bisa request reset
- **Strong password**: Password baru harus memenuhi kriteria keamanan

### Real-time Validation
- ✅ **Visual feedback**: Indikator hijau/merah untuk setiap persyaratan
- ✅ **Instant checking**: Validasi saat pengguna mengetik
- ✅ **Clear requirements**: Persyaratan ditampilkan jelas

## 🧪 Testing Guide

### Test Scenario 1: Valid Email
```
1. Go to: http://localhost:8000/forgot-password
2. Enter: test@example.com (or any registered email)
3. Click: "Kirim Link Reset Password"
4. Check: storage/logs/laravel.log for reset link
5. Follow the link and reset password
```

### Test Scenario 2: Invalid Email
```
1. Go to: http://localhost:8000/forgot-password  
2. Enter: nonexistent@example.com
3. Click: "Kirim Link Reset Password"
4. Expect: Error message "We can't find a user with that email address"
```

- **Token expiry**: Link reset hanya valid 60 menit setelah dikirim
- **Single-use tokens**: Setiap token hanya bisa digunakan satu kali
- **Email verification**: Hanya email terdaftar yang bisa reset password
- **Strong password policy**: Password baru harus memenuhi kriteria keamanan
- **Rate limiting**: Pembatasan request untuk mencegah spam

### 🚫 Validasi Password
- **Minimal 6 karakter** untuk keamanan dasar
- **Mixed case**: Kombinasi huruf besar dan kecil
- **Numeric**: Minimal satu angka
- **Real-time feedback**: UI menampilkan requirement checklist

## 🧪 Testing & Debugging

### 📝 Test Case 1: Happy Path
```
1. Akses /forgot-password
2. Input email: admin@rsdolopo.com
3. Klik "Kirim Link Reset Password"
4. Check email atau log file
5. Klik link reset dari email/log
6. Input password baru: "NewPass123"
7. Konfirmasi password: "NewPass123"
8. Klik "Reset Password"
9. Login dengan credentials baru
✅ Expected: Berhasil login dengan password baru
```

### 📝 Test Case 2: Email Tidak Terdaftar
```
1. Akses /forgot-password  
2. Input email: notexist@example.com
3. Klik "Kirim Link Reset Password"
✅ Expected: Pesan "We have emailed your password reset link!" (untuk security, tidak kasih tau email tidak terdaftar)
```

### 📝 Test Case 3: Password Validation
```
1. Akses reset link dari email/log
2. Coba password lemah:
   - "123456" (tidak ada huruf)
   - "password" (tidak ada huruf besar, tidak ada angka)
   - "Pass1" (kurang dari 6 karakter)
3. Expected: Error validation dengan requirement spesifik
4. Coba password kuat: "NewPass123"
5. Expected: Sukses dan redirect ke login
```

### � Test Case 4: Token Expired
```
1. Generate reset link
2. Tunggu > 60 menit (atau manipulasi database)
3. Akses link yang sudah expired
4. Expected: Error "This password reset token is invalid"
```

## 📁 File & Struktur Code

### 🎨 Frontend Views
- `resources/views/auth/forgot-password.blade.php` - Form request reset
- `resources/views/auth/reset-password.blade.php` - Form password baru
- `resources/views/emails/auth/reset-password.blade.php` - Template email

### ⚙️ Backend Controllers  
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - Handle request
- `app/Http/Controllers/Auth/NewPasswordController.php` - Handle reset

### 🛣️ Routes (routes/auth.php)
```php
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
```

### 📊 Database
- `password_reset_tokens` table: Store token, email, timestamp
- Auto-cleanup tokens lama via Laravel built-in mechanism

## 🎯 Tips & Best Practices

### 👨‍💻 Untuk Developer
- **Gunakan log file** untuk debug saat development
- **Test semua edge cases** (token expired, email tidak ada, dll)
- **Validation client-side** + server-side untuk UX terbaik
- **Monitor email deliverability** di production

### 🏥 Untuk Admin RS
- **Educate users** tentang strong password policy
- **Monitor reset frequency** untuk detect suspicious activity
- **Backup email configuration** untuk disaster recovery
- **Regular security audit** untuk password policies

### 🚀 Untuk Production
- **Setup SPF/DKIM** untuk email deliverability
- **Monitor email bounces** dan blocked emails
- **Rate limiting** untuk prevent brute force
- **Log monitoring** untuk security incidents

## ⚠️ Troubleshooting

### 📧 Email tidak terkirim
**Symptoms**: User tidak menerima email reset
**Solutions**:
- Periksa konfigurasi MAIL_* di .env
- Pastikan SMTP credentials benar
- Check spam/junk folder
- Verify email server tidak memblokir
- Cek `storage/logs/laravel.log` untuk error

### 🔐 Token invalid/expired
**Symptoms**: "This password reset token is invalid"
**Solutions**:
- Generate ulang reset request
- Pastikan link tidak modified
- Check token belum expire (60 menit)
- Clear browser cache jika perlu

### 🚫 Password validation gagal
**Symptoms**: Form tidak accept password baru
**Solutions**:
- Pastikan memenuhi semua requirement
- Check JavaScript berjalan untuk real-time validation
- Verify server-side validation rules
- Try different browser jika ada masalah UI

---

📧 **Email berhasil dikonfigurasi?** Test forgotten password flow end-to-end untuk memastikan semua berjalan lancar!

### Link reset tidak bekerja
- Pastikan token belum expired
- Periksa URL format dengan benar
- Token hanya bisa digunakan sekali

### Password validation gagal
- Periksa persyaratan password terpenuhi
- Pastikan confirmasi password sama
- Lihat pesan error spesifik

## 🎉 Kesimpulan

Fitur forgot password sudah berhasil diimplementasi dengan:
- ✅ UI/UX yang user-friendly
- ✅ Validasi password yang kuat
- ✅ Real-time feedback
- ✅ Keamanan yang baik
- ✅ Error handling yang jelas
- ✅ Mobile responsive design

Silakan test semua scenario untuk memastikan fitur berjalan dengan sempurna!