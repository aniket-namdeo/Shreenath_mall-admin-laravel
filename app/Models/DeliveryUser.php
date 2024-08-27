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
        'state',
        'city',
        'vehicle_name',
        'vehicle_no',
        'vehicle_type',
        'vehicle_insurance',
        'registration_no',
        'driving_license',
        'pan_doc',
        'aadhar_doc',
        'registration_doc',
        'insurance_doc',
        'license_doc',
        'status',
        'delivery_status',
        'total_cash_collected',
        'total_cash_to_send_back',
        'latitude',
        'longitude',
        'deviceId'
    ];

}
