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
        Schema::create('bbps_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('responseCode');
            $table->string('responseReason');
            $table->string('txnRefId');
            $table->string('approvalRefNumber');
            $table->string('txnRespType');
            $table->string('paramName');
            $table->string('paramValue');
            $table->string('CustConvFee');
            $table->decimal('RespAmount', 10, 2);
            $table->string('RespCustomerName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbps_transactions');
    }
};
