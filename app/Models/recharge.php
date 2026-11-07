<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class recharge extends Model
{
    use HasFactory;
    
      protected $fillable = [
        'status',
        'response_code',
        'operatorid',
        'ackno',
        'refid',
        'message',
         'user_role',
         'user_role',
         'user_id',
         'amount',
         'mobile'
    ];
    
       public static function viewmobilerechargeHistory($request, $draw, $searchValue, $columnSortOrder, $columnName, $columnIndex, $filltersearchValue, $rowcount) {
    $start = $draw;

    $query = DB::table('recharges');

    if ($request->session()->has('AGENT_EMAIL')) {
        $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
        $query->where('user_id', $user->id)->where('user_role', $user->role);
    } elseif ($request->session()->has('SUPERADMIN_EMAIL')) {
     $query;
   
    }

    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('refid', 'like', '%' . $searchValue . '%')
              ->orWhere('amount', 'like', '%' . $searchValue . '%')
              ->orWhere('mobile', 'like', '%' . $searchValue . '%')
              ->orWhere('created_at', 'like', '%' . $searchValue . '%');
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
