<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payout_charges extends Model
{
    use HasFactory;
        protected $fillable = ['agent_id','charges_amount','last_price','start_price'];
}
