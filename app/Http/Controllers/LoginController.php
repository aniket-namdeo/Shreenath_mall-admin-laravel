<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
   
    public function index(){

        $page_name = "user-login/index";
        
        $page_title = "login";
        
        $current_page = "user-login";

        return view('frontend/pages/main', compact('page_name','page_title','current_page'));
    } 

    public function logindata(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        $user = User::where('email', $request->email)->where('isdeleted',0)->first();
    
        if ($user) {
            if ($user->isdeleted == 1) {
                return back()->with('error', 'User not Exit.');
            }
    
            $usertype = $user->user_type;
            if ($usertype == 'User') {
                session(['user_type' => 'User']);
    
                if (Auth::attempt($credentials)) {
                    return redirect()->route('my-account')->with('success', 'Login Success');
                }
                return back()->with('error', 'Error: Invalid email or password');
            } else {
                return back()->with('error', 'This is not an admin email');
            }
        } else {
            return back()->with('error', 'This email is not registered.');
        }
    }
    

}
