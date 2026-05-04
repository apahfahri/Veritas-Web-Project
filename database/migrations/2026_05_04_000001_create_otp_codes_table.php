<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpCodesTable extends Migration
{
    public function up()
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('otp', 6);
            $table->enum('type', ['register', 'forgot_password']);
            $table->timestamp('expired_at');
            $table->timestamps();

            $table->index(['email', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_codes');
    }
}
