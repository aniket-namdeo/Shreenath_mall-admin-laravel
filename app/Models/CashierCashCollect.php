<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierCashCollect extends Model
{
    use HasFactory;

    protected $table = "cashier_cash_collect";

    protected $primaryKey = "id";

    protected $fillable = [
        'cashier_id', 'delivery_user_id', 'collected_amount', 'collected_status', 'status'
    ];
}
