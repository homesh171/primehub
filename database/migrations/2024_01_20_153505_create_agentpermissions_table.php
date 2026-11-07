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
        Schema::create('agentpermissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('role')->nullable();
            $table->integer('wallet_limit')->default('10000');
            $table->integer('payout_limit')->default('10000');
            $table->integer('default_payout_changes')->default('10');
            $table->string('ip')->nullable();
            $table->enum('wallet_status', [0, 1])->default('1');
            $table->enum('wallet_load_type ', [0, 1])->default('0');
            $table->string('wallet_load_charge')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agentpermissions');
    }
};
