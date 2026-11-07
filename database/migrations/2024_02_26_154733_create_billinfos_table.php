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
        Schema::create('billinfos', function (Blueprint $table) {
            $table->id();
            $table->string('billerId')->nullable();
            $table->string('billerName')->nullable();
            $table->string('billerCategory')->nullable();
            $table->string('billerAdhoc')->nullable();
            $table->string('billerCoverage')->nullable();
            $table->string('billerFetchRequiremet')->nullable();
            $table->string('billerPaymentExactness')->nullable();
            $table->string('billerSupportBillValidation')->nullable();
            $table->string('paramName')->nullable();
            $table->string('dataType')->nullable();
            $table->string('isOptional')->nullable();
            $table->string('minLength')->nullable();
            $table->string('maxLength')->nullable();
            $table->string('regEx')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billinfos');
    }
};
