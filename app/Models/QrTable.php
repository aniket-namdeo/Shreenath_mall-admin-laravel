<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrTable extends Model
{
    use HasFactory;

    protected $table = 'qr';

    protected $fillable = [
        'delivery_user_id',
        'qr_code',
        'status',
    ];
}
