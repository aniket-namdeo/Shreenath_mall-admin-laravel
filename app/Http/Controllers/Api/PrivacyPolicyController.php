<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{

    public function getPrivacyPolicy()
    {

        $data = PrivacyPolicy::where('status', 1)->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Privacy policy data retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }
}
