<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentpayouthistory extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'agent_id',
        'user_id',
        'user_role',
        'order_id',
        'transactionid',
        'acquirer_message',
        'amount',
        'vpa',
        'bank_reference_id',
        'beneficiary',
        'fees',
        'payout_id',
        'account_number',
        'ifsc_code',
        'payment_method',
        'payout_status',
        'payout_charges',
        'payout_totalamount',
        'user_charge_percentage',
        'user_charge_payment',
        'strtotime',
    ];
}
