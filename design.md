# Panduan Desain Antarmuka Pengguna (UI Design System)
## PT Katiga Veritas Indonesia

Dokumen ini berisi spesifikasi desain antarmuka pengguna (UI) yang diterapkan pada proyek **PT Katiga Veritas Indonesia**. Panduan ini berfungsi sebagai acuan bagi pengembang (developer) dan desainer dalam mempertahankan konsistensi visual di seluruh halaman aplikasi.

---

## 1. Konsep & Identitas Visual
Desain antarmuka proyek ini mengusung tema **Profesional, Terpercaya, dan Modern**. Mengingat perusahaan ini bergerak di bidang K3 (Keselamatan dan Kesehatan Kerja) dengan mengedepankan nilai-nilai syariah, elemen visual yang dipilih memancarkan keamanan, kebersihan, dan kredibilitas.

- **Karakter Desain**: Rounded (lembut), berbayang halus (soft shadow), responsif, dan interaktif dengan mikro-animasi.
- **Font Utama**: **Montserrat** (memberikan kesan kokoh, modern, dan sangat terbaca).

---

## 2. Palet Warna (Color Palette)

Aplikasi ini menggunakan kombinasi warna bertema hijau (K3) dengan variasi gradasi dan warna aksen pendukung untuk membedakan kategori layanan.

### A. Warna Utama & Aksen (Brand Colors)
| Warna | Kode Hex | Penggunaan Utama | Kelas Tailwind |
| :--- | :--- | :--- | :--- |
| **Forest Green (Primary)** | `#1E6B3D` | Warna identitas K3, header text, background tombol utama, footer background. | `text-[#1E6B3D]`, `bg-[#1E6B3D]` |
| **Emerald Green (Accent)** | `#3CDA7D` | Gradasi tombol, aksen dekorasi hero, efek hover. | `text-[#3CDA7D]`, `bg-[#3CDA7D]` |
| **Gradasi K3** | `from-[#1E6B3D] to-[#3CDA7D]` | Hero section, banner, tombol CTA, header verifikasi. | `bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D]` |

### B. Warna Layanan (Service Category Colors)
Setiap layanan memiliki aksen warna representatif yang konsisten:
- **Pelatihan**: Nuansa Hijau (`bg-green-50`, `text-green-600`)
- **Konsultasi**: Nuansa Biru (`bg-blue-50`, `text-blue-600` / `#3B82F6`)
- **Audit**: Nuansa Teal (`bg-teal-50`, `text-teal-600` / `#14B8A6`)

### C. Warna Netral & Latar Belakang (Neutral Colors)
- **Latar Belakang Utama**: Putih (`#FFFFFF`) & Abu-abu Terang (`#F5F7FA` atau `#F9FAFB`)
- **Teks Utama (Heading)**: Abu-abu Gelap / Slate (`#111827` atau `#0F172A`) -> `text-gray-900` / `text-slate-900`
- **Teks Pendukung (Body)**: Abu-abu Sedang (`#4B5563` atau `#6B7280`) -> `text-gray-600` / `text-gray-500`
- **Border / Garis**: Abu-abu Sangat Terang (`#F3F4F6` atau `#E5E7EB`) -> `border-gray-100` / `border-slate-100`

---

## 3. Tipografi (Typography)

Seluruh teks menggunakan Google Font **Montserrat** yang diimpor melalui file [app.blade.php](file:///c:/laragon/www/Veritas-Web-Project/resources/views/layouts/app.blade.php).

### Struktur Hirarki Teks
```html
<!-- Hero Title / H1 -->
<h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.1]">
  Solusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D]">K3 Profesional</span>
</h1>

<!-- Section Subtitle (Kicker) -->
<h2 class="text-xs font-bold text-[#1E6B3D] uppercase tracking-[0.2em] mb-3">
  Layanan Utama
</h2>

<!-- Section Title / H3 -->
<h3 class="text-3xl md:text-4xl font-black text-gray-900">
  Solusi K3 Terintegrasi
</h3>

<!-- Body Text / Paragraph -->
<p class="text-base text-gray-600 leading-relaxed">
  Wujudkan lingkungan kerja yang aman dan produktif...
</p>

<!-- Label / Small Caps -->
<span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
  Ingat Akun Saya
</span>
```

- **Kunci Desain**: Menggunakan *uppercase* dengan tracking lebar (`tracking-widest` atau `tracking-[0.2em]`) untuk label kecil atau sub-judul.

---

## 4. Komponen dan Pola UI (UI Components)

### A. Tombol (Buttons)

Tombol dirancang dengan sudut membulat lebar (`rounded-2xl` atau `rounded-xl`) untuk memberikan kesan modern dan premium.

1. **Tombol Utama (Primary Action)**:
   Menggunakan gradasi warna brand dengan bayangan lembut yang melayang:
   ```html
   <a href="/training" class="bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-[#1E6B3D]/20 hover:scale-105 transition-all flex items-center gap-2">
       <i class="fi fi-rr-graduation-cap"></i> Mulai Pelatihan
   </a>
   ```

2. **Tombol Sekunder (Secondary Action)**:
   Berwarna latar putih, dengan garis tepi tipis dan interaksi hover abu-abu terang:
   ```html
   <a href="/consultation" class="bg-white text-gray-700 border-2 border-gray-100 px-8 py-4 rounded-2xl font-bold hover:bg-gray-50 transition-all flex items-center gap-2">
       <i class="fi fi-rr-comment-alt"></i> Konsultasi Gratis
   </a>
   ```

3. **Tombol Kontak WhatsApp**:
   Menggunakan logo resmi WhatsApp dan latar belakang putih bersih untuk menonjolkan fungsi chat:
   ```html
   <a href="https://wa.me/6281234567890" target="_blank" class="bg-white text-[#1E6B3D] px-10 py-5 rounded-2xl font-black shadow-xl hover:scale-105 transition-all flex items-center gap-3">
       <i class="fi fi-brands-whatsapp text-2xl text-[#25D366]"></i> Hubungi via WhatsApp
   </a>
   ```

### B. Kartu (Cards)

Kartu UI di seluruh situs menggunakan sudut membulat yang dramatis (`rounded-[2rem]` atau `rounded-3xl`), border minimalis, dan transisi pergerakan ke atas saat di-hover.

```html
<div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 text-green-600">
        <i class="fi fi-rr-graduation-cap"></i>
    </div>
    <h4 class="text-xl font-bold mb-3 text-gray-900">Pelatihan K3</h4>
    <p class="text-sm text-gray-500 leading-relaxed mb-6">Sertifikasi resmi BNSP & Kemnaker...</p>
    <a href="/training" class="text-[#1E6B3D] font-bold flex items-center gap-2 group/link">
        Selengkapnya <span class="group-hover/link:translate-x-2 transition-transform">→</span>
    </a>
</div>
```

### C. Formulir & Input (Forms & Inputs)
Kotak input menggunakan padding tinggi, warna latar belakang abu-abu terang yang beralih menjadi putih saat aktif, dan efek ring fokus berwarna brand/aksesoris:

```html
<input type="text" placeholder="Masukkan nomor..." 
       class="w-full bg-slate-50 border border-slate-100 px-5 py-4 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-[#1E6B3D]/10 focus:border-[#1E6B3D] focus:bg-white transition-all">
```

---

## 5. Efek Unik & Mikro-Animasi

Aplikasi ini menggunakan beberapa efek visual dan transisi kustom yang didefinisikan dalam kode CSS inline atau Tailwind utilitas:

1. **Clip Path Kustom**:
   - `.clip-path-hero`: Memotong bagian visual hero secara diagonal (`polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%)`).
   - `.clip-path-divider`: Pemisah section miring (`polygon(0 0, 100% 0, 100% 100%, 0 0)`).

2. **Animasi Melayang Lambat (`animate-bounce-slow`)**:
   Digunakan pada elemen floating card agar bergerak naik-turun secara perlahan (4 detik):
   ```css
   @keyframes bounce-slow {
       0%, 100% { transform: translateY(0); }
       50% { transform: translateY(-10px); }
   }
   .animate-bounce-slow {
       animation: bounce-slow 4s infinite ease-in-out;
   }
   ```

3. **Fade In Up (`animate-fade-in-up`)**:
   Membuat konten masuk dengan transisi mulus dari arah bawah ke atas (1 detik):
   ```css
   @keyframes fade-in-up {
       from { opacity: 0; transform: translateY(30px); }
       to { opacity: 1; transform: translateY(0); }
   }
   ```

4. **Experts Expandable Carousel**:
   Desain interaktif dua lapis pada profil pemateri di mana kartu melebar secara horizontal (`160px` menjadi `440px`) ketika di-hover untuk memunculkan portofolio:
   - Lebar normal: `width: 160px; overflow: hidden;`
   - Hover lebar: `width: 440px;` dengan transisi `cubic-bezier(0.4, 0, 0.2, 1)`.

---

## 6. Panduan Ikonografi & Media

- **Ikonografi**: Menggunakan CDN **FlatIcon UIcons** (`https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons/css/all/all.min.css`).
  - Menggunakan kelas `fi fi-rr-*` (Regular Rounded) untuk ikon UI biasa dan `fi fi-sr-*` (Solid Rounded) untuk status aktif/bintang rating.
- **Media (Gambar)**:
  - Rasio gambar utama: Aspect ratio 4:5 portrait atau 3:4 dengan sudut melengkung tinggi (`rounded-[2rem]` / `rounded-3xl`).
  - Overlay: Efek gradasi linear transparan ke warna brand (`rgba(30,107,61,0.3)`) untuk menyatukan nuansa gambar dengan tema situs.

---

*Catatan: Segala pengembangan halaman baru disarankan mengadopsi standar di atas untuk menjaga estetika premium, bersih, dan interaktif.*
