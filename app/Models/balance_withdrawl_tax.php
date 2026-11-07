<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class balance_withdrawl_tax extends Model
{
    use HasFactory;
     protected $fillable = ['commission','tax','last_price','start_price'];
}
