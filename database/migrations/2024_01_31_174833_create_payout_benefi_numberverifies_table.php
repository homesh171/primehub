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
        Schema::create('payout_benefi_numberverifies', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('otp')->nullable();
            $table->enum('status', [0, 1])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_benefi_numberverifies');
    }
};
