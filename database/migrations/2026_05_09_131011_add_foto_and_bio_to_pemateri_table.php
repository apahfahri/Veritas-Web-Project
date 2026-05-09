<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoAndBioToPemateriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemateri', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('kompetensi');
            $table->text('bio')->nullable()->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemateri', function (Blueprint $table) {
            $table->dropColumn(['foto', 'bio']);
        });
    }
}
