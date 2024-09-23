<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorCashier extends Model
{
    use HasFactory;

    protected $table = "contractor_cashier";

    protected $primaryKey = "id";

    protected $fillable = [
        "name", "email", "contact", "password", "user_type", "commission_type", "commission", "aadhar_card", 'aadhar_image', 'pancard', 'pan_image', 'account_number', 'account_type', 'bank_name', 'bank_ifsc'
    ];
}
