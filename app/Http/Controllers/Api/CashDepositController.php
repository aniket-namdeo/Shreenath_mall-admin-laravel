<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashDeposit;
use App\Models\DeliveryUser;
use App\Models\User;
use Illuminate\Http\Request;

class CashDepositController extends Controller
{

    public function sendOtp()
    {
        $userCheck = User::where('user_type', 'Admin')->first();

        $otp = rand(100000, 999999);

        $userCheck->update([
            'cash_deposit_otp' => $otp,
        ]);

        $subject = "Verification Otp";
        $msg = "Confirmation Otp is $otp";

        send_mail('himanshu.devgade@secondmedic.com', $subject, $msg);

        return response()->json(['success' => true, 'message' => 'OTP generated and updated successfully.', 'otp' => $otp], 200);

    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $userCheck = User::where('user_type', 'Admin')->first();

        if (!$userCheck) {
            return response()->json(['success' => false, 'data' => 'Admin user not found'], 404);
        }

        if ($userCheck->cash_deposit_otp == $request->otp) {
            return response()->json(['success' => true, 'data' => 'OTP verified successfully'], 200);
        } else {
            return response()->json(['success' => false, 'data' => 'Incorrect OTP'], 400);
        }
    }


    public function storeDeposit(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'delivery_user_id' => 'required|exists:delivery_user,id',
            'deposit_amount' => 'required|numeric|min:0',
            'deposit_date' => 'required|date',
        ]);

        $deliveryUser = DeliveryUser::where('id', $request->delivery_user_id)->first();

        if (!$deliveryUser) {
            return response()->json(['success' => false, 'message' => 'Delivery user not found.'], 404);
        }

        $newTotalCashCollected = $deliveryUser->total_cash_collected - $request->deposit_amount;
        $newTotalCashToSendBack = $deliveryUser->total_cash_to_send_back + $request->deposit_amount;

        $cashDeposit = CashDeposit::create([
            'delivery_user_id' => $request->delivery_user_id,
            'cash_amount' => $deliveryUser->total_cash_collected,
            'deposit_amount' => $request->deposit_amount,
            'deposit_date' => $request->deposit_date,
            'isVerified' => true
        ]);

        $deliveryUser->update([
            'total_cash_collected' => $newTotalCashCollected,
            'total_cash_to_send_back' => $newTotalCashToSendBack,
        ]);

        return response()->json(['success' => true, 'data' => $cashDeposit], 201);
    }
}
