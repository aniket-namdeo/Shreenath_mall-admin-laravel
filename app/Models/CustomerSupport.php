<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;

    protected $table = "customer_support";

    protected $primaryKey = "id";

    protected $fillable = [
        "name",
        "email",
        "contact",
        "subject",
        "message",
        "status"
    ];
}
