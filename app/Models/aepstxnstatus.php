<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aepstxnstatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'user_role',
        'status',
        'txnstatus',
        'message',
        'ackno',
        'bankrrn',
        'amount',
        'response_code',
        'reference_number'
    ];
}
