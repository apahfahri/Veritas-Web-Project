<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('request_pelatihan')) {
            Schema::table('request_pelatihan', function (Blueprint $table) {
                $table->unsignedBigInteger('id_pendaftaran')->nullable()->after('id_perusahaan');
                
                $table->foreign('id_pendaftaran')
                      ->references('id_pendaftaran')
                      ->on('pendaftaran')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('request_pelatihan')) {
            Schema::table('request_pelatihan', function (Blueprint $table) {
                try {
                    $table->dropForeign(['id_pendaftaran']);
                } catch (\Exception $e) {}
                try {
                    $table->dropColumn('id_pendaftaran');
                } catch (\Exception $e) {}
            });
        }
    }
};
