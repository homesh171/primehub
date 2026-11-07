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
        Schema::create('billfatch_data', function (Blueprint $table) {
            $table->id();
            $table->string('billNumber')->nullable;
            $table->string('token')->nullable;
            $table->string('billerID')->nullable;
            $table->string('ip')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billfatch_data');
    }
};
