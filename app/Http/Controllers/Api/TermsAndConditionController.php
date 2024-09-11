<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{

    public function getTermsAndCondition()
    {

        $data = TermsAndCondition::where('status', 1)->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Terms and condition data retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }
}
