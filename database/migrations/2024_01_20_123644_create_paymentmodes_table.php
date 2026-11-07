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
        Schema::create('paymentmodes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('salt_key')->unique();
            $table->string('script_key')->unique();
            $table->string('ip')->nullable();
            $table->enum('status', [0, 1])->default('0');
            $table->enum('payment_mode', [0, 1])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentmodes');
    }
};
