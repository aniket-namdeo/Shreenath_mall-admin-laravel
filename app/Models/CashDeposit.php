<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDeposit extends Model
{
    use HasFactory;
    protected $table = 'cash_deposit';
    protected $fillable = [
        'delivery_user_id',
        'order_id',
        'cash_amount',
        'deposit_amount',
        'deposit_date',
        'otp',
        'isVerified',
        'status',
    ];
}
