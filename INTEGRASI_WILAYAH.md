# Integrasi API Wilayah Indonesia 2024

Dokumentasi ini menjelaskan cara mengintegrasikan API Wilayah Indonesia dari repository `roedyrustam/API-Wilayah-2024` ke dalam aplikasi pendataan karyawan RS Dolopo.

## 📋 Fitur yang Ditambahkan

### 1. Database Regional Indonesia
- **Provinsi**: Semua provinsi di Indonesia
- **Kabupaten/Kota**: Kabupaten dan kota di setiap provinsi
- **Kecamatan**: Kecamatan di setiap kabupaten/kota  
- **Kelurahan/Desa**: Kelurahan dan desa di setiap kecamatan
- **Kode Pos**: Kode pos untuk setiap kelurahan

### 2. Form Registrasi dengan Alamat Bertingkat
- Dropdown provinsi yang dimuat otomatis
- Dropdown kabupaten/kota berdasarkan provinsi yang dipilih
- Dropdown kecamatan berdasarkan kabupaten/kota yang dipilih
- Dropdown kelurahan/desa berdasarkan kecamatan yang dipilih
- Field detail alamat untuk informasi spesifik (RT/RW, nama jalan, dll)
- Preview alamat lengkap secara real-time

### 3. API Endpoints
- `GET /api/wilayah/provinsi` - Daftar semua provinsi
- `GET /api/wilayah/kabupaten?provinsi_id={id}` - Kabupaten berdasarkan provinsi
- `GET /api/wilayah/kecamatan?kabupaten_id={id}` - Kecamatan berdasarkan kabupaten
- `GET /api/wilayah/kelurahan?kecamatan_id={id}` - Kelurahan berdasarkan kecamatan
- `GET /api/wilayah/alamat-lengkap?kelurahan_id={id}` - Alamat lengkap formatted

## 🗄️ Struktur Database

### Tabel Regional Baru
```sql
-- Provinsi
CREATE TABLE provinsi (
    id BIGINT PRIMARY KEY,
    code VARCHAR(255) UNIQUE,
    name VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Kabupaten/Kota
CREATE TABLE kabupaten (
    id BIGINT PRIMARY KEY,
    provinsi_id BIGINT,
    type VARCHAR(255), -- 'KABUPATEN' atau 'KOTA'
    name VARCHAR(255),
    code VARCHAR(255),
    full_code VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (provinsi_id) REFERENCES provinsi(id)
);

-- Kecamatan
CREATE TABLE kecamatan (
    id BIGINT PRIMARY KEY,
    kabupaten_id BIGINT,
    code VARCHAR(255),
    name VARCHAR(255),
    full_code VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (kabupaten_id) REFERENCES kabupaten(id)
);

-- Kelurahan/Desa
CREATE TABLE kelurahan (
    id BIGINT PRIMARY KEY,
    kecamatan_id BIGINT,
    code VARCHAR(255),
    name VARCHAR(255),
    full_code VARCHAR(255),
    pos_code VARCHAR(255), -- Kode pos
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id)
);
```

### Update Tabel Karyawan
```sql
ALTER TABLE karyawan ADD COLUMN (
    provinsi_id BIGINT NULL,
    kabupaten_id BIGINT NULL,
    kecamatan_id BIGINT NULL,
    kelurahan_id BIGINT NULL,
    alamat_detail VARCHAR(500) NULL,
    FOREIGN KEY (provinsi_id) REFERENCES provinsi(id),
    FOREIGN KEY (kabupaten_id) REFERENCES kabupaten(id),
    FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id),
    FOREIGN KEY (kelurahan_id) REFERENCES kelurahan(id)
);
```

## 💻 Implementasi Frontend

### HTML Form Structure
```html
<!-- Provinsi -->
<select id="provinsi_id" name="provinsi_id" required>
    <option value="">Memuat data provinsi...</option>
</select>

<!-- Kabupaten -->
<select id="kabupaten_id" name="kabupaten_id" disabled required>
    <option value="">Pilih Kabupaten/Kota</option>
</select>

<!-- Kecamatan -->
<select id="kecamatan_id" name="kecamatan_id" disabled required>
    <option value="">Pilih Kecamatan</option>
</select>

<!-- Kelurahan -->
<select id="kelurahan_id" name="kelurahan_id" disabled required>
    <option value="">Pilih Kelurahan/Desa</option>
</select>

<!-- Detail Alamat -->
<textarea id="alamat_detail" name="alamat_detail" required 
          placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05"></textarea>

<!-- Preview Alamat -->
<div id="alamat_preview"></div>
```

### JavaScript Integration
```javascript
// Inisialisasi
WilayahSelector.init();

// Atau dengan Alpine.js
<div x-data="wilayahData()">
    <!-- Form elements -->
</div>
```

## 🔧 Cara Menggunakan Data Lengkap

### 1. Download Dataset Lengkap
```bash
# Clone repository roedyrustam/API-Wilayah-2024
git clone https://github.com/roedyrustam/API-Wilayah-2024.git temp-wilayah

# Copy file JSON ke project
cp temp-wilayah/public/json/* /var/www/public/json/

# Hapus folder temporary
rm -rf temp-wilayah
```

### 2. Import Data Lengkap via Seeder
```php
// Buat seeder baru
php artisan make:seeder FullWilayahSeeder

// Implementasi import dari JSON
public function run(): void
{
    $provinsiData = json_decode(file_get_contents(public_path('json/provinsi.json')), true);
    $kabupatenData = json_decode(file_get_contents(public_path('json/kabupaten.json')), true);
    $kecamatanData = json_decode(file_get_contents(public_path('json/kecamatan.json')), true);
    $kelurahanData = json_decode(file_get_contents(public_path('json/kelurahan.json')), true);

    // Insert data...
}
```

### 3. Import via Database
```bash
# Download SQL dump dari repository original
wget https://raw.githubusercontent.com/roedyrustam/API-Wilayah-2024/main/database.sql

# Import ke database
mysql -u username -p database_name < database.sql
```

## 🎯 Contoh Response API

### Get Provinsi
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "JAWA TIMUR", 
            "code": "35"
        },
        {
            "id": 2,
            "name": "JAWA BARAT",
            "code": "32"
        }
    ]
}
```

### Get Kabupaten
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "MADIUN",
            "type": "KABUPATEN",
            "code": "14"
        },
        {
            "id": 2,
            "name": "MADIUN", 
            "type": "KOTA",
            "code": "77"
        }
    ]
}
```

### Get Alamat Lengkap
```json
{
    "success": true,
    "data": {
        "kelurahan": "DOLOPO",
        "kecamatan": "DOLOPO", 
        "kabupaten": "KABUPATEN MADIUN",
        "provinsi": "JAWA TIMUR",
        "kode_pos": "63174",
        "alamat_formatted": "DOLOPO, DOLOPO, KABUPATEN MADIUN, JAWA TIMUR 63174"
    }
}
```

## 🔄 Workflow Registrasi

1. **User memilih provinsi** → API load kabupaten
2. **User memilih kabupaten** → API load kecamatan  
3. **User memilih kecamatan** → API load kelurahan
4. **User memilih kelurahan** → API load alamat lengkap + kode pos
5. **User mengisi detail alamat** → Gabung dengan alamat wilayah
6. **Submit form** → Simpan semua data regional + detail alamat

## 📝 Model Relationships

```php
// Karyawan.php
public function provinsi() {
    return $this->belongsTo(Provinsi::class);
}

public function kabupaten() {
    return $this->belongsTo(Kabupaten::class);
}

public function kecamatan() {
    return $this->belongsTo(Kecamatan::class);
}

public function kelurahan() {
    return $this->belongsTo(Kelurahan::class);
}

// Provinsi.php
public function kabupaten() {
    return $this->hasMany(Kabupaten::class);
}

// Dan seterusnya...
```

## 🎨 CSS Classes untuk Mobile-First

```css
/* Form elements sudah menggunakan: */
.block.mt-2.w-full.h-12.text-base.rounded-lg.border-gray-300

/* Preview alamat: */
.bg-green-50.border.border-green-200.rounded-lg.p-3.text-sm
```

## 🚀 Deployment dan Performance

### Optimisasi Database
```sql
-- Index untuk query yang sering digunakan
CREATE INDEX idx_kabupaten_provinsi ON kabupaten(provinsi_id);
CREATE INDEX idx_kecamatan_kabupaten ON kecamatan(kabupaten_id);  
CREATE INDEX idx_kelurahan_kecamatan ON kelurahan(kecamatan_id);
CREATE INDEX idx_karyawan_wilayah ON karyawan(provinsi_id, kabupaten_id, kecamatan_id, kelurahan_id);
```

### Caching API Response
```php
// Tambahkan di WilayahController
public function getProvinsi() {
    $provinsi = Cache::remember('wilayah_provinsi', 3600, function () {
        return Provinsi::select('id', 'name', 'code')->orderBy('name')->get();
    });
    
    return response()->json(['success' => true, 'data' => $provinsi]);
}
```

## 🔍 Testing dan Debugging

### Test API Endpoints
```bash
# Test provinsi
curl http://10.10.10.44/api/wilayah/provinsi

# Test kabupaten
curl "http://10.10.10.44/api/wilayah/kabupaten?provinsi_id=1"

# Test dengan Artisan Tinker
php artisan tinker --execute="dump(App\Models\Provinsi::count())"
```

### Validation
- NIK tetap wajib dan unik
- Semua field regional wajib diisi
- Detail alamat minimal 10 karakter
- Validasi cascade (provinsi→kabupaten→kecamatan→kelurahan)

## 📖 Resources dan Referensi

- **Source Repository**: https://github.com/roedyrustam/API-Wilayah-2024
- **Data Source**: Kemendagri RI 2024
- **Laravel Documentation**: https://laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs

---

**Catatan**: Data sample saat ini hanya mencakup beberapa wilayah di Jawa Timur dan Jawa Barat. Untuk data lengkap seluruh Indonesia, gunakan dataset dari repository original roedyrustam/API-Wilayah-2024.
