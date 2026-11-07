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
        Schema::create('aeps_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('mobilenumber')->nullable();
            $table->string('referenceno')->nullable()->unique();
            $table->string('ipaddress')->nullable();
            $table->string('adhaarnumber')->nullable();
            $table->string('accessmodetype')->default('SITE');
            $table->string('nationalbankidentification')->nullable();
            $table->string('requestremarks')->nullable();
            $table->text('data')->nullable();
            $table->string('pipe')->nullable();
            $table->timestamp('timestamp')->nullable();
            $table->string('transactiontype')->default('BE');
            $table->string('submerchantid')->nullable();
            $table->string('is_iris')->default('No');
            $table->string('user_id')->nullable();
            $table->string('user_role')->nullable();
            $table->string('clientrefno')->nullable();
            $table->string('errorcode')->nullable();
            $table->string('response_code')->nullable();
            $table->string('bankiin')->nullable();
            $table->string('bankrrn')->nullable();
            $table->decimal('balanceamount')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('ackno')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeps_enquiries');
    }
};
