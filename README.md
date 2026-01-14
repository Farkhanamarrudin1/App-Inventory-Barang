# Sistem E-Library Peminjaman Buku  
**Berbasis Web menggunakan Laravel 12**

---

## 👥 Tim Pengembang  
**Kelas 17.6A.26 – Universitas Bina Sarana Informatika**

- **Artha Nugraha** — _17225023_  
- **Farkhan Amarrudin** — _17225055_  
- **Vinaka Sari** — _17215064_
- **Virgiani Angely Thersicy** — _17215128_  

---

## 📚 Deskripsi Aplikasi Sistem Inventory Barang

Aplikasi Sistem Inventory Barang ini dikembangkan menggunakan Framework Laravel 12. Aplikasi ini dirancang untuk digunakan di sekolah, instansi pemerintah, maupun perusahaan umum, dengan tujuan membantu pengelolaan data barang secara terstruktur, akurat, dan efisien.
Sistem ini mendukung pengelolaan inventaris mulai dari pendataan barang, kategori, stok, hingga riwayat keluar–masuk barang, sehingga memudahkan proses monitoring dan pelaporan inventaris.
Aplikasi ini memiliki 3 role pengguna, yaitu:
Administrator Inventory
Bertanggung jawab penuh terhadap pengelolaan sistem, data master, dan hak akses pengguna.
Operator Inventory
Bertugas melakukan penginputan dan pembaruan data barang, termasuk transaksi barang masuk dan keluar.
Pengguna / Staff
Dapat melihat data inventaris dan mengajukan permintaan penggunaan barang sesuai dengan kewenangan yang diberikan.
Beberapa fitur CRUD (Create, Read, Update, Delete) diimplementasikan menggunakan AJAX untuk meningkatkan pengalaman pengguna dengan mengurangi perpindahan halaman serta mempercepat proses pengelolaan data.
Aplikasi ini diharapkan mampu meningkatkan efektivitas manajemen inventaris, meminimalkan kesalahan pencatatan, serta mendukung pengambilan keputusan berbasis data inventaris yang akurat.

---

## ⚙️ Prasyarat Sistem

Pastikan perangkat telah terinstal:

- [Composer](https://getcomposer.org/)
- PHP **8.1**
- MySQL **14.5.x**
- XAMPP

---

## ✨ Fitur Aplikasi

- Dashboard  
- CRUD Barang 
- CRUD Kategori 
- Laporan PDF
- Halaman Logout  

---

## 🖼️ Preview Tampilan

**Login Page**  
![Dashboard](https://imgur.com/undefined)

**Dashboard**  
![Dashboard](https://i.imgur.com/IOgIyIi.png)

**Daftar Pengguna**  
![Pengguna](https://i.imgur.com/e3rkQ45.png)

**Daftar Kategori Buku**  
![Kategori Buku](https://i.imgur.com/WVEAyKi.png)

**Daftar Buku**  
![Buku](https://i.imgur.com/3Jarbbv.png)

**Daftar Peminjam Buku**  
![Peminjam](https://i.imgur.com/4z18siI.png)

**Histori Peminjaman Buku**  
![Histori](https://i.imgur.com/nzqiVSv.png)

---

## 🚀 Langkah Instalasi

1. **Install seluruh dependency**
   ```bash
   composer install

2. **Konfigurasi environment**
   ```bash
   cp .env.example .env
Atur konfigurasi database pada file .env

Ubah nilai APP_NAME sesuai nama aplikasi

3. **Migrasi dan seeding database**
   ```bash
   php artisan migrate --seed

4. **Key Generate**
   ```bash
   php artisan key:generate

5. **Jalankan server lokal**
   ```bash
   php artisan serve

## 🔐 Akun Default Login
Administrator Perpustakaan
Email    : admin@mail.com
Password : secret

Operator Perpustakaan
Email    : operator@mail.com
Password : secret

Anggota Perpustakaan
Email    : anggota@mail.com
Password : secret

## 🛠️ Dibuat Menggunakan

Laravel — PHP Web Framework

## 📄 Lisensi

Aplikasi ini bebas digunakan, dibagikan, dan dimodifikasi untuk keperluan pembelajaran.
Tidak diperbolehkan untuk diperjualbelikan.

## 🙏 Ucapan Terima Kasih

Terima kasih kepada rekan tim Kelas 17.6A.26 Universitas Bina Sarana Informatika, yang telah berkontribusi dan bekerja sama selama semester 6 dalam pengembangan Aplikasi Sistem Inventory Barang.

