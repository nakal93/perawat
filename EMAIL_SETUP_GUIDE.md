# Panduan Konfigurasi Email Sungguhan

## 🎯 Pilihan Email Service

### 1. **GMAIL (Gratis & Mudah) - RECOMMENDED**
Cocok untuk development dan testing.

### 2. **Mailtrap (Gratis untuk testing)**
Service khusus untuk testing email.

### 3. **SendGrid (Gratis 100 email/hari)**
Professional email service.

### 4. **Mailgun (Gratis untuk domain terverifikasi)**
Powerful email API.

---

## 📧 OPSI 1: Gmail (Termudah)

### Langkah 1: Setup Gmail App Password
1. **Login ke Gmail** Anda
2. **Klik foto profil** → "Manage your Google Account"
3. **Security** → "2-Step Verification" (aktifkan jika belum)
4. **App passwords** → "Generate app password"
5. **Pilih app**: Mail
6. **Pilih device**: Computer
7. **Copy password** yang digenerate (16 karakter)

### Langkah 2: Update .env File
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password-16-chars
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-gmail@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📧 OPSI 2: Mailtrap (Testing)

### Langkah 1: Daftar Mailtrap
1. **Kunjungi**: https://mailtrap.io
2. **Sign up** gratis
3. **Buat inbox** baru
4. **Copy SMTP credentials**

### Langkah 2: Update .env File
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourapp.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📧 OPSI 3: SendGrid (Production)

### Langkah 1: Setup SendGrid
1. **Kunjungi**: https://sendgrid.com
2. **Sign up** gratis (100 email/hari)
3. **Email API** → "Integration Guide"
4. **Choose Web API** → "SMTP Relay"
5. **Create API Key**
6. **Copy API key**

### Langkah 2: Update .env File
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🛠 Setup Script Otomatis

Saya akan buat script untuk memilih konfigurasi email dengan mudah.