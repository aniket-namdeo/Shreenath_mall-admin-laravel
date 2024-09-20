<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DeliveryUser;
use App\Models\IncentiveDeposit;
use App\Models\QrTable;
use App\Models\Referrals;
use Exception;
use Illuminate\Support\Str;

class DeliveryUserController extends Controller
{
    public function Deliverylogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = DeliveryUser::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'DeliveryUser not found, Register your account', 'status' => false], 401);
        }

        if ($request->deviceId) {
            $user->deviceId = $request->deviceId;
            $user->save();
        }

        if ($user->is_blocked == 1) {
            return response()->json([
                'message' => 'Your account has been blocked. Please contact the admin.',
                'status' => false
            ], 403);
        }

        if ($user->status == "pending") {
            return response()->json([
                'message' => 'Your account has not verified yet.',
                'status' => false
            ], 403);
        }

        $data = [
            "id" => $user->id,
            "name" => $user->name,
            "contact" => $user->contact,
            "email" => $user->email,
            "user_type" => $user->user_type,
        ];
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login successfully',
                'user' => $data,
                'status' => true
            ]);
        } else {
            return response()->json(['message' => 'Please Enter Correct Password', 'status' => false], 401);
        }
    }


    // public function forgetPassword(Request $request)
    // {
    //     try {
    //         $user = DeliveryUser::where('email', $request->email)->first();

    //         if ($user) {
    //             $otp = random_int(100000, 999999);
    //             $user->otp = $otp;
    //             $user->save();

    //             $subject = "Reset OTP for Password";
    //             $message = "$otp -  OTP for change password";

    //             // change otp status to 0 for always verify new otp
    //             DeliveryUser::where(array('email' => $request->email))->update(['otp_status' => '0']);

    //             send_mail($user->email, $subject, $message);
    //             return response()->json(['status' => true, 'message' => 'Otp send successfully']);
    //         } else {
    //             return response()->json(['status' => false, 'message' => 'DeliveryUser not found']);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['status' => false, 'message' => $e]);
    //     }
    // }

    // public function verifyOtp(Request $request)
    // {
    //     $user = DeliveryUser::where('email', $request->email)->first();
    //     if ($user) {
    //         $userotp = $user->otp;
    //         $userotp_status = $user->otp_status;
    //         if ($userotp_status == 0) {
    //             if ($request->otp == $userotp) {
    //                 $result = DeliveryUser::where(array('email' => $request->email))->update(['otp_status' => '1']);
    //                 return response()->json(['message' => 'Otp Verified']);
    //             } else {
    //                 return response()->json(['message' => 'Otp Incorrect']);
    //             }
    //         } else {
    //             return response()->json(['message' => 'Otp already verified, send otp again']);
    //         }
    //     } else {
    //         return response()->json(['message' => 'DeliveryUser not found']);
    //     }
    // }

    // public function updatePassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'new_password' => 'required|string|min:6|confirmed',
    //     ]);

    //     $user = DeliveryUser::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json(['error' => 'DeliveryUser not found'], 404);
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->save();

    //     return response()->json(['message' => 'Password set successfully'], 200);
    // }


    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required|string|min:6|confirmed',
    //     ]);
    //     $user = DeliveryUser::where('id', $request->id)->first();
    //     if (!$user) {
    //         return response()->json(['error' => 'DeliveryUser not found'], 404);
    //     }
    //     // $user = DeliveryUser::where('email', $request->email)->first();

    //     if ($user && Hash::check($request->old_password, $user->password)) {
    //         $user->password = Hash::make($request->new_password);
    //         $user->save();
    //     } else {
    //         return response()->json(['message' => 'Old password is incorrect'], 400);
    //     }

    //     return response()->json(['message' => 'Password set successfully'], 200);
    // }

    public function updateProfile(Request $request, $id)
    {
        $data = [];

        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->contact) {
            $data['contact'] = $request->contact;
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
        if ($request->address) {
            $data['address'] = $request->address;
        }
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '_profile_image.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('uploads/user'), $imageName);
            $full_path = "uploads/user/" . $imageName;
            $data['profile_image'] = $full_path;
        }
        $result = DeliveryUser::where('id', $id)->update($data);

        return response()->json([
            'message' => 'DeliveryUser updated successfully',
            'data' => null,
            'status' => true
        ], 200);

    }

    public function getUser($id)
    {
        $result = DeliveryUser::select('id', 'name', 'email', 'contact', 'gender', 'dob', 'profile_image', 'aadhar_card', 'pan_no', 'address', 'state', 'city', 'vehicle_name', 'vehicle_no', 'driving_license')->where('id', $id)->first();
        return response()->json(['data' => $result], 200);
    }

    // Scan qr
    public function scanQr(Request $request)
    {
        $validated = $request->validate([
            'delivery_user_id' => 'required|exists:delivery_user,id',
            'qr_code' => 'required'
        ]);
        $deliveryUserId = $request->input('delivery_user_id');
        $deliveryUser = DeliveryUser::find($deliveryUserId);

        if (!$deliveryUser) {
            return response()->json(['message' => 'Delivery user not found.'], 404);
        }
        if ($deliveryUser->current_status == 'free') {
            return response()->json(['message' => 'Delivery User is already free.']);
        }
        $qrData = QrTable::create([
            'delivery_user_id' => $validated['delivery_user_id'],
            'qr_code' => $validated['qr_code'],
        ]);
        if (!$qrData) {
            return response()->json(['message' => 'QR code data could not be saved.'], 500);
        }
        if ($deliveryUser->current_status == 'engaged') {
            $deliveryUser->update(['current_status' => 'free']);
            return response()->json(['message' => 'Delivery user status updated successfully.'], 200);
        }

        return response()->json(['message' => 'Unable to update delivery user status.']);
    }


    public function incentiveList(Request $request)
    {
        $data = IncentiveDeposit::select(
            'incentive_deposit.*',
            'delivery_user.name as delivery_user_name'
        )
            ->join('delivery_user', 'incentive_deposit.delivery_user_id', '=', 'delivery_user.id')
            ->where('incentive_deposit.delivery_user_id', $request->id)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['success' => false, 'data' => null, 'message' => 'No Data Found'], 400);
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function getQrReferralCode($id)
    {
        $result = DeliveryUser::select('id', 'name', 'qr_code', 'referral_code')->where('id', $id)->first();
        return response()->json(['success' => true, 'data' => $result], 200);
    }

    public function listReferralsold($referrer_id)
    {
        $referrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', 'referral.referrer_id', '=', 'referrer_user.id')
            ->leftJoin('delivery_user as referrer_delivery', 'referral.referrer_id', '=', 'referrer_delivery.id')
            ->where('referral.referrer_id', $referrer_id)
            ->select(
                'referral.*',
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery'
            )
            ->get();

        $referrerBalance = null;

        $formattedReferrals = $referrals->map(function ($referral) use (&$referrerBalance) {
            if ($referral->referrer_name_user) {
                $referrerBalance = $referral->referrer_wallet_balance_user;
            } elseif ($referral->referrer_name_delivery) {
                $referrerBalance = $referral->referrer_wallet_balance_delivery;
            }

            return [
                'referred_name' => $referral->referred_name,
                'referred_contact' => $referral->referred_contact,
                'referred_wallet_balance' => $referral->referred_wallet_balance,
                'referred_at' => $referral->created_at,
                'referral_status' => $referral->status
            ];
        });

        return response()->json([
            'data' => $formattedReferrals,
            'pending_wallet_balance' => $referrerBalance,
        ]);
    }

    public function listReferrals($referrer_id)
    {
        $referrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', 'referral.referrer_id', '=', 'referrer_user.id')
            ->leftJoin('delivery_user as referrer_delivery', 'referral.referrer_id', '=', 'referrer_delivery.id')
            ->where('referral.referrer_id', $referrer_id)
            ->select(
                'referral.*',
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery'
            )
            ->get();

        $referrerBalance = null;
        $pendingWalletBalance = 0;
        $redeemedWalletBalance = 0;

        $formattedReferrals = $referrals->map(function ($referral) use (&$referrerBalance, &$pendingWalletBalance, &$redeemedWalletBalance) {
            if ($referral->referrer_name_user) {
                $referrerBalance = $referral->referrer_wallet_balance_user;
            } elseif ($referral->referrer_name_delivery) {
                $referrerBalance = $referral->referrer_wallet_balance_delivery;
            }

            if ($referral->status === 'pending') {
                $pendingWalletBalance += 20;
            } elseif ($referral->status === 'redeemed') {
                $redeemedWalletBalance += 20;
            }

            return [
                'referred_name' => $referral->referred_name,
                'referred_contact' => $referral->referred_contact,
                'referred_wallet_balance' => $referral->referred_wallet_balance,
                'referred_at' => $referral->created_at,
                'referral_status' => $referral->status,
            ];
        });

        return response()->json([
            'data' => $formattedReferrals,
            'pending_wallet_balance' => $pendingWalletBalance,
            'redeemed_wallet_balance' => $redeemedWalletBalance,
            'total_wallet_balance' => $referrerBalance,
        ]);
    }


    public function userReferralsList($user_id)
    {
        $referrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', 'referral.referrer_id', '=', 'referrer_user.id')
            ->leftJoin('users as users', 'referral.referrer_id', '=', 'users.id')
            ->where(array('referral.referrer_id' => $user_id, 'referral.referr_type' => "user"))
            ->select(
                'referral.*',
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'users.name as referrer_name_delivery',
                'users.wallet_balance as referrer_wallet_balance_delivery',
                'referral.status as referral_status'
            )
            ->get();

        $referrerBalance = null;

        $formattedReferrals = $referrals->map(function ($referral) use (&$referrerBalance) {
            if ($referral->referrer_name_user) {
                $referrerBalance = $referral->referrer_wallet_balance_user;
            } elseif ($referral->referrer_name_delivery) {
                $referrerBalance = $referral->referrer_wallet_balance_delivery;
            }

            return [
                'referred_name' => $referral->referred_name,
                'referred_contact' => $referral->referred_contact,
                'referred_wallet_balance' => $referral->referred_wallet_balance,
                'referred_at' => $referral->created_at,
                'referral_status' => $referral->referral_status
            ];
        });

        return response()->json([
            'data' => $formattedReferrals,
            'wallet_balance' => $referrerBalance,
        ]);
    }

}
