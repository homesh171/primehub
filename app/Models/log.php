<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        
        'ip',
        'user_id',
        'web_url',
        'role',
        'activity',
        'activity_date_time'
        
        ];
}
