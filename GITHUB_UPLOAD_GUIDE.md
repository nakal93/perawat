# 🚀 Panduan Upload ke GitHub Repository "perawat"

## 📋 LANGKAH-LANGKAH:

### 1. Buat Repository di GitHub
1. Buka https://github.com dan login
2. Klik tombol "+" di pojok kanan atas → "New repository"
3. Isi detail repository:
   - **Repository name**: `perawat`
   - **Description**: `Sistem Pendataan Karyawan RS Dolopo - Laravel 12 Employee Management System`
   - **Visibility**: Public atau Private (sesuai kebutuhan)
   - **JANGAN** centang "Add a README file" (karena sudah ada)
   - **JANGAN** centang "Add .gitignore" (karena sudah ada)
   - **JANGAN** centang "Choose a license"
4. Klik "Create repository"

### 2. Copy URL Repository
Setelah repository dibuat, copy URL yang muncul di halaman repository:
- **HTTPS**: `https://github.com/USERNAME/perawat.git`
- **SSH**: `git@github.com:USERNAME/perawat.git`

### 3. Jalankan Command Berikut di Terminal

```bash
# Tambahkan remote origin (ganti USERNAME dengan username GitHub Anda)
git remote add origin https://github.com/USERNAME/perawat.git

# Rename branch ke main (GitHub default)
git branch -M main

# Push ke GitHub
git push -u origin main
```

## 🔑 AUTHENTICATION GITHUB

### Option 1: Personal Access Token (Recommended)
1. Buka GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token dengan scope:
   - `repo` (Full control of private repositories)
   - `read:user`
3. Copy token dan simpan dengan aman
4. Saat diminta password, gunakan token sebagai password

### Option 2: SSH Key
1. Generate SSH key: `ssh-keygen -t ed25519 -C "admin@rsdolopo.com"`
2. Copy public key: `cat ~/.ssh/id_ed25519.pub`
3. Tambahkan ke GitHub → Settings → SSH and GPG keys → New SSH key
4. Gunakan SSH URL: `git@github.com:USERNAME/perawat.git`

## 📂 STRUKTUR REPOSITORY YANG AKAN DIUPLOAD

```
perawat/
├── 📁 app/                     # Laravel application logic
├── 📁 bootstrap/               # Laravel bootstrap files
├── 📁 config/                  # Configuration files
├── 📁 database/                # Migrations, seeders, factories
├── 📁 public/                  # Public web files
├── 📁 resources/               # Views, CSS, JS, lang files
├── 📁 routes/                  # Route definitions
├── 📁 storage/                 # File storage (excluded from git)
├── 📁 tests/                   # Test files
├── 📄 .env.example             # Environment template
├── 📄 .gitignore               # Git ignore rules
├── 📄 README.md                # Project documentation
├── 📄 composer.json            # PHP dependencies
├── 📄 package.json             # Node.js dependencies
└── 📄 artisan                  # Laravel CLI tool
```

## ✅ VERIFIKASI SETELAH UPLOAD

1. **Repository**: https://github.com/USERNAME/perawat
2. **Files**: Pastikan semua file terlihat di GitHub
3. **README**: Pastikan README.md ditampilkan dengan baik
4. **Branches**: Branch utama harus "main"

## 🔄 WORKFLOW DEVELOPMENT SELANJUTNYA

### Clone Repository (untuk developer lain)
```bash
git clone https://github.com/USERNAME/perawat.git
cd perawat
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
```

### Daily Development Workflow
```bash
# Pull perubahan terbaru
git pull origin main

# Buat perubahan code...

# Commit dan push
git add .
git commit -m "feat: description of changes"
git push origin main
```

## 🎯 REPOSITORY SIAP!

Setelah mengikuti langkah-langkah di atas, repository "perawat" akan berisi:
- ✅ Complete Laravel 12 application
- ✅ All source code and configurations
- ✅ Database migrations and seeders
- ✅ Documentation and setup guides
- ✅ Mobile-first responsive design
- ✅ Production-ready NGINX configuration
- ✅ Comprehensive README with badges and screenshots

**Repository akan menjadi central hub untuk development tim RS Dolopo!** 🚀
