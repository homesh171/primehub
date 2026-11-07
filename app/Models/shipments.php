<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipments extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'refid',
        'origin_code',
        'product_code',
        'destination_code',
        'booking_date',
        'booking_time',
        'pcs',
        'shipment_value',
        'shipment_value_currency',
        'actual_weight',
        'shipment_invoice_no',
        'shipment_invoice_date',
        'shipment_content',
        'remark',
        'new_docket_free_form_invoice',
        'free_form_currency',
        'terms_of_trade',
        'api_service_code',
        'api_vendor_code',
        'shipper_name',
        'shipper_company_name',
        'shipper_contact_no',
        'shipper_email',
        'shipper_address_line_1',
        'shipper_address_line_2',
        'shipper_address_line_3',
        'shipper_city',
        'shipper_state',
        'shipper_country',
        'shipper_zip_code',
        'shipper_gstin_type',
        'shipper_gstin_no',
        'consignee_name',
        'consignee_company_name',
        'consignee_contact_no',
        'consignee_email',
        'consignee_address_line_1',
        'consignee_address_line_2',
        'consignee_address_line_3',
        'consignee_city',
        'consignee_state',
        'consignee_country',
        'consignee_zip_code',
        'consignee_gstin_type',
        'consignee_gstin_no',
        'pickup_address_name',
        'pickup_address_code',
        'pickup_address_contact_no',
        'pickup_address_email',
        'pickup_address_address_line_1',
        'pickup_address_address_line_2',
        'pickup_address_address_line_3',
        'pickup_address_city',
        'pickup_address_state',
        'pickup_address_country',
        'pickup_address_zip_code',
        'pickup_address_gstin_type',
        'pickup_address_gstin_no',
        'pickup_request',
        'docket_items',
        'free_form_line_items',
    ];

    protected $casts = [
        'docket_items' => 'array',
        'free_form_line_items' => 'array',
    ];
}
