# GudangKu - Sistem Manajemen Inventaris Gudang

Aplikasi web sistem manajemen inventaris gudang berbasis **Laravel (arsitektur MVC)** dan **MySQL / SQLite** yang dirancang untuk memantau, mencatat, dan mengelola stok barang, kategori, pengguna, serta mutasi barang masuk dan keluar secara akurat dan real-time.

Project ini disusun untuk memenuhi **Ujian Akhir Semester (UAS) Mata Kuliah Web Application Development (WAD04)**.

---

## 📋 Identitas Mahasiswa & Informasi Project

| Item | Keterangan |
| :--- | :--- |
| **Nama Mahasiswa** | Kevin Aprianto |
| **NIM** | 25120300004 |
| **Mata Kuliah** | Web Application Development (WAD04) |
| **Repository GitHub** | [https://github.com/KevinAprianto13/25120300004_KEVIN-APRIANTO_WAD_UAS](https://github.com/KevinAprianto13/25120300004_KEVIN-APRIANTO_WAD_UAS) |
| **Dosen Pengampu** | [Isi Nama Dosen Pengampu] |
| **Format Pengerjaan** | Individu |
| **Nama Aplikasi** | **GudangKu** |
| **Studi Kasus** | Sistem Manajemen Inventaris Gudang |
| **Teknologi Backend** | Laravel 11 / 13 (Arsitektur MVC) |
| **Database** | MySQL (Relasional) & SQLite |
| **Akses Data** | Eloquent ORM |
| **Templating** | Blade Engine |
| **Autentikasi** | Laravel Session & Custom RoleMiddleware |

---

## 🔑 Akun Pengujian (Demo Accounts)

Sistem telah dilengkapi seeder data awal dengan akun uji sesuai spesifikasi draf:

| Role | Email | Password | Hak Akses & Wewenang |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@gudangku.test` | `password123` | Akses penuh: Dashboard, CRUD Kategori, CRUD Produk, Catat Transaksi, Riwayat Semua Transaksi, Manajemen Pengguna & Role |
| **Staff Gudang** | `staff@gudangku.test` | `password123` | Akses operasional: Dashboard, Lihat Produk, Catat Transaksi Masuk/Keluar, Riwayat Transaksi Milik Sendiri |

---

## ✨ Fitur-Fitur Utama (Sesuai Draf CPMK)

1. **Autentikasi & Session Terproteksi**:
   - Registrasi pengguna baru (default role: `staff`).
   - Login & logout dengan proteksi Session Fixation (`session()->regenerate()`, `session()->invalidate()`).
2. **Dashboard Inventaris Real-Time**:
   - Total produk, total kategori, jumlah produk stok menipis, dan total unit fisik.
   - Tabel 5 transaksi mutasi stok terkini.
   - Panel peringatan dini untuk produk dengan stok di bawah batas minimum (`min_stock`).
3. **CRUD Kategori Produk (Khusus Admin)**:
   - Pengelolaan kelompok barang.
   - Proteksi relasi data: Kategori yang memiliki produk tidak dapat dihapus (`ON DELETE RESTRICT`).
4. **CRUD Katalog Produk (Admin & Staff)**:
   - Staff & Admin dapat melihat katalog dan detail spesifikasi produk.
   - Admin dapat menambah, mengubah, dan menghapus produk.
   - Fitur pencarian instan berdasarkan nama atau SKU, serta filter berdasarkan kategori dan status stok (menipis/habis).
   - Proteksi relasi: Produk dengan riwayat mutasi stok tidak dapat dihapus (`ON DELETE RESTRICT`).
5. **Pencatatan Transaksi Stok Masuk & Keluar (Admin & Staff)**:
   - Transaksi Barang Masuk (`in`) otomatis menambah stok produk.
   - Transaksi Barang Keluar (`out`) otomatis mengurangi stok produk.
   - **Logika Validasi Backend**: Transaksi keluar otomatis ditolak dengan pesan error jika jumlah permintaan melebihi stok yang tersedia.
   - **Database Transaction (`DB::beginTransaction()`, `DB::commit()`, `DB::rollBack()`)**: Menjamin atomisitas penyimpanan mutasi dan pembaruan stok.
6. **Riwayat Transaksi Terfilter Role**:
   - Admin dapat memantau seluruh transaksi dari seluruh personil gudang.
   - Staff hanya dapat melihat transaksi yang dicatat oleh akun miliknya sendiri.
7. **Manajemen Pengguna & Role (Khusus Admin)**:
   - Admin dapat mengelola akun pengguna, mengubah role (Admin/Staff), dan mereset password.
   - Pencegahan penghapusan akun sendiri (*self-delete prevention*) dan proteksi integritas user bertransaksi.
8. **Validasi Input Server-Side**:
   - Seluruh input form divalidasi ketat menggunakan Laravel `FormRequest` (`StoreCategoryRequest`, `StoreProductRequest`, `StoreTransactionRequest`, `StoreUserRequest`).
9. **Role-Based Access Control (RBAC) & Error 403**:
   - Dibatasi melalui `RoleMiddleware`. Staff yang mencoba mengakses menu khusus admin akan diarahkan ke halaman kustom **403 Forbidden**.

---

## 🗄️ Struktur Database & Relasi (CPMK1)

Aplikasi menggunakan 4 tabel utama dengan relasi 1 ke N:
- `categories` ke `products`: **1 ke N** (Satu kategori memiliki banyak produk).
- `products` ke `stock_transactions`: **1 ke N** (Satu produk memiliki banyak catatan transaksi).
- `users` ke `stock_transactions`: **1 ke N** (Satu pengguna dapat mencatat banyak transaksi).

> **Integritas Relasi**: Foreign Key diatur dengan aturan `ON DELETE RESTRICT` pada level database maupun controller agar riwayat historis inventaris gudang tetap utuh dan terlindungi dari manipulasi penghapusan sengaja.

---

## 🚀 Panduan Menjalankan di Komputer Lokal

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

### 1. Masuk ke direktori project
```bash
cd gudangku
```

### 2. Salin file konfigurasi environment
```bash
cp .env.example .env
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Konfigurasi Database

#### Opsi A: Menggunakan MySQL (Disarankan untuk pengumpulan/evaluasi)
1. Pastikan service MySQL Anda (XAMPP / Laragon / MySQL Server) telah berjalan di port `3306`.
2. Buat database baru bernama `gudangku`:
   ```sql
   CREATE DATABASE gudangku;
   ```
3. Sesuaikan file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gudangku
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Atau import langsung file `gudangku.sql` ke dalam database `gudangku` melalui phpMyAdmin).*

#### Opsi B: Menggunakan SQLite (Siap pakai tanpa instalasi database server terpisah)
File database SQLite telah terkonfigurasi dan termigrasi di `database/database.sqlite`.

### 5. Jalankan Web Server Laravel
```bash
php artisan serve
```
Buka browser di alamat: **`http://127.0.0.1:8000`**

Login menggunakan akun:
- **Admin**: `admin@gudangku.test` | Password: `password123`
- **Staff**: `staff@gudangku.test` | Password: `password123`

---

## ☁️ Panduan Deployment ke Railway (CPMK5)

1. Buat repository baru di GitHub dan lakukan push seluruh kode:
   ```bash
   git init
   git add .
   git commit -m "feat: complete GudangKu warehouse management system"
   git branch -M main
   git remote add origin https://github.com/[username]/gudangku.git
   git push -u origin main
   ```
2. Buka [Railway.app](https://railway.app), klik **New Project** → **Deploy from GitHub repo**.
3. Tambahkan resource **MySQL** pada project yang sama di Railway.
4. Pada service aplikasi web di Railway, atur tab **Variables**:
   - `APP_NAME`: `GudangKu`
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_KEY`: *[Salin dari php artisan key:generate --show]*
   - `APP_URL`: *[Domain publik yang di-generate Railway]*
   - `DB_CONNECTION`: `mysql`
   - `DB_HOST`: `${{MySQL.MYSQLHOST}}`
   - `DB_PORT`: `${{MySQL.MYSQLPORT}}`
   - `DB_DATABASE`: `${{MySQL.MYSQLDATABASE}}`
   - `DB_USERNAME`: `${{MySQL.MYSQLUSER}}`
   - `DB_PASSWORD`: `${{MySQL.MYSQLPASSWORD}}`
5. Atur **Custom Build / Start Command** di Railway Settings:
   ```bash
   php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
6. Klik **Generate Domain** di menu Networking. Akses Live URL aplikasi dan lakukan pengujian login serta pencatatan transaksi.

---

## 🔒 Implementasi Keamanan Web (CPMK4)

| Jenis Ancaman | Bentuk Perlindungan | Lokasi Implementasi |
| :--- | :--- | :--- |
| **CSRF** | Token CSRF & Header Verification | Direktif `@csrf` di setiap form Blade dan middleware `VerifyCsrfToken` |
| **XSS** | Output Escaping | Sintaks Blade `{{ $variable }}` otomatis melakukan `htmlspecialchars()` |
| **SQL Injection** | Prepared Statements & Parameterized Query | Seluruh query menggunakan Eloquent ORM & Query Builder tanpa raw query concatenation |
| **Session Hijacking / Fixation** | Regenerasi Session ID | Pemanggilan `session()->regenerate()` saat login, `session()->invalidate()` dan `session()->regenerateToken()` saat logout di `AuthController.php` |
| **Password Leakage** | Algoritma Hashing Modern | `Hash::make()` menggunakan enkripsi bcrypt dengan work factor 12 |
| **Akses Ilegal / Privilege Escalation** | Role-Based Access Control | `RoleMiddleware.php` mengawal rute admin dan menolak unauthorized request dengan HTTP 403 Forbidden |

---

## 📽️ Poin-Poin Persiapan Video Esai & Demo (CPMK)

Sesuai instruksi pada draf Bagian K:
1. **Alur Data & Pola MVC**: Jelaskan alur request dari Route (`routes/web.php`) → Middleware (`RoleMiddleware`) → Controller (`ProductController`) → Model (`Product`) → Database MySQL → View (`resources/views/products/index.blade.php`).
2. **Struktur Database & Foreign Key**: Jelaskan alasan penggunaan 4 tabel relasional dan fungsi klausul `ON DELETE RESTRICT` untuk menjaga histori transaksi tidak terhapus jika barang/pengguna dihapus.
3. **Logika Transaksi Atomik**: Tunjukkan penggunaan blok `DB::beginTransaction()`, pengecekan stok negatif, `increment`/`decrement`, dan mekanisme `DB::rollBack()` saat terjadi error.
4. **Penanganan Error**: Tunjukkan validasi `FormRequest`, alert pesan kesalahan di form, serta tampilan kustom halaman `403 Forbidden`.
5. **Implementasi Keamanan**: Tunjukkan token `@csrf`, hashing password bcrypt, dan session regeneration.

---

*Disusun dengan standar akademik terbaik untuk Ujian Akhir Semester Web Application Development.*
