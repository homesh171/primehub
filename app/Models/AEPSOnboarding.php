<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AEPSOnboarding extends Model
{
    use HasFactory;
      protected $fillable = [
          
          'message',
          'onboard_pending',
          'redirecturl',
          'response_code',
          'status',
          'user_id',
          'email',
          'phone_number',
          'user_role',
          'onboarding_status',
          'merchantcode',
          'createtime'
          ];
}


