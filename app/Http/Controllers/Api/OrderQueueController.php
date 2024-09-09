<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use App\Models\PrivacyPolicy;
use App\Models\OfferSlider;
use App\Models\Order_Queue;
use Illuminate\Http\Request;

class OrderQueueController extends Controller
{
    function checkUserResponse($deliveryUserId, $orderId)
    {
        // Timeout period (e.g., 1 minute)
        $timeout = 60; // seconds
        $elapsedTime = 0;
        $pollInterval = 5; // Check every 5 seconds

        while ($elapsedTime < $timeout) {
            // Check the response in the delivery_tracking table
            $trackingRecord = DeliveryTracking::
                where('delivery_user_id', $deliveryUserId)
                ->where('order_id', $orderId)
                ->first();

            if ($trackingRecord && $trackingRecord->response !== null) {
                // Return the response (accepted or rejected)
                return $trackingRecord->response;
            }

            // Sleep for the poll interval before checking again
            sleep($pollInterval);
            $elapsedTime += $pollInterval;
        }

        // If no response after timeout, return null or 'timeout'
        return null;
    }

    function waitForUserResponse($deliveryUserId, $orderId)
    {
        $response = $this->checkUserResponse($deliveryUserId, $orderId);
        if ($response == null) {
            // Implement timeout (e.g., 1 minute)
            return 'timeout';
        }
        return $response;
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

        $deliveryUser = DeliveryUser::where('current_status', 'free')->first();

        if ($deliveryUser) {
            // Insert the new tracking record with a pending response
            DeliveryTracking::create([
                'order_id' => $order->id,
                'delivery_user_id' => $deliveryUser->id,
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

            // Wait for a response
            // $response = $this->waitForUserResponse($deliveryUser->id, $order->order_id);

            // if ($response == 'accepted') {

            //     $deliveryTracking->order_status = 'accepted';
            //     $deliveryTracking->save();

            //     // Remove the order from the order queue
            //     $orderQueueData = Order_Queue::where('order_id', $order->id)->first();
            //     if ($orderQueueData) {
            //         $orderQueueData->delete();
            //     }

            //     return response()->json(['success' => true, 'message' => 'Order accepted successfully.']);
            // } else if($response == "rejected") {

            //     $deliveryTracking->order_status = 'rejected';
            //     $deliveryTracking->save();

            //     // Mark the delivery user as free again
            //     $deliveryUser->current_status = 'free';
            //     $deliveryUser->save();

            //     // Retry with another delivery user
            //     $this->processOrder($order);
            // }else {
            //     // Handle the case of timeout
            //     $deliveryTracking->order_status = 'pending';
            //     $deliveryTracking->save();
            //     $deliveryUser->current_status = 'free';
            //     $deliveryUser->save();

            //     return response()->json(['success' => false, 'message' => 'Order response timed out.']);
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
}