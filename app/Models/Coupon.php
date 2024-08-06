<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupon';

    protected $fillable = [
        'title',
        'code',
        'offtype',
        'min_purc_amount',
        'max_off_amount',
        'imageUrl',
        'expiry_date',
        'status',
    ];

}
