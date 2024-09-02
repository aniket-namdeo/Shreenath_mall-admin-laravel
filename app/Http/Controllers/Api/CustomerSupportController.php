<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSupport;
use Illuminate\Support\Facades\Validator;

class CustomerSupportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'contact' => 'required|integer',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $data = CustomerSupport::create($validated);

        if ($data->id > 0) {
            return response()->json(['status' => true, 'message' => 'Customer Support Request Submitted Successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => "Something Went Wrong", "data" => []], 403);
        }
    }
}
