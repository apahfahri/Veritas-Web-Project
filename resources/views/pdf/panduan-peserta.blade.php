<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panduan Data Peserta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 30px;
        }
        h1 {
            color: #1E6B3D;
            text-align: center;
            border-bottom: 2px solid #1E6B3D;
            padding-bottom: 10px;
        }
        h2 {
            color: #1E6B3D;
            margin-top: 30px;
            font-size: 18px;
        }
        p {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        .step {
            margin-bottom: 20px;
        }
        .step-number {
            font-weight: bold;
            color: #1E6B3D;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <h1>Panduan Penyiapan Data Peserta B2B</h1>
    <p>Terima kasih telah mempercayakan pelatihan perusahaan Anda kepada kami. Untuk memperlancar proses pendaftaran, penerbitan sertifikat, dan pengiriman tautan kelas, kami membutuhkan data peserta dengan format yang sesuai.</p>

    <h2>1. Data yang Dibutuhkan</h2>
    <p>Silakan siapkan data peserta menggunakan Microsoft Excel (atau aplikasi spreadsheet lainnya). Anda **wajib** membuat 3 (tiga) kolom utama berikut di baris paling pertama (sebagai Header):</p>
    
    <table>
        <thead>
            <tr>
                <th>Nama Kolom (Header)</th>
                <th>Keterangan & Aturan Pengisian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Nama</strong></td>
                <td>Nama lengkap peserta beserta gelar (jika ada). Nama ini akan dicetak persis pada Sertifikat Pelatihan.</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>Alamat email aktif peserta. Tautan undangan kelas, materi, dan notifikasi pelatihan akan dikirimkan ke email ini.</td>
            </tr>
            <tr>
                <td><strong>WhatsApp</strong></td>
                <td>Nomor handphone / WhatsApp aktif. Format bebas (boleh menggunakan 08x atau 628x).</td>
            </tr>
        </tbody>
    </table>

    <h2>2. Contoh Pengisian di Excel</h2>
    <p>Baris pertama pada Excel Anda harus berisi judul kolom. Baris kedua dan seterusnya adalah data peserta.</p>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>WhatsApp</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Budi Santoso, S.T.</td>
                <td>budi.s@perusahaan.com</td>
                <td>081234567890</td>
            </tr>
            <tr>
                <td>Andi Pratama</td>
                <td>andi.p@perusahaan.com</td>
                <td>089876543210</td>
            </tr>
            <tr>
                <td>Siti Aminah, M.K.K.K.</td>
                <td>siti.a@perusahaan.com</td>
                <td>081112223334</td>
            </tr>
        </tbody>
    </table>

    <h2>3. Cara Menyimpan (Export) ke Format CSV</h2>
    <p>Sistem kami hanya menerima file dengan ekstensi <strong>.csv</strong>. Ikuti langkah berikut untuk menyimpan file Excel Anda menjadi CSV:</p>
    <div class="step">
        <span class="step-number">Langkah 1:</span> Buka file data peserta yang telah Anda siapkan di aplikasi Microsoft Excel.
    </div>
    <div class="step">
        <span class="step-number">Langkah 2:</span> Klik menu <strong>File</strong> di pojok kiri atas, kemudian pilih <strong>Save As</strong> (Simpan Sebagai).
    </div>
    <div class="step">
        <span class="step-number">Langkah 3:</span> Pilih lokasi folder tempat Anda ingin menyimpan file tersebut.
    </div>
    <div class="step">
        <span class="step-number">Langkah 4:</span> Pada kolom <strong>Save as type</strong> (Simpan sebagai tipe), klik *dropdown* dan cari opsi: <br>
        <strong>CSV (Comma delimited) (*.csv)</strong> atau <strong>CSV UTF-8 (Comma delimited) (*.csv)</strong>.
    </div>
    <div class="step">
        <span class="step-number">Langkah 5:</span> Klik tombol <strong>Save</strong>. Jika muncul peringatan fitur yang mungkin hilang, klik Yes/OK.
    </div>
    
    <h2>4. Mengunggah Data ke Sistem</h2>
    <p>Setelah file <strong>.csv</strong> berhasil dibuat, silakan kembali ke halaman <strong>Cek Status</strong> pada portal kami, kemudian klik tombol <strong>Unggah Peserta</strong>. Pilih file CSV yang baru saja Anda buat dan tekan Simpan.</p>

    <div class="footer">
        &copy; {{ date('Y') }} PT Katiga Veritas Solusindo. Dokumen ini dibuat otomatis oleh sistem.
    </div>

</body>
</html>
