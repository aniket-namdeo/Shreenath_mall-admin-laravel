<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierOrders extends Model
{
    use HasFactory;

    protected $table = "cashier_orders";

    protected $primaryKey = "id";

    protected $fillable = [
        'cashier_id', 'delivery_user_id', 'order_id', 'pickup_status', 'status'
    ];
}
