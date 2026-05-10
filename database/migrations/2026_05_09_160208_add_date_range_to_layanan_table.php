<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateRangeToLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->date('tgl_mulai')->nullable()->after('tanggal_pertemuan');
            $table->date('tgl_selesai')->nullable()->after('tgl_mulai');
        });
    }

    public function down()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->dropColumn(['tgl_mulai', 'tgl_selesai']);
        });
    }
}
