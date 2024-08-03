<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{

    public function getAboutUs()
    {

        $data = AboutUs::where(array('status' => 1))->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'About us data retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }
}
