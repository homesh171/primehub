<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministatement extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'user_id', 'user_role', 'bankiin', 'ackno', 'date', 'txnType', 'amount', 'narration','MiniStatement_id'
    ];
}
