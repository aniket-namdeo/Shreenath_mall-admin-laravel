<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashDeposit;
use App\Models\DeliveryUser;
use App\Models\User;
use Illuminate\Http\Request;

class CashDepositController extends Controller
{

    public function sendOtp(Request $request)
    {
        $userCheck = User::where('user_type', 'Admin')->first();

        $request->validate([
            'delivery_user_id' => 'required|exists:delivery_user,id',
            'cash_amount' => 'required|numeric|min:0',
            'deposit_date' => 'required|date',
        ]);

        $otp = rand(100000, 999999);

        $userCheck->update([
            'cash_deposit_otp' => $otp,
        ]);

        $data = [
            'delivery_user_id' => $request->delivery_user_id,
            'cash_amount' => $request->cash_amount,
            'deposit_date' => $request->deposit_date,
            'otp' => $otp,
        ];

        $depositRequest = CashDeposit::create($data);

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
            'delivery_user_id' => 'required|exists:delivery_user,id',
            'deposit_amount' => 'required|numeric|min:0',
            'deposit_date' => 'required|date',
        ]);

        $deliveryUser = DeliveryUser::where('id', $request->delivery_user_id)->first();

        if (!$deliveryUser) {
            return response()->json(['success' => false, 'message' => 'Delivery user not found.'], 404);
        }

        // $newTotalCashCollected = $deliveryUser->total_cash_collected - $request->deposit_amount;
        // $newTotalCashToSendBack = $deliveryUser->total_cash_to_send_back + $request->deposit_amount;
        $newTotalCashDeposit = $deliveryUser->total_cash_deposited + $request->deposit_amount;

        $newTotalPending = $deliveryUser->total_cash_collected - $deliveryUser->total_cash_deposited;

        $cashDeposit = CashDeposit::create([
            'delivery_user_id' => $request->delivery_user_id,
            'cash_amount' => $deliveryUser->total_cash_collected,
            'deposit_amount' => $request->deposit_amount,
            'deposit_date' => $request->deposit_date,
            'isVerified' => true
        ]);

        $deliveryUser->update([
            'total_cash_deposited' => $newTotalCashDeposit,
            'total_cash_pending' => $newTotalPending
            // 'total_cash_to_send_back' => $newTotalCashToSendBack,
        ]);

        return response()->json(['success' => true, 'data' => $cashDeposit], 201);
    }


    public function store(Request $request)
    {
        $request->validate([
            'delivery_user_id' => 'required|exists:delivery_user,id',
            'cash_amount' => 'required|numeric|min:0',
            'deposit_date' => 'required|date',
        ]);

        $depositRequest = CashDeposit::create($request->all());

        return response()->json(['message' => 'Deposit request created successfully', 'data' => $depositRequest], 201);
    }

    public function getCashDeposit(Request $request)
    {
        $data = CashDeposit::where('delivery_user_id', $request->id)->where('status', 'approved')->orderBy('id', 'desc')->first();

        // if ($data) {
            return response()->json(['message' => 'Deposit request get successfully', 'data' => $data], 201);
        // } else {
        //     return response()->json(['message' => 'Request not approved', 'data' => $data], 201);
        // }
    }

    public function updateCashDeposit(Request $request)
    {
        $deliveryUser = DeliveryUser::where('id', $request->delivery_user_id)->first();
        $data = CashDeposit::where('delivery_user_id', $request->delivery_user_id)->where('status', 'approved')->orderBy('id', 'desc')->first();

        $newTotalCashDeposit = $deliveryUser->total_cash_deposited + $data->deposit_amount;

        $newTotalPending = $deliveryUser->total_cash_collected - $data->deposit_amount;

        $data->update([
            'deposit_status' => 'delivered'
        ]);

        $deliveryUser->update([
            'total_cash_deposited' => $newTotalCashDeposit,
            'total_cash_pending' => $newTotalPending
        ]);

        return response()->json(['success'=> true,'message' => 'Depositconfirmed', 'data' => $data], 201);

    }

}
