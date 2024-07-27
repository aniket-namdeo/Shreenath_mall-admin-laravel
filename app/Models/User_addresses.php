<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_addresses extends Model
{
    use HasFactory;

    protected $table = "user_addresses";

    protected $fillable = [
        'user_id',
        'house_address',
        'street_address',
        'landmark',
        'city',
        'state',
        'country',
        'pincode',
        'default_address',
    ];
}
