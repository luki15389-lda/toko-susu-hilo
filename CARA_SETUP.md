# Cara Pasang — HiLo Store (Laravel)

Kalau kamu **sudah pernah** setup project ini sebelumnya, langsung ke bagian
**"Update ke versi terbaru"** di bawah.

## Setup dari awal (kalau belum pernah sama sekali)

1. `laravel new toko-susu-hilo` di folder `www` (Laragon) → pilih **Blade**, starter kit **None**
2. Copy semua isi folder `laravel-app` (bukan folder itu sendiri) ke root project barumu, merge kalau ditanya
3. Daftarkan middleware admin di `bootstrap/app.php`:
   ```php
   $middleware->alias([
       'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
   ]);
   ```
4. Setting `.env`, buat database `toko_susu_hilo`
5. `php artisan migrate` → `php artisan db:seed` → `php artisan storage:link`
6. Buka `http://toko-susu-hilo.test`. Admin login: lihat bagian "Akses Admin" di bawah

---

## Update ke versi terbaru

Timpa semua file di folder `laravel-app` ini ke project kamu. Tidak perlu `npm install`.

### ⚠️ Wajib migrate + seed ulang (ada tabel & data baru)
```
php artisan migrate
php artisan db:seed
php artisan storage:link
```
Aman dijalankan — tidak menghapus produk yang sudah ada. Yang baru: tabel `categories`
(5 kategori HiLo otomatis dibuat) dan folder upload `storage/categories`.

### 🔑 Akses Admin (URL-nya sudah diganti, tidak lagi `/admin/login`)
```
http://toko-susu-hilo.test/tsh-back-4il0/login
```
Email: `admin@tokosusuhilo.com` — Password: `admin123` (ganti setelah login pertama).

Mau ganti kode rahasia `tsh-back-4il0` jadi kode lain? Buka `routes/web.php`, cari &
ganti semua kemunculan string `tsh-back-4il0` jadi kode pilihanmu sendiri.

### Semua perbaikan di versi ini
1. **Qty di semua kartu produk** — lebar kotak angka diperbesar & panah bawaan browser
   dihilangkan, sekarang angka 2 digit (misal "13") tidak lagi kepotong jadi "1"
2. **Topbar hijau** ("Gratis ongkir... / Butuh bantuan...") di atas navbar — dihapus total
3. **Halaman Detail Produk** — jarak ke navbar dirapikan, foto produk sekarang tampil penuh
   dengan latar (bukan kotak sempit berbingkai lagi)
4. **Halaman Produk** — jarak konten ke navbar dirapikan. Ikon kategori di sidebar diganti
   (bukan ikon kopi). **Bug pencarian di-fix total**: sebelumnya URL bisa berantakan jadi
   `?q=sc?q=sch?q=school` dan hasil pencarian bisa kosong padahal ada produk — sekarang
   pencarian selalu memakai alamat dasar yang bersih setiap kali fetch data, jadi tidak
   akan numpuk lagi & selalu akurat
5. **Keranjang**:
   - Ubah jumlah (qty) sekarang **tanpa reload/loading halaman** (pakai AJAX)
   - Hapus item juga tanpa reload
   - Setelah isi form "Pesan via WhatsApp" dan klik "Pesan Sekarang" → keranjang beneran
     **dikosongkan di server**. Setelah popup sukses ditutup, halaman keranjang otomatis
     menunjukkan keadaan kosong — sesuai logika "barang sudah dipesan"
   - Jarak konten ke navbar dirapikan
6. **Admin — menu baru**:
   - **Kategori**: CRUD kategori sendiri (nama + gambar), otomatis dipakai di form produk,
     filter di halaman Produk publik, dan kartu kategori di Home. Hapus kategori tidak
     menghapus produk yang sudah memakainya
   - **Promo**: shortcut ke daftar produk yang ditandai Promo (dari centang yang sudah ada
     di form produk)
   - **URL login diganti** jadi `/tsh-back-4il0/login` (lihat bagian "Akses Admin" di atas)
     supaya tidak gampang ditebak orang lain
7. **Alamat** di semua halaman publik disederhanakan jadi cukup "Jakarta"

### Struktur halaman
| Menu Navbar | URL |
|---|---|
| Home | `/` |
| Produk | `/produk` |
| Tentang Kami | `/tentang-kami` |
| Promo | `/promo` |
| Kontak | `/kontak` |
| 🛒 Keranjang | `/keranjang` |
| *(tidak di navbar)* | `/tsh-back-4il0/login` — Dashboard, Produk, **Kategori**, **Promo** |
