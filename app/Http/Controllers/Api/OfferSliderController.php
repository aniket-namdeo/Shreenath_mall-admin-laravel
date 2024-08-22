<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Models\OfferSlider;
use Illuminate\Http\Request;

class OfferSliderController extends Controller
{

    public function getOfferSlider()
    {

        $data = OfferSlider::where('status', 1)->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Offer Slider data retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }
}
