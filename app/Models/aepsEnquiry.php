<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class aepsEnquiry extends Model
{
    
    use HasFactory;
     protected $fillable = [
        'latitude',
        'longitude',
        'mobilenumber',
        'referenceno',
        'ipaddress',
        'adhaarnumber',
        'accessmodetype',
        'nationalbankidentification',
        'requestremarks',
        'data',
        'pipe',
        'timestamp',
        'transactiontype',
        'submerchantid',
        'is_iris',
        'user_id',
        'user_role',
        'clientrefno',
        'errorcode',
        'response_code',
        'bankiin',
        'bankrrn',
        'balanceamount',
        'amount',
        'ackno',
        'message',
        'status',
        ];
        
               
        public static function viewblanceenqueryhistory($request, $draw, $searchValue, $columnSortOrder, $columnName, $columnIndex, $filltersearchValue, $rowcount) {
    $start = $draw;

    $query = DB::table('aeps_enquiries');

    if ($request->session()->has('AGENT_EMAIL')) {
        $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
        $query->where('user_id', $user->id)->where('user_role', $user->role);
    } elseif ($request->session()->has('SUPERADMIN_EMAIL')) {
     $query;
   
    }

    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('referenceno', 'like', '%' . $searchValue . '%')
              ->orWhere('adhaarnumber', 'like', '%' . $searchValue . '%')
              ->orWhere('created_at', 'like', '%' . $searchValue . '%')
              ->orWhere('submerchantid', 'like', '%' . $searchValue . '%');
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
