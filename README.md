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
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start NGINX development server (production-like)
sudo systemctl start nginx
sudo systemctl start php8.3-fpm

# Access application at http://10.10.10.44
```

### Default Users

```
Admin: admin@rsdolopo.com / password
Superuser: superuser@rsdolopo.com / password
```

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

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
