<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TxnMerchantAuthenticity extends Model
{
    use HasFactory;
    
    protected $fillable = ['status', 'user_id', 'user_role', 'message', 'MerAuthTxnId'];

}
