<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileAndPenerbitToSertifikatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->string('file_pdf')->nullable()->after('tanggal_terbit');
            $table->string('penerbit')->nullable()->after('file_pdf');
        });
    }

    public function down()
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropColumn(['file_pdf', 'penerbit']);
        });
    }
}
