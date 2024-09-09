<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Queue extends Model
{
    use HasFactory;

    protected $table = "order_queue";

    protected $fillable = [
        'order_id',
        'status'
    ];
}
