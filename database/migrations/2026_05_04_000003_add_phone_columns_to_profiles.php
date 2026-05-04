<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneColumnsToProfiles extends Migration
{
    public function up()
    {
        // Tambah no_hp di klien_perusahaan
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->string('no_hp', 20)->after('jabatan')->nullable();
        });

        // Tambah no_telp di perusahaan
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->string('no_telp', 20)->after('nama')->nullable();
        });
    }

    public function down()
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->dropColumn('no_hp');
        });

        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn('no_telp');
        });
    }
}
