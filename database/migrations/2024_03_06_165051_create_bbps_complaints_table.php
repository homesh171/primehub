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
        Schema::create('bbps_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('agentID')->nullable();
            $table->string('ReferenceID')->nullable();
            $table->text('Disposition')->nullable();
            $table->text('description')->nullable();
            $table->string('complaintID')->nullable();
            $table->string('ComplaintAssigned')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbps_complaints');
    }
};
