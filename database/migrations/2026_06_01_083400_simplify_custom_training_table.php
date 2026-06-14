<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SimplifyCustomTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Drop request_pelatihan table (and its foreign keys) safely
        if (Schema::hasTable('request_pelatihan')) {
            Schema::table('request_pelatihan', function (Blueprint $table) {
                // Check if columns exist before dropping their foreign keys
                if (Schema::hasColumn('request_pelatihan', 'id_pendaftaran')) {
                    $table->dropForeign(['id_pendaftaran']);
                }
                if (Schema::hasColumn('request_pelatihan', 'id_perusahaan')) {
                    $table->dropForeign(['id_perusahaan']);
                }
            });

            Schema::dropIfExists('request_pelatihan');
        }

        // 2. Add is_kustom and catatan_klien to pendaftaran table
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->boolean('is_kustom')->default(false)->after('id_perusahaan');
            $table->text('catatan_klien')->nullable()->after('is_kustom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Remove columns from pendaftaran
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['is_kustom', 'catatan_klien']);
        });

        // 2. Re-create request_pelatihan
        Schema::create('request_pelatihan', function (Blueprint $table) {
            $table->id('id_request');
            $table->unsignedBigInteger('id_perusahaan')->nullable();
            $table->unsignedBigInteger('id_pendaftaran')->nullable();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telp');
            $table->string('nama_perusahaan');
            $table->string('jabatan')->nullable();
            $table->text('alamat_perusahaan');
            $table->string('sektor_industri')->nullable();
            $table->integer('jumlah_karyawan')->nullable();
            $table->string('topik_pelatihan');
            $table->date('tanggal_harapan')->nullable();
            $table->text('pesan_tambahan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('set null');
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran')->onDelete('set null');
        });
    }
}
