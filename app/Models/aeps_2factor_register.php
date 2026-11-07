<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aeps_2factor_register extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','user_role','accessmodetype','adhaarnumber','mobilenumber','latitude','longitude','referenceno','submerchantid','timestamp','data','ipaddress','status','errorcode','response_code','message'];
}
