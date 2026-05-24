<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuotaMinimalAndStatusToJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->integer('kuota_minimal')->default(0)->after('kapasitas');
            $table->boolean('is_active')->default(true)->after('kuota_minimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['kuota_minimal', 'is_active']);
        });
    }
}
