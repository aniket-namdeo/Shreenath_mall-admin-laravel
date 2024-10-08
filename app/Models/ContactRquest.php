<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRquest extends Model
{
    use HasFactory;
    protected $table = "customer_support";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'contact',
        'email',
        'subject',
        'message',
        'contact_status',
        'remark',
        'status',
    ];
}
