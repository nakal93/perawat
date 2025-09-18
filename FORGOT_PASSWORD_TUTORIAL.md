# Tutorial: Cara Menggunakan Fitur Lupa Password

## 📋 Overview
Fitur "Lupa Password" memungkinkan pengguna untuk reset password mereka jika terlupa. Sistem ini menggunakan email untuk mengirim link reset password yang aman.

## 🛠 Persiapan (Development Mode)
1. **Server sudah berjalan** di `http://localhost:8000`
2. **Email configuration** menggunakan 'log' driver (email disimpan di log file)
3. **Test user tersedia** dengan email yang terdaftar

## 📚 Langkah-langkah Penggunaan

### 1. Akses Halaman Forgot Password
- Buka browser dan kunjungi: `http://localhost:8000/forgot-password`
- Atau klik link "Lupa Password?" di halaman login

### 2. Masukkan Email
- Ketik alamat email yang terdaftar di sistem
- Klik tombol **"Kirim Link Reset Password"**

### 3. Periksa Email/Log (Development Mode)
**Untuk Production (Email sungguhan):**
- Buka email inbox Anda
- Cari email dari sistem dengan subject "Reset Password"
- Klik link yang disediakan

**Untuk Development (Log file):**
- Buka file: `storage/logs/laravel.log`
- Cari entry terbaru yang berisi "password reset"
- Copy URL yang ada di log tersebut
- Paste URL di browser

### 4. Buat Password Baru
- Halaman reset password akan terbuka
- Masukkan password baru yang memenuhi persyaratan:
  - ✅ Minimal 6 karakter
  - ✅ Minimal 1 huruf besar (A-Z)
  - ✅ Minimal 1 huruf kecil (a-z)  
  - ✅ Minimal 1 angka (0-9)
- Konfirmasi password dengan mengetik ulang
- Klik **"Reset Password"**

### 5. Login dengan Password Baru
- Anda akan diarahkan ke halaman login
- Login menggunakan email dan password baru

## 🔒 Keamanan Features

### Validation Rules
- **Token expiry**: Link reset hanya valid untuk waktu terbatas
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

### Test Scenario 3: Password Validation
```
1. Access reset link from email/log
2. Try weak passwords:
   - "123456" (no uppercase, no lowercase letters)
   - "password" (no uppercase, no numbers)
   - "Pass1" (less than 6 characters)
3. Expect: Validation errors with specific requirements
4. Try strong password: "NewPass123"
5. Expect: Success and redirect to login
```

## 📁 Files yang Terlibat

### Frontend Views
- `resources/views/auth/forgot-password.blade.php` - Form request reset
- `resources/views/auth/reset-password.blade.php` - Form password baru

### Backend Controllers  
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - Handle request
- `app/Http/Controllers/Auth/NewPasswordController.php` - Handle reset

### Routes
- `GET /forgot-password` - Tampil form request
- `POST /forgot-password` - Proses request  
- `GET /reset-password/{token}` - Tampil form reset
- `POST /reset-password` - Proses reset

## 🎯 Tips & Best Practices

### Untuk Development
- Gunakan log file untuk melihat email reset
- Test dengan email yang sudah terdaftar
- Periksa validation rules bekerja dengan benar

### Untuk Production
- Konfigurasi SMTP server yang proper
- Set `MAIL_MAILER=smtp` di .env
- Test email delivery sebelum go-live
- Monitor rate limiting untuk mencegah abuse

## ⚠️ Troubleshooting

### Email tidak terkirim
- Periksa konfigurasi MAIL_* di .env
- Pastikan SMTP server credentials benar
- Cek log file untuk error messages

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