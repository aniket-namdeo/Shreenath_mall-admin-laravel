<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryTrackingOrder;
use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use App\Models\Order;

class DeliveryTrackingOrderController extends Controller
{

    public function createTrackingOrder(Request $request)
    {
        $request->validate([
            'delivery_tracking_id' => 'required|integer',
            'order_id' => 'required|integer',
            'delivery_user_id' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $trackingOrder = DeliveryTrackingOrder::create([
            'delivery_tracking_id' => $request->delivery_tracking_id,
            'order_id' => $request->order_id,
            'delivery_user_id' => $request->delivery_user_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'delivery_status' => 'out for delivery'
        ]);

        return response()->json([
            'message' => 'Tracking order created successfully',
            'data' => $trackingOrder,
            'status' => true
        ], 201);
    }

    public function updateTrackingOrder(Request $request)
    {
        $request->validate([
            'delivery_tracking_id' => 'required|integer',
            'order_id' => 'required|integer',
            'delivery_user_id' => 'required|integer',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $trackingOrder = DeliveryTrackingOrder::create([
            'delivery_tracking_id' => $request->delivery_tracking_id,
            'order_id' => $request->order_id,
            'delivery_user_id' => $request->delivery_user_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'delivery_status' => 'delivered'
        ]);

        return response()->json([
            'message' => 'Tracking order updated successfully',
            'data' => $trackingOrder,
            'status' => true
        ], 201);
    }

    public function getOrderTracking($orderId)
    {
        $trackingDetails = DeliveryTrackingOrder::where('order_id', $orderId)->orderBy('id', 'desc')->first();

        return response()->json([
            'message' => '',
            'data' => $trackingDetails,
            'status' => true
        ], 200);
    }

}
