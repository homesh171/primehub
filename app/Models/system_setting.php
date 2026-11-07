<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class system_setting extends Model
{
    use HasFactory;
    
      protected $fillable = [
        'site_title',
        'email',
        'telephone',
        'mobile_number',
        'whatsapp_number',
        'favicon',
        'dark_logo',
        'white_logo',
        'url',
        'copyright_details',
        'address',
        'map_iframe',
        'meta_keywords',
        'meta_description',
        'short_description',
        'bank_name',
        'ifsc_code',
        'account_number',
        'account_holder_name',
        'upi_id',
        'barcode_file',
        'access_token',
        'instance_id',
        'whatsapp_api_url',
    ];

}
