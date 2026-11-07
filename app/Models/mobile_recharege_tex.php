<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mobile_recharege_tex extends Model
{
    use HasFactory;
    
    protected $fillable = ['commission','tax'];
}
