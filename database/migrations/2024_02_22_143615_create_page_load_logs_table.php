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
        Schema::create('page_load_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
             $table->string('role')->nullable();
              $table->string('ip')->nullable();
                    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_load_logs');
    }
};
