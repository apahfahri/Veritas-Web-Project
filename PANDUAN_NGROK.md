# Panduan Menjalankan Website Veritas via Ngrok (Studi Kasus Pameran)

Dokumen ini berisi panduan lengkap langkah demi langkah untuk menjalankan website **Veritas** secara lokal di laptop server Anda dan membagikannya secara aman ke perangkat demo pameran (seperti HP, Tablet, atau Laptop lain) menggunakan **Ngrok** yang diunduh dari **Microsoft Store**.

---

## 🛠️ Persiapan Awal (Prasyarat)

1. **Koneksi Internet**: Laptop server dan seluruh perangkat demo pameran harus terhubung ke internet (bisa menggunakan Hotspot HP yang sama atau Wi-Fi pameran).
2. **Laragon**: Pastikan aplikasi Laragon sudah dijalankan dan service **MySQL** sudah aktif (klik **Start All** pada panel Laragon).
3. **Akun Ngrok**: Pastikan Anda sudah mendaftar akun gratis di [ngrok.com](https://ngrok.com) dan memiliki **Authtoken**.

---

## 🚀 Langkah-Langkah Menjalankan Sistem

### Langkah 1: Hubungkan Authtoken Ngrok (Hanya Sekali)
Karena Anda menginstal Ngrok melalui **Microsoft Store**, perintah `ngrok` telah terdaftar secara global di sistem Windows Anda.
1. Buka **Command Prompt (CMD)** biasa di laptop Anda.
2. Jalankan perintah berikut:
   ```bash
   ngrok config add-authtoken <TOKEN_ANDA>
   ```
   *(Ganti `<TOKEN_ANDA>` dengan token panjang yang Anda dapatkan dari dashboard akun Ngrok Anda).*

---

### Langkah 2: Lakukan Build Aset Frontend (PENTING!)
Agar perangkat demo pameran (HP/Tablet) dapat membaca CSS dan JavaScript dengan benar tanpa memerlukan koneksi ke server pembangunan lokal (Vite Dev Server), kita harus mengompilasi aset terlebih dahulu:
1. Buka CMD baru, arahkan ke folder project Veritas:
   ```bash
   cd c:\laragon\www\Veritas-Web-Project
   ```
2. Jalankan perintah kompilasi:
   ```bash
   npm run build
   ```
3. Tunggu hingga proses selesai (ditandai dengan munculnya daftar file CSS/JS di folder `public/build`).
   
> [!NOTE]
> Anda **tidak perlu** menjalankan `npm run dev` saat melakukan pameran. Cukup jalankan `npm run build` sekali di awal, atau jalankan kembali jika Anda baru saja melakukan perubahan pada file CSS, JS, atau layout Blade.

---

### Langkah 3: Jalankan Web Server Laravel
1. Buka CMD baru, pastikan berada di folder project (`c:\laragon\www\Veritas-Web-Project`).
2. Jalankan perintah server bawaan Laravel:
   ```bash
   php artisan serve
   ```
3. Biarkan CMD ini tetap terbuka selama pameran berlangsung. Server lokal Anda sekarang aktif di port `8000` (`http://127.0.0.1:8000`).

---

### Langkah 4: Aktifkan Terowongan Ngrok
1. Buka CMD baru lainnya.
2. Jalankan perintah berikut untuk mengarahkan Ngrok ke server Laravel lokal Anda:
   ```bash
   ngrok http 8000
   ```
3. CMD akan menampilkan antarmuka status Ngrok.
4. Cari bagian **Forwarding**, lalu salin (copy) alamat URL yang berawalan **`https://`**.
   *Contoh:*
   `Forwarding: https://a1b2-c3d4-e5f6.ngrok-free.app -> http://localhost:8000`

---

### Langkah 5: Akses dari Perangkat Demo Pameran
1. Buka browser (Chrome, Safari, dll.) di HP atau Tablet demo Anda.
2. Masukkan URL **HTTPS** dari Ngrok yang telah Anda salin (misalnya: `https://a1b2-c3d4-e5f6.ngrok-free.app`).
3. Jika muncul halaman konfirmasi awal dari Ngrok (kebijakan keamanan untuk akun gratis), klik tombol **"Visit Site"** di bagian tengah bawah.
4. Halaman website Veritas akan terbuka dengan tampilan responsif, CSS yang lengkap, dan database yang berfungsi penuh!

---

## 🔍 Mengapa Masalah CSS/JS Tidak Terpanggil Terjadi Sebelumnya?

Sebelumnya, Anda mendapati bahwa CSS dan JS tidak teraplikasikan dan halaman login admin menjadi berantakan saat diakses lewat Ngrok. Berikut penjelasannya dan bagaimana masalah ini telah diselesaikan:

1. **Vite Dev Server (`npm run dev`)**:
   * **Masalah**: Secara bawaan, Vite memuat aset secara dinamis melalui alamat `http://localhost:5173`. Ketika perangkat demo (HP/Tablet) mengakses lewat Ngrok, perangkat tersebut tidak memiliki akses ke port `5173` laptop server Anda. Akibatnya, browser di HP/Tablet gagal memuat CSS & JS.
   * **Solusi**: Kita telah membuat kode deteksi manifest otomatis di file Blade (`app.blade.php`, `admin.blade.php`, `auth.blade.php`). Jika Anda menjalankan `npm run build`, Laravel akan membaca file statis yang telah dikompilasi dari folder `public/build` sehingga dapat diakses oleh siapa saja lewat internet tanpa memerlukan Vite Dev Server.

2. **Masalah Mixed Content (HTTP vs HTTPS)**:
   * **Masalah**: Ngrok menyediakan alamat berprotokol **HTTPS** (`https://...`). Browser modern melarang pemuatan file aset (seperti CSS/JS) yang menggunakan protokol **HTTP** biasa demi alasan keamanan (disebut *Mixed Content*). Sebelumnya, Laravel mendeteksi dirinya berjalan di protokol `http` (karena `php artisan serve` berjalan di HTTP port 8000), sehingga link CSS yang dihasilkan Laravel menggunakan `http://.../build/assets/...` dan akhirnya diblokir oleh browser.
   * **Solusi**: Kami telah mengonfigurasi trust proxy pada [TrustProxies.php](file:///c:/laragon/www/Veritas-Web-Project/app/Http/Middleware/TrustProxies.php) dan menambahkan kode pendeteksi proxy otomatis di [AppServiceProvider.php](file:///c:/laragon/www/Veritas-Web-Project/app/Providers/AppServiceProvider.php). Sekarang, ketika diakses melalui Ngrok HTTPS, Laravel secara otomatis mendeteksi protokol tersebut dan mengamankan seluruh link aset, form action, dan redirect ke protokol **HTTPS**.

---

## 💡 Tips & Trik Selama Pameran

* **Matikan Mode Sleep Laptop**:
  Pastikan laptop server Anda diatur agar **"Never Sleep"** saat terhubung ke charger listrik. Jika laptop masuk ke mode sleep, koneksi Ngrok dan database MySQL akan mati, menyebabkan HP/Tablet demo kehilangan koneksi.
* **Ganti Koneksi / Ngrok Terputus**:
  Jika CMD Ngrok tertutup atau laptop berganti jaringan Wi-Fi, Anda hanya perlu menjalankan kembali **Langkah 4**. Karena menggunakan versi gratis, Ngrok akan menghasilkan alamat URL HTTPS baru secara acak. Silakan perbarui alamat URL di browser perangkat demo Anda.
* **Data Akun Demo (Seeded Data)**:
  Gunakan akun yang telah disiapkan di database untuk demonstrasi pameran:
  * **Superadmin**: `superadmin@veritas.com` (Password: `password123`)
  * **Subadmin**: `subadmin@veritas.com` (Password: `password123`)
