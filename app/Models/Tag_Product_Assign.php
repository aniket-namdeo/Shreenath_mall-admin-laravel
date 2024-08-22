<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag_Product_Assign extends Model
{
    use HasFactory;

    protected $table = 'tag_product_assign';

    protected $fillable = [
        'tagId',
        'productId',
    ];
}
