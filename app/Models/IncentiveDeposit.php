<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncentiveDeposit extends Model
{
    use HasFactory;

    protected $table = 'incentive_deposit';

    protected $fillable = [
        'delivery_user_id',
        'amount',
        'status',
    ];
}
