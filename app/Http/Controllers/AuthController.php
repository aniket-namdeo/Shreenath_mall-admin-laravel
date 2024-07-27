<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function registerPost(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'Admin'
        ]);

        return back()->with('success', 'Register successfully');
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where(array('email' => $request->email))->first();

        if ($user) {
            $usertype = $user->user_type;
            if ($usertype == 'Admin') {
                if (Auth::attempt($credentials)) {
                    return redirect('/admin/dashboard')->with('success', 'Login Success');
                }
                return back()->with('error', 'Error Email or Password');
            } else {
                return back()->with('error', 'This is not admin email');
            }
        } else {
            return back()->with('error', 'This email is not registered.');
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
