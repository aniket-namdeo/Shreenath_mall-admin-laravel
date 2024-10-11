<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class MyaccountController extends Controller
{
    public function index(){

        $page_name = "my-account/index";
        
        $page_title = "login";
        
        $current_page = "my-account";

        $user = Auth::user(); 

        $userId = $user ? $user->id : null; 

        return view('frontend/pages/main', compact('page_name','page_title','current_page','user','userId'));
    } 

   
    public function destroy($id)
    {
        $data = ['isdeleted' => 0];
    
        $result = User::where('id', $id)->update($data);
    
        if ($result > 0) {
          
            return redirect()->route('default_home')->with('success', 'User Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    
    
    
    
}
