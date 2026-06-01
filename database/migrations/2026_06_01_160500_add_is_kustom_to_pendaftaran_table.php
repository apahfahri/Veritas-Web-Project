<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('pendaftaran')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                if (!Schema::hasColumn('pendaftaran', 'is_kustom')) {
                    $table->boolean('is_kustom')->default(false)->after('id_user');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pendaftaran')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                if (Schema::hasColumn('pendaftaran', 'is_kustom')) {
                    $table->dropColumn('is_kustom');
                }
            });
        }
    }
};
