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
        Schema::create('aeps_2factor_registers', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('user_role')->nullable();
            $table->string('accessmodetype')->nullable();
            $table->string('adhaarnumber')->nullable();
            $table->string('mobilenumber')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('referenceno')->nullable();
            $table->string('submerchantid')->nullable();
            $table->timestamp('timestamp')->nullable();
            $table->text('data')->nullable();
            $table->ipAddress('ipaddress')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeps_2factor_registers');
    }
};
