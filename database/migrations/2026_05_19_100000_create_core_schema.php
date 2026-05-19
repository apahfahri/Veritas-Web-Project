<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ─── 2. KLIEN PERUSAHAAN ────────────────────────────────────────
        // Tambah kolom is_pic, status_mitra, dsb
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->boolean('is_pic')->default(true)->after('jabatan');
            $table->string('status_mitra')->default('aktif')->after('is_pic');
            $table->text('catatan')->nullable()->after('status_mitra');
        });

        // ─── 3. PEMATERI ────────────────────────────────────────────────
        Schema::table('pemateri', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('no_telp');
            $table->text('bio')->nullable()->after('foto');
        });

        // ─── 4. KATEGORI LAYANAN ─────────────────────────────────────────
        // Tambah kode_kategori
        Schema::table('kategori_layanan', function (Blueprint $table) {
            $table->string('kode_kategori', 10)->nullable()->after('nama');
        });

        // ─── 5. JENIS LAYANAN (Master Nama Program) ─────────────────────
        Schema::create('jenis_layanan', function (Blueprint $table) {
            $table->bigIncrements('id_jenis');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama');
            $table->string('kode_jenis', 15)->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori_layanan')
                  ->onDelete('cascade');
        });

        // ─── 6. JADWAL (menggantikan tabel layanan sebelumnya) ───────────
        // 1 baris = 1 sesi/jadwal pelaksanaan dari suatu program jenis layanan
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_jenis');
            $table->string('kode_jadwal', 20)->nullable();  // kode singkatan khusus sesi ini (opsional)
            $table->string('jenis_pertemuan')->default('offline'); // online, offline, hybrid
            $table->date('tanggal_usul')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->time('jam_pertemuan')->nullable();
            $table->string('lokasi')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori_layanan')
                  ->onDelete('cascade');

            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('jenis_layanan')
                  ->onDelete('cascade');
        });

        // ─── 7. JADWAL PEMATERI (Pivot N:N) ─────────────────────────────
        Schema::create('jadwal_pemateri', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_pemateri');
            $table->timestamps();

            $table->primary(['id_jadwal', 'id_pemateri']);
            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwal')
                  ->onDelete('cascade');
            $table->foreign('id_pemateri')
                  ->references('id_pemateri')
                  ->on('pemateri')
                  ->onDelete('cascade');
        });

        // ─── 8. PENDAFTARAN ──────────────────────────────────────────────
        // Hapus kolom lama dari migration awal dan bangun ulang dengan lengkap
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Drop FK dan kolom id_layanan lama (jika ada)
            if (Schema::hasColumn('pendaftaran', 'id_layanan')) {
                $table->dropForeign(['id_layanan']);
                $table->dropColumn('id_layanan');
            }
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('nomor_pendaftaran')->nullable()->unique()->after('id_pendaftaran');
            $table->unsignedBigInteger('id_jadwal')->after('nomor_pendaftaran');
            $table->unsignedBigInteger('id_admin')->nullable()->change();
            $table->boolean('is_utusan_perusahaan')->default(false)->after('id_user');
            $table->unsignedBigInteger('id_perusahaan')->nullable()->after('is_utusan_perusahaan');
            $table->string('mode_pertemuan')->nullable()->after('status_bayar');
            $table->date('rencana_tanggal_mulai')->nullable()->after('mode_pertemuan');
            $table->date('rencana_tanggal_selesai')->nullable()->after('rencana_tanggal_mulai');
            $table->string('bukti_bayar')->nullable()->after('rencana_tanggal_selesai');
            $table->string('cabang')->nullable()->after('bukti_bayar');
            $table->text('last_reminder_details')->nullable()->after('cabang');
            $table->timestamp('last_reminder_sent_at')->nullable()->after('last_reminder_details');

            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwal')
                  ->onDelete('cascade');

            $table->foreign('id_perusahaan')
                  ->references('id_perusahaan')
                  ->on('perusahaan')
                  ->onDelete('set null');
        });

        // ─── 9. REQUEST PELATIHAN ───────────────────────────────────────
        Schema::table('request_pelatihan', function (Blueprint $table) {
            if (!Schema::hasColumn('request_pelatihan', 'id_perusahaan')) {
                $table->unsignedBigInteger('id_perusahaan')->nullable()->after('nama_perusahaan');
                $table->foreign('id_perusahaan')
                      ->references('id_perusahaan')
                      ->on('perusahaan')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemateri');
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('jenis_layanan');
    }
};
