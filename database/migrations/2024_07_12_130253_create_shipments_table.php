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
        Schema::create('shipments', function (Blueprint $table) {
             $table->id();
            $table->string('refid');
            $table->string('origin_code');
            $table->string('product_code');
            $table->string('destination_code');
            $table->date('booking_date');
            $table->time('booking_time')->nullable();
            $table->integer('pcs');
            $table->decimal('shipment_value', 10, 2)->nullable();
            $table->string('shipment_value_currency');
            $table->decimal('actual_weight', 10, 2);
            $table->string('shipment_invoice_no');
            $table->date('shipment_invoice_date');
            $table->string('shipment_content');
            $table->string('remark')->nullable();
            $table->boolean('new_docket_free_form_invoice');
            $table->string('free_form_currency');
            $table->string('terms_of_trade');
            $table->string('api_service_code');
            $table->string('api_vendor_code')->nullable();
            
            // Shipper details
            $table->string('shipper_name');
            $table->string('shipper_company_name');
            $table->string('shipper_contact_no');
            $table->string('shipper_email');
            $table->string('shipper_address_line_1');
            $table->string('shipper_address_line_2')->nullable();
            $table->string('shipper_address_line_3')->nullable();
            $table->string('shipper_city');
            $table->string('shipper_state');
            $table->string('shipper_country');
            $table->string('shipper_zip_code');
            $table->string('shipper_gstin_type')->nullable();
            $table->string('shipper_gstin_no')->nullable();

            // Consignee details
            $table->string('consignee_name');
            $table->string('consignee_company_name');
            $table->string('consignee_contact_no');
            $table->string('consignee_email');
            $table->string('consignee_address_line_1');
            $table->string('consignee_address_line_2')->nullable();
            $table->string('consignee_address_line_3')->nullable();
            $table->string('consignee_city');
            $table->string('consignee_state');
            $table->string('consignee_country');
            $table->string('consignee_zip_code');
            $table->string('consignee_gstin_type')->nullable();
            $table->string('consignee_gstin_no')->nullable();

            // Pickup address details
            $table->string('pickup_address_name');
            $table->string('pickup_address_code');
            $table->string('pickup_address_contact_no');
            $table->string('pickup_address_email');
            $table->string('pickup_address_address_line_1');
            $table->string('pickup_address_address_line_2')->nullable();
            $table->string('pickup_address_address_line_3')->nullable();
            $table->string('pickup_address_city');
            $table->string('pickup_address_state');
            $table->string('pickup_address_country');
            $table->string('pickup_address_zip_code');
            $table->string('pickup_address_gstin_type')->nullable();
            $table->string('pickup_address_gstin_no')->nullable();

            // Other details
            $table->string('pickup_request');
            $table->json('docket_items');
            $table->json('free_form_line_items');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
