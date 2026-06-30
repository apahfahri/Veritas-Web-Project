# Panduan Desain Antarmuka Dasbor Admin & Subadmin
## PT Katiga Veritas Indonesia

Dokumen ini berisi spesifikasi desain antarmuka pengguna khusus untuk Dasbor **Superadmin** dan **Subadmin**. Berbeda dengan halaman publik yang mengusung tema K3 (Hijau), dasbor ini menggunakan tema yang lebih tertutup, profesional, dan futuristik dengan kombinasi warna *slate*, *cyan*, dan *teal*.

---

## 1. Konsep & Identitas Visual
Desain antarmuka panel dasbor ini mengusung tema **Futuristik, Fokus, dan Elegan**. Desain ini dirancang khusus untuk operasional dan manajemen internal, mengutamakan kenyamanan mata dengan latar belakang panel navigasi yang gelap dipadukan dengan ruang kerja (*workspace*) yang terang dan bersih.

- **Karakter Desain**: Modern, berbasis kartu (*card-based*), menggunakan sudut membulat (*rounded corners*), transisi halus, dan antarmuka *glassmorphism* tipis pada header.
- **Font Utama**: **Outfit** (memberikan kesan geometris, *clean*, dan sangat modern).

---

## 2. Palet Warna (Color Palette)

### A. Sidebar & Latar Belakang (Sidebar & Background)
- **Latar Belakang Sidebar**: Menggunakan gradasi gelap dari Slate ke Indigo gelap.
  - Kelas Tailwind: `bg-gradient-to-b from-slate-900 to-indigo-950`
- **Latar Belakang Konten Utama (Workspace)**: Bersih dan terang.
  - Kelas Tailwind: `bg-slate-50`
- **Latar Belakang Header**: Transparan dengan efek blur (*glassmorphism*).
  - Kelas Tailwind: `bg-white/80 backdrop-blur-md`

### B. Warna Menu Aktif & Aksen (Active State & Accent)
Elemen yang aktif atau menonjol menggunakan palet cyan/teal cerah yang memberikan kontras tajam terhadap latar belakang sidebar yang gelap.
- **Menu Navigasi Aktif**: Gradasi warna Cyan ke Teal.
  - Kelas Tailwind: `bg-gradient-to-r from-cyan-600/90 to-teal-600/90` dipadukan dengan bayangan bercahaya `shadow-cyan-600/20`
- **Teks Subjudul / Aksen Kecil**: `text-cyan-400` atau `text-orange-400` (khusus label peran pengguna).

### C. Warna Teks (Text Colors)
- **Teks Utama (Headings)**: `text-slate-900`
- **Teks Paragraf / Sekunder**: `text-slate-500` atau `text-slate-600`
- **Teks Navigasi Inaktif (Sidebar)**: `text-slate-400`
- **Teks Navigasi Aktif / Hover (Sidebar)**: `text-white`

---

## 3. Tipografi (Typography)

Seluruh dasbor menggunakan Google Font **Outfit** (weight 300 - 900).
- **Judul Halaman (Page Title)**: `text-xl font-black tracking-tight text-slate-900`
- **Subjudul (Subtitle)**: `text-xs font-medium text-slate-500`
- **Menu Kategori**: `text-xs font-semibold uppercase tracking-wider text-slate-500`
- **Item Menu**: `text-sm font-medium`

---

## 4. Ikonografi (Wajib Flaticon)

Sesuai dengan standar pengembangan proyek ini, **semua ikon di halaman admin dan subadmin harus menggunakan Flaticon UIcons**.
- CDN Resmi yang digunakan: `<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>`
- Penulisan kelas ikon selalu dimulai dengan prefix Flaticon (misalnya `fi fi-rr-*` untuk versi *Regular Rounded* atau `fi fi-sr-*` untuk *Solid Rounded*).
- **Larangan**: Hindari penggunaan ikon SVG manual (*inline SVG*) atau *library* lain seperti FontAwesome untuk menjaga konsistensi gaya desain di seluruh panel.

---

## 5. Komponen Utama

### A. Sudut Membulat (Border Radius)
Dasbor ini mengutamakan lengkungan sudut yang cukup besar:
- **Komponen Kecil (Alert, Badges, Dropdown)**: `rounded-lg` atau `rounded-xl`
- **Komponen Sedang (Tombol Menu, Card)**: `rounded-2xl`
- **Komponen Besar (Modal / SweetAlert)**: `rounded-[32px]`

### B. Notifikasi / Alerts (Flash Messages)
Notifikasi keberhasilan atau kesalahan ditampilkan dalam bentuk lencana *rounded* di header:
- **Success**: `bg-teal-50 border border-teal-200/60 text-teal-700`
- **Error**: `bg-rose-50 border border-rose-200/60 text-rose-700`
- **Warning**: `bg-amber-50 border border-amber-200/60 text-amber-700`

### C. SweetAlert2 (Konfirmasi Pop-up)
Konfigurasi SweetAlert untuk tombol konfirmasi aksi (contoh: hapus data) harus selaras dengan estetika dasbor:
- `confirmButtonColor`: `'#0f172a'` (Slate-900)
- `cancelButtonColor`: `'#94a3b8'` (Slate-400)
- `popup` (Kotak Modal): `customClass.popup: 'rounded-[32px]'`
- `confirmButton`: `rounded-xl font-black uppercase tracking-widest text-xs px-6 py-3`

---

## 6. Efek Visual & Mikro-Interaksi

1. **Efek Kaca (Glassmorphism)**: Digunakan pada profil dropdown, header, dan peringatan *error* untuk membaurkan elemen dengan latar belakang. (`backdrop-blur-sm`, `bg-slate-800/40`)
2. **Smooth Hover**: Setiap menu sidebar, tautan, dan tombol harus memiliki transisi halus (`transition duration-200`). Menu hover berubah dari `text-slate-400` menjadi `bg-slate-800 text-white`.
3. **Tooltip Interaktif**: Menu navigasi saat di-*collapse* menggunakan *tooltip* kustom bernuansa *slate* (`bg-slate-800 text-white rounded-lg`) yang muncul perlahan.

---

## 7. Standar Tata Letak (Layout Standards)

Untuk mencapai konsistensi di seluruh halaman subadmin, gunakan standar komponen berikut:

### A. Halaman Daftar (Index / List Pages)
- **Wadah Tabel (Table Container)**: Selalu gunakan *card* yang bersih dengan lengkungan besar dan bayangan lembut.
  - Kelas Tailwind: `bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden`
- **Header Tabel (Table Headings)**: Bersih dan mudah dipindai.
  - Kelas Tailwind: `bg-slate-50 border-b border-slate-100 px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400`
- **Baris Tabel (Table Rows)**: Harus interaktif (*clickable*) jika menuju ke halaman detail tunggal.
  - Kelas Tailwind: `<tr onclick="window.location='...'" class="hover:bg-slate-50/80 transition cursor-pointer group">`
- **Filter & Pencarian (Search Bar)**: Bilah aksi (action bar) yang terletak di atas tabel/grid. Tata letak standar:
  - **Kiri**: Dropdown Filter (Status, Kategori, dll). `bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700`
  - **Tengah**: Field Pencarian (*Search Input*) panjang dan responsif. `<input class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500">`
  - **Kanan**: Tombol Cari dengan ikon. `bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl flex items-center gap-2`
- **Pagination**: Selalu gunakan komponen *Tailwind Pagination* standar dari Laravel. Letakkan di dalam wadah: `<div class="p-6 border-t border-slate-100">`
- **Tab Cepat (Quick Tabs)**: Tombol-tombol kecil untuk memfilter status (misal: "Akan Datang", "Riwayat") diletakkan dalam *card inline* dengan `bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 inline-flex gap-1`.

### B. Halaman Detail (Show / Detail Pages)
- **Navigasi Kembali (Back Navigation)**: Selalu sediakan tombol kembali di kiri atas konten utama. Jangan tambahkan "Page Title" atau "Subheading" berulang di sebelahnya untuk menjaga kebersihan antarmuka.
  - Kelas Tailwind: `<div class="mb-6 ..."><a href="..." class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest"><i class="fi fi-rr-arrow-left"></i> KEMBALI</a></div>`
- **Kotak Konten (Segmented Content Cards)**: Pecah informasi yang panjang ke dalam *card* terpisah agar tidak menumpuk.
  - Kelas Tailwind: `bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm`
- **Label Data (Data Labels)**: Tegas dan kecil.
  - Kelas Tailwind: `text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5`

### C. Tombol Aksi (Action Buttons)
- **Hindari Tombol Teks Repetitif**: Pada baris tabel, hindari menggunakan tombol teks berulang (seperti "Detail", "Edit", "Hapus").
- **Tombol Utama (Primary Button)**: `bg-slate-900 text-white hover:bg-slate-800 rounded-xl font-black transition`
- **Tombol Sekunder (Secondary)**: `bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl font-bold transition`
- **Tombol Aksi Tabel (Icons Only)**:
  - Detail/Masuk: Arahkan langsung ke baris tabel (buat tabel interaktif) atau letakkan *icon* panah bersih `fi-rr-angle-small-right` di ujung kanan.
  - Edit: `text-cyan-600 hover:text-cyan-800 hover:bg-cyan-50 w-8 h-8 rounded-lg flex items-center justify-center transition`
  - Hapus: `text-rose-500 hover:text-rose-700 hover:bg-rose-50 w-8 h-8 rounded-lg flex items-center justify-center transition`
