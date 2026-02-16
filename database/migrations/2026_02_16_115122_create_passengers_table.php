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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->string('distributor')->nullable();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('country_code')->nullable();
            $table->string('contact')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('subpoint')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('passenger_type')->nullable();
            $table->string('tag')->nullable();
            $table->string('user_image')->nullable();
            $table->string('role')->nullable();
            $table->string('otp_key')->nullable();
            $table->boolean('verify')->default(false);
            $table->boolean('status')->default(true);
            $table->string('fcm_token')->nullable();
            $table->boolean('is_first_booking')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
