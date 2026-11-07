<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class wallet_log extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        
        'payment_status',	
        'role_id',	
        'user_id',	
        'services_id',	
        'message',
        'ip',
        'amount'
        
        ];
        
        
         public static function viewalltxn($request,$draw,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,$rowcount){
       
       
         $start = $draw;

  $query = DB::table('wallet_logs')
                ->join('services', 'wallet_logs.services_id', '=', 'services.id')
                ->leftJoin('agents', 'wallet_logs.user_id', '=', 'agents.id')
                ->join('roles', 'wallet_logs.role_id', '=', 'roles.id')
                ->leftJoin('ph_super_admins', 'wallet_logs.user_id', '=', 'ph_super_admins.id')
                ->select('wallet_logs.*','wallet_logs.role_id as wallet_logsRoleId', 'wallet_logs.user_id as wallet_logsUserId','wallet_logs.created_at as wallet_logscreated_at','services.*', 'agents.name', 'agents.agent_id as Agent_id','roles.id as roleID','roles.role as rolename');
                


    if ($request->session()->has('AGENT_EMAIL')) {
        $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
        $query->where('user_id', $user->id)->where('role_id', $user->role);
    } elseif ($request->session()->has('SUPERADMIN_EMAIL')) {
        $query;
    }

    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('Agent_id', 'like', '%' . $searchValue . '%')
              ->orWhere('agents.name', 'like', '%' . $searchValue . '%')
              ->orWhere('wallet_logs.amount', 'like', '%' . $searchValue . '%');
        });
    }


    $sql = $query->toSql();

    $bindings = $query->getBindings();

    foreach ($bindings as $binding) {
        $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
    }

    if ($rowcount == 1) {
        $query->orderBy('wallet_logs.id', 'desc')->limit(10)->offset($start);
        return $query->get();
    } else {
        return $query->count();
    }

        
}
        
        
        
}
