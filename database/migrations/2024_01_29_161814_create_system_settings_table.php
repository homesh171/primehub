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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('site_title')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('favicon')->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('white_logo')->nullable();
            $table->string('url')->nullable();
            $table->text('copyright_details')->nullable();
            $table->text('address')->nullable();
            $table->text('map_iframe')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('barcode_file')->nullable();
            $table->string('access_token')->nullable();
            $table->string('instance_id')->nullable();
            $table->string('whatsapp_api_url')->nullable();
             $table->enum('payout_server', [0, 1])->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
