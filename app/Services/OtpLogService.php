<?php

namespace App\Services;

use App\Models\otp_log;
use App\Models\role;

class OtpLogService
{
    public static function logLogin($userMobile, $otp,$userRole,$userIp)
    {
        
        otp_log::create([
            'mobile_number' => $userMobile,
            'otp' => $otp,
            'login_time' => now(),
            'role' => $userRole,
            'ip' => $userIp,
        ]);
    }
}
