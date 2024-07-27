<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'contact' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validated) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'contact' => $request->input('contact'),
                'password' => Hash::make($request->input('password')),
                'user_type' => 'User'
            ]);

            return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $otp = random_int(100000, 999999);
                $user->otp = $otp;
                $user->save();

                $subject = "Reset OTP for Password";
                $message = "$otp -  OTP for change password";

                // change otp status to 0 for always verify new otp
                User::where(array('email' => $request->email))->update(['otp_status' => '0']);

                send_mail($user->email, $subject, $message);
                return response()->json(['status' => true, 'message' => 'Otp send successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $userotp = $user->otp;
            $userotp_status = $user->otp_status;
            if ($userotp_status == 0) {
                if ($request->otp == $userotp) {
                    $result = User::where(array('email' => $request->email))->update(['otp_status' => '1']);
                    return response()->json(['message' => 'Otp Verified']);
                } else {
                    return response()->json(['message' => 'Otp Incorrect']);
                }
            } else {
                return response()->json(['message' => 'Otp already verified, send otp again']);
            }
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password set successfully'], 200);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        // $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        } else {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        return response()->json(['message' => 'Password set successfully'], 200);
    }


    public function updateProfile(Request $request, $id)
    {
        $data = [];

        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->mobile) {
            $data['mobile'] = $request->mobile;
        }
        if ($request->dob) {
            $data['dob'] = $request->dob;
        }
        if ($request->email) {
            $data['email'] = $request->email;
        }
        if ($request->gender) {
            $data['gender'] = $request->gender;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/user'), $imageName);
            $full_path = "uploads/user/" . $imageName;
            $data['image'] = $full_path;
        }

        $result = User::where('id', $id)->update($data);

        return response()->json(['message' => 'User updated successfully'], 200);
    }


    public function getUser($id)
    {
        $result = User::select('id', 'name', 'email', 'mobile', 'gender', 'dob', 'image', 'address', 'state', 'city')->where('id', $id)->get();
        return response()->json(['data' => $result], 200);
    }

}
