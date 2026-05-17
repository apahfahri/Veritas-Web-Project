<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPerusahaanToRequestPelatihan extends Migration
{
    public function up()
    {
        Schema::table('request_pelatihan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_perusahaan')->nullable()->after('id_request');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('request_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_perusahaan']);
            $table->dropColumn('id_perusahaan');
        });
    }
}
