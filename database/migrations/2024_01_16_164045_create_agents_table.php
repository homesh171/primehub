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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('agent_id')->unique();
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('mobile_number')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('agent_pin')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->longtext('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('aadhar_front_image')->nullable();
            $table->string('aadhar_back_image')->nullable();
            $table->string('pan_card_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('email_verify', [0, 1])->default('0');
            $table->enum('otp_verify', [0, 1])->default('0');
            $table->string('age')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_photo')->nullable();
            $table->enum('kyc_status', [0, 1])->default('0');
            $table->string('role');
            $table->string('otp');
            $table->string('exptime');
            $table->integer('wallet')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
