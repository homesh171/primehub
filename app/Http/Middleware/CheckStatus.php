<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use App\Models\Agent;

class CheckStatus
{

    public function handle(Request $request, Closure $next): Response
    {
        
        
                if ($request->session()->get('AGENT_EMAIL')){

     $user  = Agent::where('email',$request->session()->get('AGENT_EMAIL'))->first();
     if($user->kyc_status=='1'){
         
            Session::flush();
        return redirect('agent/login')->with('error', 'Your account has been deactivated. Please contact the administrator.');
     }

                
        }
        return $next($request);
    }
}
