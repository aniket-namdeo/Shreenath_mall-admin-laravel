<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryUser extends Model
{
    use HasFactory;

    protected $table = 'delivery_user';
   
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
        'aadhar_card',
        'pan_no',
        'address',
        'vehicle_name',
        'vehicle_no',
        'vehicle_type',
        'vehicle_insurance',
        'registration_no',
        'driving_license',
        'status',
    ];

}
