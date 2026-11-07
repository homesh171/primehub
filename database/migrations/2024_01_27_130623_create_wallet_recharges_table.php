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
        Schema::create('wallet_recharges', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->nullable();
             $table->string('amount')->default('0');
             $table->string('paymentMode')->nullable();
             $table->string('tran_id')->unique()->nullable();
             $table->string('merchant_id')->nullable();
             $table->string('payment_id')->nullable();
             $table->string('providerReferenceId')->nullable();
             $table->text('checksum')->nullable();
             $table->string('status')->nullable();
             $table->string('user_id')->nullable();
             $table->string('roleid')->nullable();
             $table->string('ip')->nullable();
             $table->string('charge')->default('0');
             $table->string('wallet_balance')->default('0');
             $table->string('wallet_load_type')->nullable();
             $table->string('wallet_load_charge')->nullable();
             $table->string('payment_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_recharges');
    }
};
