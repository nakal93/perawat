# 🏥 Sistem Pendataan Karyawan Rumah Sakit

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-cyan.svg)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-teal.svg)](https://alpinejs.dev)
[![Railway](https://img.shields.io/badge/Deploy-Railway-blueviolet.svg)](https://railway.app)

**Sistem manajemen karyawan rumah sakit modern** dengan fitur pendaftaran bertahap, persetujuan admin, QR Code profil, manajemen dokumen, dan integrasi alamat wilayah Indonesia. Dibangun dengan Laravel 12 + Breeze, desain mobile-first, dan siap deploy ke Railway.

> **Status**: ✅ Siap produksi | 🚀 Deploy ke Railway | 📱 Mobile-responsive | 🔐 Keamanan tinggi

## 🎯 Fitur Utama

### 🔐 Sistem Autentikasi & Manajemen Peran
- **Multi-role system**: Admin, Superuser, Karyawan dengan hak akses berbeda
- **Pendaftaran 2 tahap**: Registrasi awal → persetujuan admin → lengkapi profil
- **Laravel Breeze**: Authentication scaffold dengan forgot password
- **Validasi password kuat**: Minimal 6 karakter, huruf besar, angka
- **Email verification**: Reset password via Gmail SMTP

### 👥 Master Data (Khusus Admin)
- **Manajemen Ruangan**: CRUD ruangan rumah sakit (Gatotkaca, Bima, Nakula Sadewa)
- **Manajemen Profesi**: CRUD profesi (Perawat, Bidan, Dokter, dll)
- **Kategori Dokumen**: CRUD kategori dokumen (SIP, STR, SIKP, dll)
- **Status Pegawai**: PNS, PPPK, Kontrak, Honorer

### 🗺️ Integrasi Alamat Wilayah Indonesia (Terbaru!)
- **API Wilayah Lengkap**: Provinsi → Kabupaten → Kecamatan → Kelurahan
- **Form Cascading**: Dropdown alamat bertingkat yang saling terhubung
- **Auto-fill Kode Pos**: Otomatis terisi berdasarkan kelurahan yang dipilih
- **Preview Real-time**: Tampilan alamat lengkap secara langsung
- **Data Akurat**: Menggunakan API Wilayah Indonesia terbaru 2024

### 📝 Pendaftaran Karyawan Bertahap

#### 🥇 Tahap 1 - Registrasi Awal (Publik)
- Data pribadi: Nama lengkap, email, password, NIK
- **Alamat Regional**: Pilih provinsi, kabupaten, kecamatan, kelurahan
- **Detail Alamat**: RT/RW, nama jalan, nomor rumah
- Data dasar: Jenis kelamin, ruangan, profesi
- Status: **Pending** (menunggu persetujuan admin)

#### 🥈 Tahap 2 - Lengkapi Profil (Setelah Disetujui)
- Upload foto profil (JPG/PNG, max 2MB)
- Data lengkap: Agama, pendidikan terakhir, gelar
- Informasi kampus dan status perkawinan
- Status: **Active** (dapat menggunakan sistem)

### ✅ Sistem Persetujuan Admin (Bulk Operations)
- **Persetujuan Individual**: Approve/reject satu per satu dengan alasan
- **Bulk Operations**: Select multiple dan approve sekaligus
- **Approve All**: Setujui semua pending dalam sekali klik
- **Audit Log**: Pencatatan semua aktivitas persetujuan dengan timestamp
- **Notifikasi**: Email otomatis ke karyawan saat disetujui/ditolak

### 📄 Manajemen Dokumen Karyawan
- **Upload Multi-format**: PDF, JPG, PNG (maksimal 10MB per file)
- **Kategorisasi**: Dokumen terorganisir berdasarkan kategori (SIP, STR, dll)
- **Masa Berlaku**: Tracking tanggal berakhir dengan opsi "Berlaku Seumur Hidup"
- **Multiple Files**: Satu kategori bisa memiliki beberapa file dokumen
- **Download**: Download individual atau batch download

### 📱 QR Code Generator & Scanner
- **QR Code Personal**: Setiap karyawan memiliki QR code unik
- **Scan to Profile**: Scan QR → langsung ke profil publik karyawan
- **Multiple Format**: Download QR code dalam format PNG dan PDF
- **Responsive**: QR code dapat di-scan dari mobile dan desktop

### 📊 Dashboard Admin Komprehensif
- **Statistik Real-time**: Jumlah karyawan, pending approval, dokumen expire
- **Chart Interaktif**: Distribusi karyawan per ruangan dan profesi
- **Alert System**: Notifikasi dokumen yang akan/sudah berakhir
- **Advanced Filter**: Filter berdasarkan status, ruangan, profesi, tanggal
- **Quick Search**: Pencarian cepat berdasarkan nama, NIK, email

### 🔍 Sistem Pencarian & Filter Lanjutan
- **Global Search**: Pencarian di seluruh data karyawan
- **Filter Multi-kriteria**: Status, ruangan, profesi, tanggal bergabung
- **Export Data**: Export ke Excel/CSV dengan filter yang diterapkan
- **Pagination**: Loading data yang efisien untuk dataset besar

## 📱 Desain Mobile-First & Responsif

### 🎨 Layout Adaptif
- **Navigation**: Bottom tab bar untuk mobile, sidebar collapsible untuk desktop
- **Cards**: Layout vertikal di mobile, grid responsif di desktop
- **Tables**: Horizontal scroll + tampilan terkondensasi untuk layar kecil
- **Forms**: Single column dengan target sentuh besar (minimum 44px)
- **Modals**: Full-screen di mobile, popup centered di desktop
- **Breakpoints**: sm(640px), md(768px), lg(1024px), xl(1280px)

### 👆 Interface Ramah Sentuhan
- **Touch Targets**: Semua button minimum 44px height untuk kemudahan tap
- **Input Fields**: Area input besar dengan spacing yang cukup
- **Checkbox**: Area clickable diperbesar untuk kemudahan akses
- **Upload**: Drag-drop + tap to browse dengan visual feedback
- **Swipe Gestures**: Navigasi intuitif untuk mobile users

### 🎯 UX/UI Highlights
- **Progressive Enhancement**: Bekerja tanpa JavaScript, enhanced dengan Alpine.js
- **Accessibility**: ARIA labels, keyboard navigation, screen reader friendly
- **Dark Mode Ready**: Sistem warna yang konsisten untuk implementasi dark theme
- **Loading States**: Skeleton loading dan progress indicators
- **Error Handling**: User-friendly error messages dengan suggestion

## 🛠 Tech Stack & Arsitektur

### Backend Framework
- **Laravel 12**: Framework PHP modern dengan fitur terbaru
- **Laravel Breeze**: Authentication starter kit yang ringan dan aman
- **MySQL/PostgreSQL**: Database relational dengan migrasi dan seeder
- **Eloquent ORM**: Object-Relational Mapping untuk query yang elegan

### Frontend & Styling
- **Blade Templates**: Template engine Laravel yang powerful
- **Tailwind CSS 3.x**: Utility-first CSS framework untuk rapid styling
- **Alpine.js 3.x**: JavaScript framework ringan untuk interaktivitas
- **Vite**: Build tool modern untuk asset bundling dan HMR

### Libraries & Packages
- **QR Code**: SimpleSoftwareIO/simple-qrcode untuk generate QR codes
- **File Upload**: Native Laravel storage dengan validation
- **API Wilayah**: Integrasi dengan API wilayah Indonesia
- **Email**: Laravel Mail dengan dukungan SMTP (Gmail, dll)

### Development Tools
- **Composer**: Dependency management untuk PHP
- **NPM**: Package manager untuk JavaScript dependencies
- **Laravel Artisan**: Command-line interface untuk development
- **Laravel Tinker**: REPL untuk testing dan debugging

### Production & Deployment
- **Railway**: Platform deployment modern dengan Nixpacks
- **Nginx**: Web server untuk production (auto-configured)
- **Redis**: Caching dan session storage (optional)
- **Queue**: Background job processing untuk email dan notifikasi

## 🚀 Instalasi & Setup Lokal

### Prasyarat Sistem
```bash
# Pastikan terinstall:
- PHP 8.2+ dengan ekstensi: mbstring, xml, curl, zip, gd, pdo_mysql
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0+ atau PostgreSQL 13+
- Git
```

### 1️⃣ Clone & Install Dependencies
```bash
# Clone repository
git clone https://github.com/nakal93/perawat.git
cd perawat

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 2️⃣ Konfigurasi Environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env sesuai konfigurasi database Anda:
# DB_DATABASE=perawat_db
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

### 3️⃣ Setup Database
```bash
# Buat database (manual di MySQL/PostgreSQL)
# Atau gunakan: mysql -u root -p -e "CREATE DATABASE perawat_db;"

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Link storage untuk file upload
php artisan storage:link
```

### 4️⃣ Build Assets & Run Server
```bash
# Build assets untuk production
npm run build

# ATAU untuk development dengan hot reload
npm run dev

# Jalankan Laravel development server
php artisan serve

# Akses aplikasi di: http://127.0.0.1:8000
```

### 5️⃣ (Opsional) Konfigurasi Email
```bash
# Edit .env untuk SMTP email:
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Sistem RS"

# Test email configuration
php artisan tinker
# Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

## 👤 Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, tersedia akun berikut:

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| **Admin** | admin@rsdolopo.com | `password` | Full access: kelola master data, approve karyawan, lihat semua data |
| **Superuser** | superuser@rsdolopo.com | `password` | Hampir full access kecuali kelola master data |

> **⚠️ Penting**: Segera ganti password default setelah login pertama melalui menu Pengaturan Akun.

## 🗂 Struktur Database

### Tabel Utama
```sql
-- Users & Authentication
users, password_reset_tokens, sessions

-- Master Data
ruangan (Gatotkaca, Bima, Nakula Sadewa)
profesi (Perawat, Bidan, Dokter, dll)
kategori_dokumen (SIP, STR, SIKP, dll)
status_pegawai (PNS, PPPK, Kontrak, Honorer)

-- Alamat Wilayah Indonesia
provinsi, kabupaten, kecamatan, kelurahan

-- Data Karyawan
karyawan (data lengkap + alamat regional)
dokumen_karyawan (files upload dengan kategori)
bulk_approval_log (audit trail persetujuan)
```

### Relasi Database
- `karyawan` → `users` (one-to-one)
- `karyawan` → `ruangan`, `profesi` (many-to-one)
- `karyawan` → `provinsi`, `kabupaten`, `kecamatan`, `kelurahan` (many-to-one)
- `dokumen_karyawan` → `karyawan`, `kategori_dokumen` (many-to-one)

## 🔧 Konfigurasi Environment Penting

```bash
# Application
APP_NAME="Sistem Pendataan Karyawan RS"
APP_ENV=local  # production untuk server live
APP_DEBUG=true  # false untuk production
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql  # atau pgsql untuk PostgreSQL
DB_HOST=127.0.0.1
DB_PORT=3306  # 5432 untuk PostgreSQL
DB_DATABASE=perawat_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# File Storage
FILESYSTEM_DISK=public  # local storage, bisa diubah ke s3 untuk cloud
```

## 🚀 Deploy ke Railway

Sistem ini sudah dilengkapi dengan konfigurasi untuk deploy otomatis ke [Railway](https://railway.app):

```bash
# 1. Push ke GitHub
git add .
git commit -m "Deploy to Railway"
git push origin main

# 2. Ikuti panduan lengkap di:
# 📄 DEPLOY_RAILWAY.md (tersedia di repo ini)
```

File deployment yang sudah disiapkan:
- `Procfile` - Web process configuration
- `scripts/start-railway.sh` - Production startup script
- `DEPLOY_RAILWAY.md` - Panduan deployment lengkap

## 🔧 Troubleshooting & FAQ

### Masalah Umum & Solusi

| 🚨 Error | 💡 Solusi |
|----------|-----------|
| **419 Page Expired** | Pastikan `APP_KEY` sudah di-generate dan session table ter-migrate |
| **Assets 404** | Jalankan `php artisan storage:link` dan `npm run build` |
| **Foto profil tidak tampil** | Periksa permission folder `storage/` dan `public/storage` |
| **Database connection error** | Verifikasi kredensial DB di `.env` dan pastikan service MySQL/PostgreSQL aktif |
| **QR Code error** | Install ekstensi PHP: `gd` dan `imagick` |
| **Email tidak terkirim** | Periksa konfigurasi SMTP di `.env` dan pastikan "App Password" Gmail aktif |

### Performance Optimization

```bash
# Cache konfigurasi untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear cache saat development
php artisan optimize:clear
```

### Backup & Maintenance

```bash
# Backup database
mysqldump -u username -p perawat_db > backup_$(date +%Y%m%d).sql

# Reset database (development only)
php artisan migrate:fresh --seed

# Update dependencies
composer update
npm update
```

## 🚀 Roadmap & Fitur Mendatang

### 📋 In Progress
- [ ] **Export laporan PDF**: Laporan karyawan dan dokumen
- [ ] **Email notifications**: Notifikasi dokumen akan berakhir
- [ ] **Advanced audit log**: Log semua aktivitas user
- [ ] **API endpoints**: REST API untuk integrasi mobile app

### 🔮 Future Plans
- [ ] **Dashboard analytics**: Chart dan grafik yang lebih detail
- [ ] **Document OCR**: Auto-extract data dari dokumen scan
- [ ] **Multi-tenant**: Support multiple rumah sakit
- [ ] **Mobile app**: Flutter/React Native companion app
- [ ] **Push notifications**: Real-time notifications
- [ ] **Advanced reporting**: Custom report builder

## 🤝 Kontribusi & Support

### Cara Berkontribusi
1. **Fork** repository ini
2. **Create feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit changes**: `git commit -m 'Add amazing feature'`
4. **Push to branch**: `git push origin feature/amazing-feature`
5. **Open Pull Request** dengan deskripsi yang jelas

### Melaporkan Bug
- Gunakan **GitHub Issues** untuk melaporkan bug
- Sertakan informasi: OS, PHP version, Laravel version, error message
- Lampirkan screenshot jika perlu

### Request Fitur
- Buat **GitHub Issue** dengan label `enhancement`
- Jelaskan use case dan benefit yang diharapkan
- Diskusikan implementasi dengan maintainer

## 📄 Lisensi & Credits

### Lisensi
Proyek ini menggunakan **MIT License**. Lihat file `LICENSE` untuk detail lengkap.

### Credits & Acknowledgments
- **Laravel Team** - Framework PHP yang luar biasa
- **Tailwind Labs** - CSS framework yang powerful
- **Alpine.js Team** - JavaScript framework yang ringan
- **SimpleSoftwareIO** - QR Code generator package
- **API Wilayah Indonesia** - Data wilayah yang akurat
- **Railway** - Platform deployment yang mudah

---

<div align="center">

**🏥 Sistem Pendataan Karyawan Rumah Sakit**

*Dibangun dengan ❤️ menggunakan Laravel, Tailwind CSS, dan arsitektur mobile-first*

[![GitHub](https://img.shields.io/badge/GitHub-nakal93/perawat-blue?logo=github)](https://github.com/nakal93/perawat)
[![Laravel](https://img.shields.io/badge/Powered%20by-Laravel%2012-red?logo=laravel)](https://laravel.com)
[![Railway](https://img.shields.io/badge/Deploy%20on-Railway-blueviolet?logo=railway)](https://railway.app)

**Versi**: 1.0.0 | **Status**: Siap Produksi ✅

</div>
