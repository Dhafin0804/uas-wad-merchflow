# MerchFlow — Merchandise Management System

MerchFlow adalah aplikasi web berbasis Laravel untuk membantu pengelolaan operasional bisnis merchandise. Aplikasi ini dirancang untuk mempermudah pengelolaan produk, kategori, stok, dan pesanan dalam satu sistem.

## 1. Informasi Project

- **Nama aplikasi:** MerchFlow
- **Jenis aplikasi:** Web Application
- **Framework:** Laravel 12
- **Bahasa pemrograman:** PHP
- **Database:** MySQL
- **Frontend:** Laravel Blade, HTML, CSS, JavaScript
- **Deployment:** Clever Cloud

## 2. Fitur Aplikasi

### Authentication
- Login menggunakan email dan password.
- Logout dengan pengelolaan session.
- Halaman aplikasi dilindungi oleh autentikasi.
- Registrasi publik dinonaktifkan.

### Dashboard
- Menampilkan ringkasan jumlah produk, kategori, dan pesanan.
- Menampilkan informasi pesanan berdasarkan status.
- Menampilkan pesanan terbaru.

### Manajemen Produk
- Menampilkan daftar produk.
- Menambahkan produk.
- Mengedit informasi produk.
- Menghapus produk sesuai hak akses.
- Mengelola harga dan stok produk.

### Manajemen Kategori
- Menampilkan kategori.
- Menambahkan kategori.
- Mengedit kategori.
- Menghapus kategori sesuai hak akses.

### Manajemen Pesanan
- Membuat pesanan.
- Melihat detail pesanan.
- Mengedit pesanan dan statusnya.
- Mengelola perubahan stok berdasarkan transaksi pesanan.

### Role dan Hak Akses
Aplikasi memiliki dua jenis pengguna:

**Admin**
- Mengakses dashboard.
- Mengelola produk, kategori, dan pesanan.
- Memiliki hak menghapus data.

**Staff**
- Mengakses dashboard.
- Melihat, menambah, dan mengedit produk, kategori, serta pesanan.
- Tidak memiliki hak menghapus data.

## 3. Struktur Database

Database menggunakan MySQL dengan tabel utama:

| Tabel | Fungsi |
|---|---|
| users | Menyimpan akun Admin dan Staff |
| categories | Menyimpan kategori merchandise |
| products | Menyimpan informasi produk dan stok |
| orders | Menyimpan data pesanan |
| order_items | Menyimpan detail item pesanan |

Relasi database:
- `categories` memiliki banyak `products`.
- `users` memiliki banyak `orders`.
- `orders` memiliki banyak `order_items`.
- `products` memiliki banyak `order_items`.

## 4. Instalasi Project

Pastikan perangkat sudah memiliki:
- PHP 8.2 atau lebih baru.
- Composer.
- MySQL.
- Git.

Clone repository:

```bash
git clone https://github.com/Dhafin0804/uas-wad-merchflow.git
cd uas-wad-merchflow
```

Install dependency:

```bash
composer install
```

Salin konfigurasi environment:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur koneksi database MySQL pada file `.env`, kemudian jalankan:

```bash
php artisan migrate
```

Jalankan aplikasi:

```bash
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000
```

## 5. Deployment

Aplikasi di-deploy menggunakan Clever Cloud dengan repository GitHub:

https://github.com/Dhafin0804/uas-wad-merchflow

Alamat aplikasi:

https://uas-wad-merchflow.cleverapps.io

Konfigurasi environment production dikelola melalui dashboard Clever Cloud. Jangan memasukkan file `.env` asli atau credential database ke repository.

## 6. Keamanan Aplikasi

Beberapa mekanisme keamanan yang diterapkan:
- Authentication untuk membatasi akses halaman.
- Middleware role untuk membatasi hak akses Admin dan Staff.
- CSRF protection pada form.
- Blade escaping untuk membantu mencegah XSS.
- Eloquent ORM untuk interaksi database.
- Validasi input pada proses CRUD.
- Session regeneration saat login.
- Session invalidation saat logout.

## 7. Repository

Source code:

https://github.com/Dhafin0804/uas-wad-merchflow

---

**MerchFlow — Merchandise Management System**  
Project Web Application Development (WAD04).