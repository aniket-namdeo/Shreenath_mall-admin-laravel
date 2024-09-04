<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $table = "product_rating";

    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'rating',
        'description',
        'images',
    ];
}
