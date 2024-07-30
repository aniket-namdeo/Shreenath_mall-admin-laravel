<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryUser extends Model
{
    use HasFactory;

    protected $table = 'deliveryUser';
   
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'contact',
        'email',
        'dob',
        'password',
        'gender',
        'profile_image',
        'is_blocked',
        'status',
    ];

}
