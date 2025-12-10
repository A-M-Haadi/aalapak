# 🛍️ Aalapak - E-Commerce Platform

**Aalapak** adalah platform E-Commerce multi-peran yang dirancang untuk menghubungkan penjual (*Seller*) dan pembeli (*Buyer*) dalam satu ekosistem yang terintegrasi.

Aplikasi ini dibangun menggunakan framework **Laravel 11** dengan fokus pada keamanan, kemudahan penggunaan, dan fitur yang lengkap; mulai dari manajemen toko, manajemen stok, hingga ulasan produk.

---

## 📌 Deskripsi Proyek

Proyek ini bertujuan untuk menyediakan solusi e-commerce yang mendukung 4 peran pengguna utama: **Admin**, **Seller**, **Buyer**, dan **Public User (Guest)**. Sistem ini memungkinkan transaksi jual beli yang terstruktur dengan validasi admin untuk setiap penjual baru demi keamanan platform.

> **Proyek ini dibuat untuk memenuhi Tugas Final Praktikum Pemrograman Web 2025.**

---

## 🚀 Fitur Utama

### 1. 👨‍💼 Admin (Administrator)
* **Manajemen Kategori:** Membuat, mengedit, dan menghapus kategori produk (*CRUD*).
* **Verifikasi Seller:** Memvalidasi pendaftaran Seller baru (*Approve/Reject*).
* **Manajemen Pengguna:** Memantau daftar pengguna dan menghapus akun yang melanggar aturan.
* **Moderasi Produk:** Menghapus produk dari Seller manapun jika tidak sesuai ketentuan.

### 2. 🏪 Seller (Penjual)
* **Pendaftaran & Verifikasi:** Mendaftar dan menunggu persetujuan Admin sebelum bisa berjualan.
* **Manajemen Toko:** Mengelola profil toko (Nama, Deskripsi, Logo).
* **Manajemen Produk:** Mengelola inventaris produk (*CRUD*), stok, harga, dan gambar.
* **Manajemen Pesanan:** Memperbarui status pesanan (*Menunggu Pembayaran* -> *Diproses* -> *Selesai*).
* **Dashboard Statistik:** Melihat ringkasan performa toko (Total Produk, Pesanan, Pendapatan).

### 3. 🛒 Buyer (Pembeli)
* **Pencarian & Filter:** Mencari produk berdasarkan nama, kategori, dan harga.
* **Keranjang Belanja:** Menambah produk, mengubah jumlah, dan menghapus item.
* **Wishlist (Favorit):** Menyimpan produk yang disukai.
* **Alamat Pengiriman:** Mengelola daftar alamat (*CRUD*) untuk checkout.
* **Checkout:** Membuat pesanan dengan memilih alamat pengiriman.
* **Riwayat Pesanan:** Melacak status pesanan dan detail pembelian.
* **Rating & Review:** Memberikan ulasan dan bintang (1-5) pada produk yang telah dibeli.

### 4. 🕵️ Public User (Guest)
* **Katalog Produk:** Melihat daftar produk unggulan dan detailnya.
* **Pencarian:** Menggunakan fitur pencarian dan filter.
* **Autentikasi:** Diarahkan Login/Register untuk fitur transaksional.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 11](https://laravel.com)
* **Bahasa:** PHP 8.2+
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Authentication:** Laravel Breeze

---

## ⚙️ Instalasi & Cara Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone [https://github.com/username-anda/aalapak.git](https://github.com/username-anda/aalapak.git)
cd aalapak
````

### 2\. Install Dependensi

Pastikan Anda sudah menginstal PHP dan Node.js.

```bash
composer install
npm install
```

### 3\. Konfigurasi Environment

Duplikat file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 4\. Generate Key & Migrasi

Generate application key dan jalankan migrasi database beserta seeder (data dummy).

```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

### 5\. Setup Storage

Agar gambar produk dan logo toko bisa diakses publik.

```bash
php artisan storage:link
```

### 6\. Jalankan Aplikasi

Buka dua terminal terpisah untuk menjalankan backend dan frontend secara bersamaan.

**Terminal 1 (Laravel Server):**

```bash
php artisan serve
```

**Terminal 2 (Vite Build/Dev):**

```bash
npm run dev
```

Akses aplikasi di browser melalui: [http://127.0.0.1:8000](http://127.0.0.1:8000)

-----

## 🔑 Akun Demo (Default)

Jika Anda menjalankan perintah `php artisan migrate:fresh --seed`, Anda dapat menggunakan akun Administrator berikut untuk masuk:
Admin
  * **Email:** `admin@gmail.com`
  * **Password:** `admin123`

> **Catatan:** Untuk peran **Seller** dan **Buyer**, silakan lakukan registrasi akun baru melalui aplikasi untuk mencoba alur pengguna dari awal.

-----

## 📸 Tangkapan Layar (Screenshots)


## 👨‍💻 Author

Dibuat oleh **A.M. Haadi Assa'di**

  * **Tugas Final Praktikum Pemrograman Web 2025**
  * Universitas Hasanuddin (Sistem Informasi)

-----

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
