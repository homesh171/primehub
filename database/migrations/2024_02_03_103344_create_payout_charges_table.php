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
        Schema::create('payout_charges', function (Blueprint $table) {
            $table->id();
            $table->string('start_price')->nullable();
            $table->string('last_price')->nullable();
            $table->string('charges_amount')->nullable();
            $table->string('agent_id')->nullable();
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
        Schema::dropIfExists('payout_charges');
    }
};
