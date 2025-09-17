# 🏥 Sistem Pendataan Karyawan RS Dolopo

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem manajemen data karyawan rumah sakit dengan fitur registrasi bertahap, QR Code, approval admin, dan integrasi alamat wilayah Indonesia. Dibangun dengan Laravel 12 + Breeze dan design mobile-first.

![Dashboard Preview](https://via.placeholder.com/800x400/3B82F6/FFFFFF?text=RS+Dolopo+Dashboard)

## 🚀 Fitur Utama

### Authentication & Role Management
- **Multi Role**: Admin, Superuser, Karyawan
- **Registrasi Bertahap**: 2 tahap dengan sistem approval
- **Laravel Breeze**: Authentication scaffold

### Master Data (Admin Only)
- **CRUD Ruangan**: Gatotkaca, Bima, Nakula Sadewa
- **CRUD Profesi**: Perawat, Bidan, Dokter
- **CRUD Kategori Dokumen**: SIP, STR, SIKP, dll

### 🗺️ Alamat Wilayah Indonesia (NEW!)
- **API Wilayah**: Provinsi → Kabupaten → Kecamatan → Kelurahan
- **Form Cascading**: Dropdown alamat bertingkat
- **Kode Pos**: Otomatis terisi berdasarkan kelurahan
- **Preview Alamat**: Real-time alamat lengkap
- **Data Source**: roedyrustam/API-Wilayah-2024

### Registrasi Karyawan
#### Tahap 1 (Public)
- Nama lengkap, email, password
- NIK
- **Alamat Regional**: Provinsi, Kabupaten, Kecamatan, Kelurahan
- **Detail Alamat**: RT/RW, nama jalan, nomor rumah
- Jenis kelamin
- Ruangan & profesi (dropdown)
- Status: pending

#### Tahap 2 (Setelah Approval)
- Foto profil, agama, pendidikan terakhir
- Gelar, kampus
- Status: active

### Bulk Approval Admin
- Individual approve/reject
- Select multiple + bulk approve
- Approve all pending
- Audit log semua approval

### Dokumen Management
- Upload PDF/JPG/PNG (max 10MB)
- Checkbox "Berlaku Seumur Hidup"
- Tracking tanggal berakhir
- Multiple files per kategori

### QR Code Generator
- QR Code untuk setiap karyawan
- Scan → profil publik
- Download QR Code (PDF/PNG)

### Dashboard Admin
- Statistik karyawan & approval
- Chart karyawan per ruangan/profesi
- Alert dokumen berakhir
- Filter dan search

## 🎨 Mobile-First Design

### Layout Responsif
- **Navigation**: Bottom tab bar untuk mobile, sidebar untuk desktop
- **Cards**: Stack vertical di mobile, grid di desktop
- **Tables**: Horizontal scroll + condensed view
- **Forms**: Single column, large touch targets (min 44px)
- **Modals**: Full-screen di mobile, popup di desktop

### Touch-Friendly UI
- Buttons minimum 44px height
- Large input fields dengan easy tap
- Large checkbox hitbox area
- Drag-drop + tap to browse upload
- Swipe gestures untuk mobile

## 🛠 Tech Stack

- **Backend**: Laravel 12
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **JavaScript**: Alpine.js
- **QR Code**: SimpleSoftwareIO/simple-qrcode

## 🚀 Quick Start

```bash
# 1. Clone repository
git clone https://github.com/your-org/perawat.git
cd perawat

# 2. Install PHP & JS dependencies
composer install
npm install

# 3. Copy env & generate key
cp .env.example .env
php artisan key:generate

# 4. (Optional) Adjust DB credentials in .env
# DB_DATABASE=perawat_db
# DB_USERNAME=perawat_user
# DB_PASSWORD=secret

# 5. Run migrations & seed base data (status pegawai, admin user, dsb.)
php artisan migrate --seed

# 6. Link storage (untuk akses file upload & foto profil)
php artisan storage:link

# 7. Build assets (production) atau jalankan dev watcher
npm run build   # atau: npm run dev

# 8. Jalankan server lokal Laravel
php artisan serve

# Akses: http://127.0.0.1:8000
```

### Default Users (Seeder)

```
Admin:     admin@rsdolopo.com      / password
Superuser: superuser@rsdolopo.com  / password
```

Jika ingin mengganti password default segera setelah deploy, jalankan tinker atau ubah lewat menu pengaturan akun.

### Struktur Migrasi
Migrations mencakup:
- create_users, create_karyawan
- penambahan field tambahan karyawan (alamat detail, status_perkawinan, dll.)
- status/relasi master: ruangan, profesi, kategori dokumen
- dokumen karyawan & relasi

Pastikan urutan otomatis Laravel sudah konsisten; gunakan `php artisan migrate:fresh --seed` bila ingin reset total saat development.

### Seeders
Seeder menyediakan:
- Role/Status Pegawai dasar (PNS, PPPK, Kontrak, Honorer)
- Admin & Superuser default
- Contoh ruangan & profesi

### Build Aset Frontend
Gunakan `npm run dev` saat development (HMR/Vite). Untuk produksi: `npm run build`.

### Variabel Lingkungan Penting
```
APP_ENV, APP_DEBUG, APP_URL
DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
FILESYSTEM_DISK (public) & STORAGE LINK
MAIL_MAILER (smtp atau log)
```

### Keamanan & Produksi
- Pastikan `APP_KEY` tidak kosong.
- Set `APP_ENV=production` dan `APP_DEBUG=false` di server produksi.
- Simpan `.env` (jangan commit). Sudah di-`.gitignore`.
- Backup database terpisah (folder `/storage/backups` sudah di-ignore).

### Deployment Singkat (Contoh)
1. Pull repo & install dependencies.
2. Salin `.env` produksi & generate key jika baru.
3. Jalankan `php artisan migrate --force`.
4. Jalankan `npm ci && npm run build` atau gunakan artifact build.
5. Jalankan queue (jika nanti ditambah) & optimasi: `php artisan config:cache route:cache view:cache`.

### Troubleshooting
| Masalah | Solusi Cepat |
|---------|--------------|
| 419 Page Expired | Pastikan APP_KEY dan session driver valid (database table sessions migrated). |
| Asset 404 | Jalankan `php artisan storage:link` & build Vite. |
| Foto tidak tampil | Periksa permission `storage/` (www-data read). |
| Error enum status_kelengkapan | Pastikan migration enum terbaru sudah jalan. |

### Roadmap Singkat
- Reset password via email
- Audit log aktivitas karyawan
- Export laporan PDF
- Integrasi notifikasi dokumen kadaluarsa (queue + mail)

---
Jika menemukan bug atau butuh fitur tambahan, buat issue atau pull request.

## 📱 Mobile-First Features
✅ Bottom Navigation untuk easy thumb access
✅ Card Layout menggantikan table di mobile
✅ Large Touch Targets minimum 44px
✅ Fixed Action Bar untuk bulk operations
✅ Responsive Grid auto-adjust columns
✅ Mobile Forms single column layout
✅ Touch Upload drag-drop + tap to browse

---

**RS Dolopo Employee Management System** - Built with ❤️ menggunakan Laravel & mobile-first design

## Lisensi

Proyek ini dirilis di bawah lisensi MIT. Lihat file LICENSE bila tersedia atau tambahkan jika belum.
