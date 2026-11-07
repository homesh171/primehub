<?php

namespace App\Services;

use App\Models\log;
use App\Models\role;
use App\Models\activity_log;
class LogService
{
    public static function logs($activity,$weburl,$userid,$userRole,$userIp)
    {


        log::create([
            'web_url' => $weburl,
            'activity' => $activity,
            'activity_date_time' => now(),
            'role' => $userRole,
            'ip' => $userIp,
            'user_id' => $userid
        ]);
    }
}