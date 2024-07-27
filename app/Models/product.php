<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'mrp',
        'discount_percent',
        'category_id',
        'sku',
        'stock',
        'brand',
        'image_url1',
        'image_url2',
        'image_url3',
        'image_url4',
        'product_code',
        'pack_size',
        'status',
    ];

     public function getFormattedPriceAttribute()
     {
         return number_format($this->price, 2);
     }
 
     public function getFormattedMrpAttribute()
     {
         return number_format($this->mrp, 2);
     }

}
