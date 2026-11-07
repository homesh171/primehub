<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Request;
class wallet_recharge extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
   'order_id',
    'amount',
    'paymentMode',
    'tran_id',
    'merchant_id',
    'status',
    'user_id',
    'roleid',
    'ip',
    'charge',
    'wallet_balance',
    'payment_id',
    'providerReferenceId',
    'checksum',
    'wallet_load_charge',
    'wallet_load_type',
    'payment_request_id',
    'payment_screenshot',
    'payment_mode',
    'payment_request_status'
    ];
    
    
    
    public static function agentajexview($request,$draw,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,$rowcount){
       
       
 $start = $draw;

    $query = DB::table('wallet_recharges');

    if ($request->session()->has('AGENT_EMAIL')) {
        $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
      
                     $query->where('user_id', $user->id)->where('roleid', $user->role)->where('payment_request_id', '!=' ,null);   
                   
    } elseif ($request->session()->has('SUPERADMIN_EMAIL')) {
       
             $query->where('payment_request_id', '!=' ,null);
         
    }


    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('order_id', 'like', '%' . $searchValue . '%')
              ->orWhere('tran_id', 'like', '%' . $searchValue . '%')
              ->orWhere('amount', 'like', '%' . $searchValue . '%');
        });
    }


    $sql = $query->toSql();

    $bindings = $query->getBindings();

    foreach ($bindings as $binding) {
        $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
    }

    if ($rowcount == 1) {
        $query->orderBy('id', 'desc')->limit(10)->offset($start);
        return $query->get();
    } else {
        return $query->count();
    }




        
}
    
    
}
