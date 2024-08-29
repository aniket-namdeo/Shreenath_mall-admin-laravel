<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTrackingOrder extends Model
{
    use HasFactory;

    protected $table = 'delivery_tracking_order';
   
    protected $fillable = [
        'delivery_tracking_id',
        'order_id',
        'delivery_user_id',
        'latitude',
        'longitude',
        'status',
        'delivery_status'
    ];
}
