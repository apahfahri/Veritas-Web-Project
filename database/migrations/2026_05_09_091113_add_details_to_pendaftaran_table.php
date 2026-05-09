<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToPendaftaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->date('rencana_tanggal')->nullable()->after('tanggal_daftar');
            $table->string('mode_pertemuan')->nullable()->after('rencana_tanggal'); // online / offline
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
            $table->dropColumn(['rencana_tanggal', 'mode_pertemuan']);
        });
    }
}
