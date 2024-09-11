<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use App\Models\PrivacyPolicy;
use App\Models\OfferSlider;
use App\Models\Order_Queue;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class OrderQueueController extends Controller
{
    function checkUserResponse($deliveryUserId, $orderId)
    {
        $timeout = 60;
        $elapsedTime = 0;
        $pollInterval = 5;

        while ($elapsedTime < $timeout) {
            $trackingRecord = DeliveryTracking::
                where('delivery_user_id', $deliveryUserId)
                ->where('order_id', $orderId)
                ->first();

            if ($trackingRecord && $trackingRecord->response !== null) {
                return $trackingRecord->response;
            }

            sleep($pollInterval);
            $elapsedTime += $pollInterval;
        }

        return null;
    }
    public function waitForUserResponse($deliveryUserId, $orderId)
    {
        $response = $this->checkUserResponse($deliveryUserId, $orderId);
        return $response === null ? 'timeout' : $response;
    }

    function assignOrdersToDeliveryUsers()
    {
        // Fetch all unassigned orders from the order_queue table
        $orders = Order_Queue::where('status', 0)->get();

        foreach ($orders as $order) {
            // Process each order to assign a delivery user
            $this->processOrder($order);
        }
    }

    function processOrder($order)
    {
        // Get a free delivery user

        $deliveryUser = DeliveryUser::
            where('current_status', 'free')
            ->first();

        $deliveryTrack = DeliveryTracking::where('order_id', $order->id);

        if($deliveryTrack->count() > 0){
            
            $details = DeliveryTracking::where('order_id', $order->id)->pluck('delivery_user_id')->filter()->all();

            $deliveryUserData = DeliveryUser::where('current_status', 'free')->whereNotIn('id',$details)->first();
        }else{
            
            $deliveryUserData = $deliveryUser;
        }


        if ($deliveryUserData) {
            // Insert the new tracking record with a pending response
            $deliveryTracking = DeliveryTracking::create([
                'order_id' => $order->id,
                'delivery_user_id' => $deliveryUserData->id,
                'status' => 'pending',
                'order_status' => 'pending',
                'assigned_at' => now(),
            ]);

            $deliveryUser->current_status = 'engaged';
            $deliveryUser->save();

            Order_Queue::where('order_id', $order->id)->update(['status' => 1]);

            // Notify the delivery user to accept or reject the order

            $title = 'New Order';
            $body = 'You got a new order.';
            $image = null;

            $notificationResponse = sendFirebaseNotification($title, $body, [$deliveryUser->deviceId], $image);

            return response()->json([
                'message' => 'Order assigned successfully',
                'data' => $deliveryUser,
                'status' => true
            ], 201);


            // $response = $this->waitForUserResponse($deliveryUser->id, $order->id);

            // if ($response === 'accepted') {
            //     return response()->json([
            //         'message' => 'Order accepted by the delivery user',
            //         'status' => true
            //     ], 200);
            // } elseif ($response === 'rejected' || $response === 'timeout') {
            //     $deliveryTracking->order_status = 'rejected';
            //     $deliveryTracking->save();

            //     $deliveryUser->current_status = 'free';
            //     $deliveryUser->save();

            //     $this->processOrder($order);
            // }
        } else {
            // If no free delivery users are found, wait and retry
            // $this->processOrder($order);
            return response()->json([
                'message' => 'No user is free at moment',
                'status' => false
            ], 400);
        }
    }

    public function autoReject(Request $request)
    {
        $deliveryTracking = DeliveryTracking::find($request->id);
        $deliveryUser = DeliveryUser::where('id', $deliveryTracking->delivery_user_id);

        if (!$deliveryTracking) {
            return response()->json(['success' => false, 'message' => 'Delivery tracking not found'], 404);
        }
        $order_queue_data = Order_Queue::where('order_id', $deliveryTracking->order_id)->first();

        $order_queue_data->status = 0;
        $order_queue_data->save();
        $deliveryTracking->order_status = 'auto_reject';
        $deliveryTracking->save();
        $deliveryUser->current_status = 'free';

        return response()->json(['success' => true, 'message' => 'Order status updated successfully']);
    }
}