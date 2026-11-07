<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class bbps_transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'responseCode',
        'responseReason',
        'txnRefId',
        'approvalRefNumber',
        'txnRespType',
        'paramName',
        'paramValue',
        'CustConvFee',
        'RespAmount',
        'RespCustomerName',
        'agent_id'
    ];
    
    
public static function billhistory($request, $draw, $searchValue, $columnSortOrder, $columnName, $columnIndex, $filltersearchValue, $rowcount) {
    $start = $draw;

    $query = DB::table('bbps_transactions');

    if ($request->session()->has('AGENT_EMAIL')) {
        $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
        $query->where('agent_id', $user->id)->where('role', $user->role);
    } elseif ($request->session()->has('SUPERADMIN_EMAIL')) {
     $query->join('agents', 'bbps_transactions.agent_id', '=', 'agents.id');
   
    }

    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('txnRefId', 'like', '%' . $searchValue . '%')
              ->orWhere('RespCustomerName', 'like', '%' . $searchValue . '%')
              ->orWhere('RespAmount', 'like', '%' . $searchValue . '%');
        });
    }


    $sql = $query->toSql();

    $bindings = $query->getBindings();

    foreach ($bindings as $binding) {
        $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
    }

    if ($rowcount == 1) {
        $query->orderBy('bbps_transactions.id', 'desc')->limit(10)->offset($start);
        return $query->get();
    } else {
        return $query->count();
    }
}



    
}
