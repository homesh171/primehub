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
        Schema::create('softwareapis', function (Blueprint $table) {
            $table->id();
            $table->integer('apititle')->nullable();
            $table->string('access_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->integer('description')->nullable();
            $table->enum('status', [0, 1])->default('1');
            $table->integer('ip')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('softwareapis');
    }
};
