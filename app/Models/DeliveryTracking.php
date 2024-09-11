<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    use HasFactory;

    protected $table = 'delivery_tracking';
   
    protected $fillable = [
        'order_id',
        'delivery_user_id',
        'pickup_feedback',
        'order_status',
        'deliver_feedback',
        'assigned_at',
        'rejected_at',
        'status'
    ];
}
