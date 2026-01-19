FTMMTIX – Platform Ticketing Event FTMM
=======================================

FTMMTIX adalah aplikasi web berbasis Laravel untuk manajemen dan penjualan tiket event di lingkungan FTMM. 

Repository ini berisi source code backend (Laravel) dan frontend (Vite + TailwindCSS) yang siap dijalankan secara lokal maupun dikembangkan lebih lanjut.

---

## 1. Identitas Proyek & Tim

- Kelompok: **B**  
- Judul Proyek: **FTMMTIX – Platform Ticketing Event FTMM**
- Anggota Kelompok:
  - Gizha Pradipta – NIM 164231011
  - Gracia Anglea Hasjim – NIM 164231056
  - Evan Nathaniel Susanto – NIM 164231061
  - Ghaly Anargya Azam R.N – NIM 164231069

---

## 2. Fitur Utama

- **Manajemen Event (Admin)**  
  Admin dapat membuat, mengedit, dan menghapus event; mengatur kuota peserta, kategori, harga, dan periode pendaftaran.

- **Pemesanan Tiket (User)**  
  Pengguna memilih event, melakukan pemesanan tiket, dan mendapatkan kode order yang digunakan untuk proses pembayaran.

- **Pembayaran & E‑Ticket (QR Code)**  
  Pengguna memilih bank, mengunggah bukti transfer, dan setelah terverifikasi sebagai **PAID**, sistem akan:
  - mengubah status order menjadi **PAID**,
  - menghasilkan tiket sesuai kuantitas,
  - menampilkan e‑ticket dengan QR code berisi kode tiket.

- **Dashboard & Data Warehouse (Admin)**  
  Admin dapat melihat ringkasan penjualan tiket, jumlah order, tiket terjual, dan total pembayaran.  
  Grafik tren penjualan tiket per bulan ditampilkan menggunakan **Chart.js**, berdasarkan pembayaran sukses (status **PAID**).

---

## 3. Teknologi yang Digunakan

### Backend / PHP

- PHP **^8.2**
- Laravel Framework **^12**
- Laravel Tinker (`laravel/tinker`)

### Frontend & Build Tools

- Vite **^7**
- Tailwind CSS **^4** (dengan plugin `@tailwindcss/vite`)
- Axios **^1.11**
- Laravel Vite Plugin **^2**
- Concurrently (menjalankan beberapa proses dev sekaligus)

### UI & Library Browser

- Bootstrap 5 (CSS & komponen dasar)
- Bootstrap Icons (ikon)
- Chart.js (visualisasi tren penjualan tiket per bulan)
- Layanan QR Code eksternal (`api.qrserver.com`) untuk generate QR pada e‑ticket

### Testing & Development

- PHPUnit
- FakerPHP
- Laravel Pint (code style)
- Laravel Sail (opsional, environment Docker)
- Nunomaduro Collision (error handler CLI)
- Mockery (testing)

---

## 4. Struktur Proyek (Ringkas)

- `app/`
  - `Http/Controllers/` – logika utama aplikasi (event, order, payment, dashboard DWH, dll.)
  - `Models/` – model Eloquent (Event, Order, OrderItem, Payment, Ticket, dll.)
- `resources/views/` – Blade template untuk halaman user, admin, payment, e‑ticket, dan dashboard DWH
- `database/migrations/` – definisi struktur tabel (users, events, orders, payments, tickets, tabel dimensi & fakta DWH, dll.)
- `database/seeders/` – seeder awal (admin, bank, dsb.)
- `public/` – aset publik (CSS, JS, gambar poster, hero, foto tim, dll.)

---

## 5. Persyaratan Sistem

- PHP **^8.2**
- Composer
- MySQL / MariaDB
- Node.js (disarankan versi yang kompatibel dengan Vite 7 dan Tailwind 4)
- NPM

---

## 6. Instalasi & Menjalankan Proyek (Local)

1. **Clone / Salin Project**
   - Letakkan source code di folder web server, contoh (XAMPP di Windows):
     - `c:\xampp\htdocs\FTMMTix`

2. **Siapkan file environment**
   - Duplikasi file `.env.example` menjadi `.env`
   - Atur konfigurasi database MySQL (nama database, user, password)

3. **Install dependency PHP (Composer)**
   ```bash
   composer install
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan migrasi & seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Install dependency frontend (NPM)**
   ```bash
   npm install
   ```

7. **Jalankan aplikasi (mode pengembangan)**

   - **Opsi 1 – dua terminal terpisah**
     ```bash
     php artisan serve
     npm run dev
     ```

   - **Opsi 2 – sekali jalan (script `dev` di `composer.json`)**
     ```bash
     composer run dev
     ```

8. **Akses aplikasi**
   - Buka browser dan akses:
     - http://127.0.0.1:8000
   - Login admin menggunakan akun yang dibuat oleh seeder (lihat file seeder admin di `database/seeders`).

---

## 7. Catatan Pengembangan

- Struktur kode mengikuti standar default Laravel 12 (MVC).
- Autoload diatur pada `composer.json` untuk namespace `App\\`, `Database\\Factories\\`, dan `Database\\Seeders\\`.
- Script `dev` di `composer.json` sudah mengatur:
  - `php artisan serve`
  - `php artisan queue:listen`
  - `php artisan pail`
  - `npm run dev`
  sehingga proses development dapat dijalankan dengan satu perintah: `composer run dev`.

---

## 8. Lisensi

Proyek ini dikembangkan untuk keperluan tugas/aktivitas akademik.  
Hak cipta kode mengikuti ketentuan pemilik repository dan lingkungan akademik terkait.

---

## 9. Kontak

Untuk pertanyaan atau pengembangan lanjutan, silakan hubungi anggota tim melalui kanal resmi yang digunakan di kelas / institusi.
