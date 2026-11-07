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
        Schema::create('payout_beneficiaries_adds', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('allowed_payment_types')->nullable();
            $table->string('vpa')->nullable();
            $table->string('beneficiary_id')->nullable();
            $table->enum('status', [0, 1])->default('1');
            $table->string('ip')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_beneficiaries_adds');
    }
};
