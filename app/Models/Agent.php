<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Agent extends Model
{
    use HasFactory;
    
  protected $fillable = [
        'username',
        'name',
        'mobile_number',
        'email',
        'password',
        'agent_pin',
        'whatsapp_number',
        'address',
        'country',
        'state',
        'city',
        'pincode',
        'aadhar_number',
        'pan_number',
        'aadhar_front_image',
        'aadhar_back_image',
        'pan_card_image',
        'profile_image',
        'age',
        'shop_name',
        'shop_photo',
        'upi_id',
        'ac_holder_name',
        'ifsc_code',
        'account_number',
        'bank_name'
    ];
    
    
    
    
public static function agentajexview($draw,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,$rowcount){
       
       
$start = $draw;
$query = DB::table('agents')->orderby('id','DESC');


if($searchValue){
$query->where(function ($q) use ($searchValue){
$q->where('agent_id', 'like', '%' . $searchValue . '%')
->orwhere('name', 'like', '%' . $searchValue . '%')
->orwhere('email', 'like', '%' . $searchValue . '%')
->orwhere('mobile_number', 'like', '%' . $searchValue . '%');
    });
};

$sql = $query->toSql();

$bindings = $query->getBindings();

foreach ($bindings as $binding) {
    $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
}

if($rowcount == 1){
$query->limit(10)->offset($start);
return $query->get();
}else{
return $query->count();    
}
        
}
    
    
    
    
    
}



