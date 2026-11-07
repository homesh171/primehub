<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otp_log extends Model
{
    use HasFactory;
    
    
     protected $fillable = [
        'otp',
        'ip',
        'login_time',
        'mobile_number',
        'role'
    ];

}
