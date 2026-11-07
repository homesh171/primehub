<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentpermissions extends Model
{
    use HasFactory;
    
        protected $fillable = ['role','user_id','ip','default_payout_changes','payout_limit','wallet_load_charge','payout_type','wallet_load_type','wallet_status'];
}
