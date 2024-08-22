<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSlider extends Model
{
    use HasFactory;

    protected $table = 'offer_slider';

    protected $fillable = [
        'subCategoryId',
        'banner',
        'status',
    ];
}
