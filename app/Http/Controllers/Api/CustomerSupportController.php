<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSupport;
use Illuminate\Support\Facades\Validator;

class CustomerSupportController extends Controller
{
   protected $rules;

   public function __construct(){
        $this->rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'contact' => 'required|integer|min:10|max:10',
            'subject' => 'required',
            'message' => 'required',
        ];
    }

    public function index(){ }

   public function store(Request $request){
        
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        } else{

            $data = CustomerSupport::create($validator);

            if($data->id > 0){
                return response()->json(['status' => true, 'message' => 'Customer Support Request Submitted Successfully'], 200);
            }else{
                return response()->json(['status' => false, 'message' => "Something Went Wrong", "data" => []], 403);
            }
        }
   }
}
