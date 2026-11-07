<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\page_load_log;
use App\Models\role;
use App\Models\Agent;
use DB;
class LogPageLoad
{
    public function handle(Request $request, Closure $next)
    {
        

        $response = $next($request);


           if ($request->session()->has('SUPERADMIN_EMAIL')) {
            $userId = $request->session()->get('SUPERADMIN_ID');
            $admin = DB::table('ph_super_admins')->where('id', $userId)->first();
            $role = role::where('id', $admin->role)->value('id');
        } else {
            $userId = $request->session()->get('AGENT_ID');
             $agent = $userId ? Agent::where('id', $userId)->first() : null;
              $role = $agent ? role::where('id', $agent->role)->value('id') : null;
        }
        $pageUrl = $request->fullUrl();
        
        $ip = $request->ip();

        // Insert into database
        page_load_log::create([
            'user_id' => $userId,
            'url' => $pageUrl,
            'role' => $role,
            'ip' => $ip
        ]);

        return $response;
    }
}
