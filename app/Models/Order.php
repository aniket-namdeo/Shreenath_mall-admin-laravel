<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'delivery_status',
        'payment_method',
        'payment_status',
        'order_date',
        'delivery_date',
        'address_id',
        'coupon_code',
        'discount_amount',
        'tax_amount',
        'shipping_fee',
        'transaction_id',
        'transaction_time',
        'order_rating',
        'order_feedback',
        'otp',
        'handling_charge',
        'used_coin'
    ];

    public function orderItems()
    {
        return $this->hasMany(Order_items::class, 'order_id', 'id');
    }
}
