<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRencanaTanggalToRangeOnPendaftaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('rencana_tanggal');
            $table->date('rencana_tanggal_mulai')->nullable()->after('tanggal_daftar');
            $table->date('rencana_tanggal_selesai')->nullable()->after('rencana_tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['rencana_tanggal_mulai', 'rencana_tanggal_selesai']);
            $table->date('rencana_tanggal')->nullable()->after('tanggal_daftar');
        });
    }
}
