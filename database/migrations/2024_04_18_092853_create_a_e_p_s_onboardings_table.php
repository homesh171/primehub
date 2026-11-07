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
        Schema::create('a_e_p_s_onboardings', function (Blueprint $table) {
            $table->id();
            $table->string('response_code')->nullable();
            $table->text('redirecturl')->nullable();
            $table->string('onboard_pending')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_e_p_s_onboardings');
    }
};
