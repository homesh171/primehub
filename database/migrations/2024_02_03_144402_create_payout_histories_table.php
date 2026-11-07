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
        Schema::create('payout_histories', function (Blueprint $table) {
            $table->id();
            $table->string('agent_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('transactionid')->nullable();
            $table->string('acquirer_message')->nullable();
            $table->string('amount')->nullable();
            $table->string('bank_reference_id')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('fees')->nullable();
            $table->string('payout_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payout_status')->nullable();
            $table->string('payout_changes')->nullable();
            $table->string('payout_totalamount')->nullable();
            $table->string('strtotime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_histories');
    }
};
