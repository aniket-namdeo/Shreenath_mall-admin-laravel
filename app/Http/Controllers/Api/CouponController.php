<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function getCoupon()
    {

        $data = Coupon::where('status', 1)->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Coupon data retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }
}
