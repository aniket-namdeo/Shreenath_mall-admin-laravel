<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRating extends Model
{
    use HasFactory;

    protected $table = "delivery_rating";

    protected $fillable = [
        'order_id',
        'delivery_user_id',
        'user_id',
        'rating',
        'status',
    ];
}
