<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billinfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'billerId',
        'billerName',
        'billerCategory',
        'billerAdhoc',
        'billerCoverage',
        'billerFetchRequirement',
        'billerPaymentExactness',
        'billerSupportBillValidation',
        'paramName',
        'dataType',
        'isOptional',
        'minLength',
        'maxLength',
        'regEx',
        'parameters',
        'encrypted_response',
        'billerDescription',
        'billerPaymentModes'
    ];
}
