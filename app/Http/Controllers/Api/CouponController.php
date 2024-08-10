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

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'purchase_amount' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', $validated['code'])->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'error' => 'Coupon not found'], 404);
        }

        $expiryDate = new \DateTime($coupon->expiry_date);
        $now = new \DateTime();

        if ($now > $expiryDate) {
            return response()->json(['success' => false, 'error' => 'Coupon has expired'], 400);
        }

        if ($validated['purchase_amount'] < $coupon->min_purc_amount) {
            return response()->json(['success' => false, 'error' => 'Purchase amount is less than the minimum required'], 400);
        }

        $discount = $this->calculateDiscount($coupon, $validated['purchase_amount']);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'data' => $discount,
        ]);
    }

    private function calculateDiscount($coupon, $purchaseAmount)
    {
        if ($coupon->offtype === 'percentage') {
            return min($purchaseAmount * ($coupon->max_off_amount / 100), $coupon->max_off_amount);
        }

        return min($coupon->max_off_amount, $purchaseAmount);
    }
}