<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\User_addresses;
use App\Models\Cart;
use App\Models\DeliveryTracking;
use App\Models\DeliveryTrackingOrder;
use App\Models\DeliveryUser;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latDistance = deg2rad($lat2 - $lat1);
        $lonDistance = deg2rad($lon2 - $lon1);

        $a = sin($latDistance / 2) * sin($latDistance / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDistance / 2) * sin($lonDistance / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    public function getDistanceTime(Request $request)
    {
        $userLat = $request->input('userlat');
        $userLong = $request->input('userlong');
        $deliveryUserLat = $request->input('deliveryUserLat');
        $deliveryUserLong = $request->input('deliveryUserLong');
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json';

        $params = [
            'origins' => "$userLat,$userLong",
            'destinations' => "$deliveryUserLat,$deliveryUserLong",
            'key' => env('GOOGLE_API_KEY'),
            'mode' => 'driving'
        ];

        $response = Http::get($url, $params);

        if ($response->successful()) {
            $data = $response->json();

            $distance = $data['rows'][0]['elements'][0]['distance']['value'] / 1000; // distance in kilometers
            $duration = $data['rows'][0]['elements'][0]['duration']['value'] / 60;   // duration in minutes

            return response()->json([
                'distance' => round($distance, 2),
                'estimated_time' => round($duration, 0)
            ]);
        }

        return response()->json(['error' => 'Unable to fetch distance and time'], 500);
    }

    public function getDeviceId()
    {
        $deviceIds = DeliveryUser::where('current_status', 'free')->pluck('deviceId')->filter()->all();
        $title = 'New Order';
        $body = 'You got a new order.';
        $data = ['data1' => 'screen'];
        $image = null;

        $response = sendFirebaseNotification($title, $body, $deviceIds, $image, $data);

        return response()->json(['deviceIds' => $deviceIds, 'response' => $response]);
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'address_id' => 'required',
            'coupon_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_fee' => 'nullable|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        // $OrderDetail = User_addresses::where('address_id',$request->address_id)->first();

        // $calculateDistancetime = $this->calculateDistance(
        //     $this->mallLatitude,
        //     $this->mallLongitude,
        //     $OrderDetail->latitide,
        //     $OrderDetail->longitude
        // );

        // if ($distance > $this->maxDeliveryDistance) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Delivery is not possible for your location. The maximum delivery distance is 5 km.'
        //     ], 400);
        // }

        try {
            $otp = random_int(100000, 999999);
            $orderDate = $request->order_date ?: date('Y-m-d H:i:s');
            $deliveryDate = $request->delivery_date ?: date('Y-m-d H:i:s');

            $order = Order::create([
                'user_id' => $request->user_id,
                'total_amount' => $request->total_amount,
                'status' => "pending",
                'delivery_status' => "pending",
                'payment_method' => $request->payment_method,
                'payment_status' => "unpaid",
                'order_date' => $orderDate,
                'delivery_date' => $deliveryDate,
                'address_id' => $request->address_id,
                'coupon_code' => $request->coupon_code,
                'discount_amount' => $request->discount_amount,
                'tax_amount' => $request->tax_amount,
                'shipping_fee' => $request->shipping_fee,
                'otp' => $otp,
                'handling_charge' => $request->handling_charge
            ]);

            foreach ($request->items as $item) {
                Order_items::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            foreach ($request->items as $item) {
                Cart::where('id', $item['cart_id'])->delete();
            }

            // $deviceIds = DeliveryUser::pluck('deviceId')->filter()->all();
            $deviceIds = DeliveryUser::where('current_status', 'free')->pluck('deviceId')->filter()->all();
            $title = 'New Order';
            $body = 'You got a new order.';
            $image = null;

            $response = sendFirebaseNotification($title, $body, $deviceIds, $image);

            return response()->json(['order' => $order, 'message' => 'Order created successfully'], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order', 'message' => $e->getMessage()], 500);
        }
    }
    public function getOrdersByUser($userId)
    {
        $orders = Order::where('orders.user_id', $userId)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->join('product', 'order_items.product_id', '=', 'product.id')
            ->select(
                'orders.id as order_id',
                'orders.user_id',
                'orders.total_amount',
                'orders.status',
                'orders.delivery_status',
                'orders.payment_method',
                'orders.payment_status',
                'orders.order_date',
                'orders.delivery_date',
                'orders.address_id',
                'orders.coupon_code',
                'orders.discount_amount',
                'orders.tax_amount',
                'orders.shipping_fee',
                'order_items.product_id',
                'order_items.quantity',
                'order_items.price',
                'product.product_name as product_name',
                'product.mrp as product_mrp',
                'product.price as product_price',
                'product.image_url1 as product_image_url',
                'user_addresses.house_address',
                'user_addresses.street_address',
                'user_addresses.landmark',
                'user_addresses.city',
                'user_addresses.state',
                'user_addresses.country',
                'user_addresses.pincode'
            )
            ->orderBy('orders.id', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }

        $groupedOrders = $orders->groupBy('order_id');

        $result = $groupedOrders->map(function ($order) {
            $orderData = $order->first();
            $items = $order->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product_name' => $item->product_name,
                    'product_mrp' => $item->product_mrp,
                    'product_price' => $item->product_price,
                    'product_image_url' => $item->product_image_url,
                ];
            });

            return [
                'id' => $orderData->order_id,
                'user_id' => $orderData->user_id,
                'total_amount' => $orderData->total_amount,
                'status' => $orderData->status,
                'delivery_status' => $orderData->delivery_status,
                'payment_method' => $orderData->payment_method,
                'payment_status' => $orderData->payment_status,
                'order_date' => $orderData->order_date,
                'delivery_date' => $orderData->delivery_date,
                'address_id' => $orderData->address_id,
                'coupon_code' => $orderData->coupon_code,
                'discount_amount' => $orderData->discount_amount,
                'tax_amount' => $orderData->tax_amount,
                'shipping_fee' => $orderData->shipping_fee,
                'house_address' => $orderData->house_address,
                'street_address' => $orderData->street_address,
                'landmark' => $orderData->landmark,
                'city' => $orderData->city,
                'state' => $orderData->state,
                'country' => $orderData->country,
                'pincode' => $orderData->pincode,
                'items' => $items
            ];
        });

        return response()->json(['orders' => $result->values()], 200);
    }
    public function getOrderDetail($id)
    {
        $orders = Order::where('orders.id', $id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->join('product', 'order_items.product_id', '=', 'product.id')
            ->select(
                'orders.id as order_id',
                'orders.user_id',
                'orders.total_amount',
                'orders.status',
                'orders.delivery_status',
                'orders.payment_method',
                'orders.payment_status',
                'orders.order_date',
                'orders.delivery_date',
                'orders.address_id',
                'orders.coupon_code',
                'orders.discount_amount',
                'orders.tax_amount',
                'orders.shipping_fee',
                'orders.handling_charge',
                'orders.otp',
                'order_items.product_id',
                'order_items.quantity',
                'order_items.price',
                'product.product_name as product_name',
                'product.mrp as product_mrp',
                'product.price as product_price',
                'product.image_url1 as product_image_url',
                'user_addresses.house_address',
                'user_addresses.street_address',
                'user_addresses.landmark',
                'user_addresses.city',
                'user_addresses.state',
                'user_addresses.country',
                'user_addresses.pincode',
                'user_addresses.latitude',
                'user_addresses.longitude'
            )
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders with this id'], 404);
        }

        $groupedOrders = $orders->groupBy('order_id');

        $result = $groupedOrders->map(function ($order) {
            $orderData = $order->first();
            $items = $order->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product_name' => $item->product_name,
                    'product_mrp' => $item->product_mrp,
                    'product_price' => $item->product_price,
                    'product_image_url' => $item->product_image_url,
                ];
            });

            $totalMrp = number_format($order->sum(function ($item) {
                return $item->product_mrp * $item->quantity;
            }), 2, '.', '');

            return [
                'id' => $orderData->order_id,
                'user_id' => $orderData->user_id,
                'total_amount' => $orderData->total_amount,
                'status' => $orderData->status,
                'delivery_status' => $orderData->delivery_status,
                'payment_method' => $orderData->payment_method,
                'payment_status' => $orderData->payment_status,
                'order_date' => $orderData->order_date,
                'delivery_date' => $orderData->delivery_date,
                'address_id' => $orderData->address_id,
                'coupon_code' => $orderData->coupon_code,
                'discount_amount' => $orderData->discount_amount,
                'tax_amount' => $orderData->tax_amount,
                'shipping_fee' => $orderData->shipping_fee,
                'handling_charge' => $orderData->handling_charge,
                'house_address' => $orderData->house_address,
                'street_address' => $orderData->street_address,
                'landmark' => $orderData->landmark,
                'city' => $orderData->city,
                'state' => $orderData->state,
                'country' => $orderData->country,
                'pincode' => $orderData->pincode,
                'total_mrp' => $totalMrp,
                'otp' => $orderData->otp,
                'items' => $items,
            ];
        });

        return response()->json(['orders' => $result->values()], 200);
    }

    public function getLastOrderDetail($userId)
    {

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json';

        $lastOrder = Order::select(
            'orders.id',
            'orders.user_id',
            'orders.total_amount',
            'orders.status',
            'orders.delivery_status',
            'orders.address_id',
            'user_addresses.latitude as user_latitude',
            'user_addresses.longitude as user_longitude'
        )
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('orders.user_id', $userId)
            ->orderBy('orders.id', 'desc')
            ->first();

        if (!$lastOrder) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }
        $deliveryTracking = DeliveryTracking::
            where('order_id', $lastOrder->id)
            ->first();

        $deliveryUserDetails = null;
        $deliveryTrackingDetails = null;
        // $calculateDistancetime = null;
        $distance = null;
        $estimatedTime = null;

        if ($deliveryTracking) {
            $deliveryUserDetails = DeliveryUser::select(
                'id',
                'name',
                'contact',
            )
                ->
                where('id', $deliveryTracking->delivery_user_id)
                ->first();

            $deliveryTrackingDetails = DeliveryTrackingOrder::
                select('latitude as delivery_latitude', 'longitude as delivery_longitude')
                ->where('order_id', $lastOrder->id)
                ->orderBy('updated_at', 'desc')
                ->first();
        }

        if ($deliveryTrackingDetails) {

            $params = [
                'origins' => "$lastOrder->user_latitude,$lastOrder->user_longitude",
                'destinations' => "$deliveryTrackingDetails->delivery_latitude,$deliveryTrackingDetails->delivery_longitude",
                'key' => env('GOOGLE_API_KEY'),
                'mode' => 'driving'
            ];

            $response = Http::get($url, $params);
            if ($response->successful()) {
                $data = $response->json();

                // $distance = $data['rows'][0]['elements'][0]['distance']['value'] / 1000; // distance in kilometers
                // $duration = $data['rows'][0]['elements'][0]['duration']['value'] / 60;   // duration in minutes

                if (isset($data['rows'][0]['elements'][0]['distance']['value'])) {
                    $distance = $data['rows'][0]['elements'][0]['distance']['value'] / 1000; // Convert meters to kilometers
                }

                if (isset($data['rows'][0]['elements'][0]['duration']['value'])) {
                    $estimatedTime = $data['rows'][0]['elements'][0]['duration']['value'] / 60; // Convert seconds to minutes
                }
            }
        }

        $response = [
            'order' => $lastOrder,
            'delivery_user' => $deliveryUserDetails,
            'delivery_tracking' => $deliveryTrackingDetails,
            'distance' => $distance ? round($distance, 2) : null,
            'estimated_time' => $estimatedTime ? round($estimatedTime, 0) : null,
        ];
        return response()->json($response);
    }

    public function getOrderDetailDeliveryUser($id)
    {
        $orders = Order::where('orders.id', $id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->join('product', 'order_items.product_id', '=', 'product.id')
            ->leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->select(
                'orders.id as order_id',
                'orders.user_id',
                'orders.total_amount',
                'orders.status',
                'orders.delivery_status',
                'orders.payment_method',
                'orders.payment_status',
                'orders.order_date',
                'orders.delivery_date',
                'orders.address_id',
                'orders.coupon_code',
                'orders.discount_amount',
                'orders.tax_amount',
                'orders.shipping_fee',
                'orders.otp',
                'order_items.product_id',
                'order_items.quantity',
                'order_items.price',
                'product.product_name as product_name',
                'product.mrp as product_mrp',
                'product.price as product_price',
                'product.image_url1 as product_image_url',
                'user_addresses.house_address',
                'user_addresses.street_address',
                'user_addresses.landmark',
                'user_addresses.city',
                'user_addresses.state',
                'user_addresses.country',
                'user_addresses.pincode',
                'user_addresses.latitude',
                'user_addresses.longitude',
                'delivery_user.id as delivery_user_id',
                'delivery_user.name as delivery_user_name',
                'delivery_user.contact as delivery_user_contact',
                'delivery_user.email as delivery_user_email',
                'delivery_user.vehicle_name as delivery_user_vehicle_name',
                'delivery_user.vehicle_no as delivery_user_vehicle_no',
                'delivery_user.vehicle_type as delivery_user_vehicle_type',
                'users.id as user_id',
                'users.name as user_name',
                'users.contact as user_contact',
                'delivery_tracking.id as deliveryTrackingId'
            )
            ->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders with this id'], 404);
        }

        $groupedOrders = $orders->groupBy('order_id');

        $result = $groupedOrders->map(function ($order) {
            $orderData = $order->first();
            $items = $order->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product_name' => $item->product_name,
                    'product_mrp' => $item->product_mrp,
                    'product_price' => $item->product_price,
                    'product_image_url' => $item->product_image_url,
                ];
            });

            $totalMrp = number_format($order->sum(function ($item) {
                return $item->product_mrp * $item->quantity;
            }), 2, '.', '');

            $deliveryUser = [
                'id' => $orderData->delivery_user_id,
                'name' => $orderData->delivery_user_name,
                'contact' => $orderData->delivery_user_contact,
                'email' => $orderData->delivery_user_email,
                'vehicle_name' => $orderData->delivery_user_vehicle_name,
                'vehicle_no' => $orderData->delivery_user_vehicle_no,
                'vehicle_type' => $orderData->delivery_user_vehicle_type
            ];

            $userDetail = [
                'id' => $orderData->user_id,
                'name' => $orderData->user_name,
                'contact' => $orderData->user_contact,
                'latitude' => $orderData->latitude,
                'longitude' => $orderData->longitude
            ];

            return [
                'id' => $orderData->order_id,
                'user_id' => $orderData->user_id,
                'total_amount' => $orderData->total_amount,
                'status' => $orderData->status,
                'delivery_status' => $orderData->delivery_status,
                'payment_method' => $orderData->payment_method,
                'payment_status' => $orderData->payment_status,
                'order_date' => $orderData->order_date,
                'delivery_date' => $orderData->delivery_date,
                'address_id' => $orderData->address_id,
                'coupon_code' => $orderData->coupon_code,
                'discount_amount' => $orderData->discount_amount,
                'tax_amount' => $orderData->tax_amount,
                'shipping_fee' => $orderData->shipping_fee,
                'house_address' => $orderData->house_address,
                'street_address' => $orderData->street_address,
                'landmark' => $orderData->landmark,
                'city' => $orderData->city,
                'state' => $orderData->state,
                'country' => $orderData->country,
                'pincode' => $orderData->pincode,
                'total_mrp' => $totalMrp,
                'otp' => $orderData->otp,
                'items' => $items,
                'delivery_user' => $deliveryUser,
                'user_detail' => $userDetail,
                'deliveryTrackingId' => $orderData->deliveryTrackingId,
            ];
        });

        $DeliveryUserTime = DeliveryTrackingOrder::select('latitude', 'longitude')->where('order_id', $id)->orderBy('id', 'desc')->first();
        if (!$DeliveryUserTime) {
            return response()->json(['orders' => $result->values(), 'estimateTimeDistance' => null], 200);
        }

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json';
        $params = [
            'origins' => $result->values()[0]['user_detail']['latitude'] . ',' . $result->values()[0]['user_detail']['longitude'],
            'destinations' => $DeliveryUserTime->latitude . ',' . $DeliveryUserTime->longitude,
            'key' => env('GOOGLE_API_KEY'),
            'mode' => 'driving'
        ];

        $response = Http::get($url, $params);

        $estimateTimeDistance = [];
        if ($response->successful()) {
            $data = $response->json();
            $distance = $data['rows'][0]['elements'][0]['distance']['value'] / 1000;
            $duration = $data['rows'][0]['elements'][0]['duration']['value'] / 60;

            $estimateTimeDistance = [
                'distance' => round($distance, 2),
                'estimated_time' => round($duration, 0)
            ];
        }

        return response()->json(['orders' => $result->values(), 'estimateTimeDistance' => $estimateTimeDistance], 200);
    }

    public function saveRemark(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'deliver_feedback' => 'required',
        ]);

        $data = DeliveryTracking::where('order_id', $request->order_id)->first();

        if ($data) {

            $data->deliver_feedback = $request->deliver_feedback;
            $data->save();

            return response()->json([
                'message' => 'Feedback updated successfully.',
                'data' => null,
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong.'
            ], 404);
        }
    }

    public function paymentStatusUpdate(Request $request, $id)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'payment_status' => 'required'
        ]);

        $order = Order::find($id);

        $transaction_time = date('Y-m-d H:m:s');

        if ($order) {
            $order->update([
                'transaction_id' => $request->transaction_id,
                'transaction_time' => $transaction_time,
                'payment_status' => $request->payment_status
            ]);

            return response()->json([
                'message' => 'Transaction details updated successfully.',
                'order' => $order
            ], 200);
        } else {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            DB::beginTransaction();
            try {
                $order->update([
                    'status' => 'cancelled'
                ]);
                $order->orderItems()->update(['isCancelled' => 1]);
                DB::commit();
                return response()->json(['message' => 'Order and its items cancelled'], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => 'Failed to cancel order and its items'], 500);
            }
        } else {
            return response()->json(['error' => 'No order with this id'], 404);
        }
    }

    public function cancelOrdersItems($id)
    {
        $checkData = Order_items::find($id);
        if ($checkData) {
            $checkData->update([
                'isCancelled' => 1
            ]);
            return response()->json(['message' => 'Order Item cancelled'], 201);
        } else {
            return response()->json(['error' => 'No items with this order id'], 500);
        }
    }

    public function orderRating(Request $request, $id)
    {
        $validated = $request->validate([
            'order_rating' => 'required',
            'order_feedback' => 'nullable'
        ]);

        $order = Order::find($id);

        if ($order) {
            $order->update([
                'order_rating' => $request->order_rating,
                'order_feedback' => $request->order_feedback
            ]);
            return response()->json(['success' => true, 'message' => 'Order rate successfully done'], 200);
        } else {
            return response()->json(['success' => false, 'error' => 'No order with this id'], 404);
        }
    }

    // public function getPendingOrdersWithItemsAndDeliveryUser(Request $request, $id)
    // {

    //     $deliveryUser = DeliveryUser::find($id);
    //     if (!$deliveryUser) {
    //         return response()->json(['success' => false, 'message' => 'Delivery user not found'], 404);
    //     }

    //     $totalCashCollected = $deliveryUser->total_cash_collected;
    //     $totalCashDeposited = $deliveryUser->total_cash_deposited;

    //     // Calculate the difference
    //     $cashDifference = $totalCashCollected - $totalCashDeposited;

    //     $orders = Order::
    //         leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
    //         ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
    //         ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
    //         ->where('orders.delivery_status', 'pending')
    //         ->where(function ($query) use ($id, $cashDifference) {
    //             $query->where('delivery_tracking.delivery_user_id', $id)
    //                 ->orWhereNull('delivery_tracking.delivery_user_id');

    //             if ($cashDifference >= 1000) {
    //                 $query->whereNotNull('delivery_tracking.delivery_user_id');
    //             }
    //         })
    //         ->orderBy('orders.id', 'desc')
    //     ;

    //     $orders = $orders->select(
    //         'orders.id as order_id',
    //         'orders.user_id',
    //         'orders.total_amount',
    //         'orders.status',
    //         'orders.payment_method',
    //         'orders.delivery_status as order_status',
    //         'orders.payment_status',
    //         'orders.order_date',
    //         'delivery_tracking.id as delivery_tracking_id',
    //         'delivery_tracking.order_status as delivery_status',
    //         'delivery_user.name as delivery_person_name',
    //         'delivery_user.contact as delivery_person_contact',
    //         'user_addresses.name as user_address_name',
    //         'user_addresses.contact as user_address_contact',
    //         'user_addresses.house_address as user_address_house',
    //         'user_addresses.street_address as user_address_street',
    //         'user_addresses.landmark as user_address_landmark',
    //         'user_addresses.city as user_address_city',
    //         'user_addresses.state as user_address_state',
    //         'user_addresses.country as user_address_country',
    //         'user_addresses.pincode as user_address_pincode',
    //         'user_addresses.latitude as user_latitude',
    //         'user_addresses.longitude as user_longitude'
    //     )
    //         ->get();

    //     return response()->json(['success' => true, 'data' => $orders]);
    // }

    // public function getPendingOrdersWithItemsAndDeliveryUser(Request $request, $id)
    // {
    //     $deliveryUser = DeliveryUser::find($id);
    //     if (!$deliveryUser) {
    //         return response()->json(['success' => false, 'message' => 'Delivery user not found'], 404);
    //     }

    //     $totalCashCollected = $deliveryUser->total_cash_collected;
    //     $totalCashDeposited = $deliveryUser->total_cash_deposited;

    //     $cashDifference = $totalCashCollected - $totalCashDeposited;

    //     $orders = Order::
    //         leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
    //         ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
    //         ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
    //         ->where('orders.delivery_status', 'pending')
    //         ->where(function ($query) use ($id, $cashDifference) {
    //             $query->where('delivery_tracking.delivery_user_id', $id)
    //                 ->orWhereNull('delivery_tracking.delivery_user_id');

    //             if ($cashDifference >= 1000) {
    //                 $query->whereNotNull('delivery_tracking.delivery_user_id');
    //             }
    //         })
    //         ->orderBy('orders.id', 'desc')
    //     ;

    //     $orders = $orders->select(
    //         'orders.id as order_id',
    //         'orders.user_id',
    //         'orders.total_amount',
    //         'orders.status',
    //         'orders.payment_method',
    //         'orders.delivery_status as order_status',
    //         'orders.payment_status',
    //         'orders.order_date',
    //         'delivery_tracking.id as delivery_tracking_id',
    //         'delivery_tracking.order_status as delivery_status',
    //         'delivery_tracking.delivery_user_id',
    //         'delivery_user.name as delivery_person_name',
    //         'delivery_user.contact as delivery_person_contact',
    //         'user_addresses.name as user_address_name',
    //         'user_addresses.contact as user_address_contact',
    //         'user_addresses.house_address as user_address_house',
    //         'user_addresses.street_address as user_address_street',
    //         'user_addresses.landmark as user_address_landmark',
    //         'user_addresses.city as user_address_city',
    //         'user_addresses.state as user_address_state',
    //         'user_addresses.country as user_address_country',
    //         'user_addresses.pincode as user_address_pincode',
    //         'user_addresses.latitude as user_latitude',
    //         'user_addresses.longitude as user_longitude'
    //     )
    //         ->get();

    //     foreach ($orders as $order) {
    //         if ($order->delivery_user_id == $id) {
    //             $calculateDistancetime = $this->calculateDistance(
    //                 $order->user_latitude,
    //                 $order->user_longitude,
    //                 $deliveryUser->latitude,
    //                 $deliveryUser->longitude
    //             );
    //             if ($calculateDistancetime <= 0) {
    //                 $time = 10;
    //                 $order->calculatedTime = $time;
    //             } else {
    //                 $baseTime = 10;
    //                 $additionalTime = 5;

    //                 $additionalDistance = max(0, $calculateDistancetime - 1);

    //                 $time = $baseTime + ($additionalDistance * $additionalTime);
    //                 $order->calculatedTime = $time;
    //             }

    //         } else {
    //             $order->calculatedTime = 0;
    //         }
    //     }

    //     return response()->json(['success' => true, 'data' => $orders]);
    // }

    public function getPendingOrdersWithItemsAndDeliveryUser(Request $request, $id)
    {
        $deliveryUser = DeliveryUser::find($id);
        if (!$deliveryUser) {
            return response()->json(['success' => false, 'message' => 'Delivery user not found'], 404);
        }

        $totalCashCollected = $deliveryUser->total_cash_collected;
        $totalCashDeposited = $deliveryUser->total_cash_deposited;
        $cashDifference = $totalCashCollected - $totalCashDeposited;

        $ordersQuery = Order::
            leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('orders.delivery_status', 'pending');

        if ($cashDifference >= 1000) {
            $ordersQuery->where('delivery_tracking.delivery_user_id', $id);
        } else {
            // If the cash difference is less than 1000, check the delivery user's current status
            $ordersQuery->where(function ($query) use ($id, $deliveryUser) {
                if ($deliveryUser->current_status === 'engaged') {
                    // If engaged, only show assigned orders
                    $query->where('delivery_tracking.delivery_user_id', $id);
                } else {
                    // Otherwise, show assigned or unassigned orders
                    $query->where('delivery_tracking.delivery_user_id', $id)
                        ->orWhereNull('delivery_tracking.delivery_user_id');
                }
            });
        }

        $orders = $ordersQuery->select(
            'orders.id as order_id',
            'orders.user_id',
            'orders.total_amount',
            'orders.status',
            'orders.payment_method',
            'orders.delivery_status as order_status',
            'orders.payment_status',
            'orders.order_date',
            'delivery_tracking.id as delivery_tracking_id',
            'delivery_tracking.order_status as delivery_status',
            'delivery_tracking.delivery_user_id',
            'delivery_user.name as delivery_person_name',
            'delivery_user.contact as delivery_person_contact',
            'user_addresses.name as user_address_name',
            'user_addresses.contact as user_address_contact',
            'user_addresses.house_address as user_address_house',
            'user_addresses.street_address as user_address_street',
            'user_addresses.landmark as user_address_landmark',
            'user_addresses.city as user_address_city',
            'user_addresses.state as user_address_state',
            'user_addresses.country as user_address_country',
            'user_addresses.pincode as user_address_pincode',
            'user_addresses.latitude as user_latitude',
            'user_addresses.longitude as user_longitude'
        )
            ->orderBy('orders.id', 'desc')
            ->get();

        foreach ($orders as $order) {
            if ($order->delivery_user_id == $id) {
                $calculateDistancetime = $this->calculateDistance(
                    $order->user_latitude,
                    $order->user_longitude,
                    $deliveryUser->latitude,
                    $deliveryUser->longitude
                );
                if ($calculateDistancetime <= 0) {
                    $time = 10;
                    $order->calculatedTime = $time;
                } else {
                    $baseTime = 10;
                    $additionalTime = 5;
                    $additionalDistance = max(0, $calculateDistancetime - 1);
                    $time = $baseTime + ($additionalDistance * $additionalTime);
                    $order->calculatedTime = $time;
                }
            } else {
                $order->calculatedTime = 0;
            }
        }

        return response()->json(['success' => true, 'data' => $orders]);
    }


    public function getOrdersWithItemsAndDeliveryUser(Request $request, $id)
    {
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $orderStatus = $request->input('order_status');

        $orders = Order::
            leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('delivery_tracking.delivery_user_id', $id)
            ->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay]);

        if ($orderStatus) {
            $orders = $orders->where(function ($query) use ($orderStatus) {
                if ($orderStatus === 'cancelled' || $orderStatus === 'rejected') {
                    $query->whereIn('orders.delivery_status', ['cancelled', 'rejected'])
                        ->orWhereIn('delivery_tracking.order_status', ['cancelled', 'rejected']);
                } else if ($orderStatus == 'pending') {
                    $query->where('orders.delivery_status', $orderStatus);
                } else {
                    $query->where('orders.delivery_status', $orderStatus)
                        ->where('delivery_tracking.order_status', '<>', 'cancelled');
                }
            });
        }

        $orders = $orders->select(
            'orders.id as order_id',
            'orders.user_id',
            'orders.total_amount',
            'orders.status',
            'orders.payment_method',
            'orders.delivery_status as order_status',
            'orders.payment_status',
            'orders.order_date',
            'delivery_tracking.id as delivery_tracking_id',
            'delivery_tracking.order_status as delivery_status',
            'delivery_user.name as delivery_person_name',
            'delivery_user.contact as delivery_person_contact',
            'user_addresses.name as user_address_name',
            'user_addresses.contact as user_address_contact',
            'user_addresses.house_address as user_address_house',
            'user_addresses.street_address as user_address_street',
            'user_addresses.landmark as user_address_landmark',
            'user_addresses.city as user_address_city',
            'user_addresses.state as user_address_state',
            'user_addresses.country as user_address_country',
            'user_addresses.pincode as user_address_pincode',
            'user_addresses.latitude as user_latitude',
            'user_addresses.longitude as user_longitude'
        )
            ->get();

        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function getOrdersWithItemsAndDeliveryUserWithId($deliveryTrackingId)
    {
        $orders = Order::join('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->join('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->leftJoin('delivery_tracking_order', 'delivery_tracking.id', '=', 'delivery_tracking_order.delivery_tracking_id')
            ->where('delivery_tracking.id', $deliveryTrackingId)
            ->select(
                'orders.id as order_id',
                'orders.user_id',
                'orders.total_amount',
                'orders.status',
                'orders.payment_method',
                'orders.delivery_status as order_status',
                'orders.payment_status',
                'orders.order_date',
                'delivery_tracking.id as delivery_tracking_id',
                'delivery_tracking.order_status as delivery_status',
                'delivery_user.name as delivery_person_name',
                'delivery_user.contact as delivery_person_contact',
                'user_addresses.name as user_address_name',
                'user_addresses.contact as user_address_contact',
                'user_addresses.house_address as user_address_house',
                'user_addresses.street_address as user_address_street',
                'user_addresses.landmark as user_address_landmark',
                'user_addresses.city as user_address_city',
                'user_addresses.state as user_address_state',
                'user_addresses.country as user_address_country',
                'user_addresses.pincode as user_address_pincode',
                'user_addresses.latitude as user_latitude',
                'user_addresses.longitude as user_longitude',
                'latest_delivery_tracking_order.id as last_delivery_tracking_order_id',
                'latest_delivery_tracking_order.latitude as deliveryUserLatitude',
                'latest_delivery_tracking_order.longitude as deliveryUserLongitude',
            )
            ->leftJoinSub(
                function ($query) {
                    $query->from('delivery_tracking_order')
                        ->select('delivery_tracking_id', 'id', 'latitude', 'longitude')
                        ->whereIn('id', function ($subquery) {
                            $subquery->from('delivery_tracking_order')
                                ->selectRaw('MAX(id)')
                                ->groupBy('delivery_tracking_id');
                        });
                },
                'latest_delivery_tracking_order',
                'delivery_tracking.id',
                '=',
                'latest_delivery_tracking_order.delivery_tracking_id'
            )
            ->first();

        $distance = $this->calculateDistance(
            $orders->user_latitude,
            $orders->user_longitude,
            $orders->deliveryUserLatitude,
            $orders->deliveryUserLongitude,
        );

        if ($distance <= 0) {
            $time = 10;
        } else {
            $baseTime = 10;
            $additionalTime = 5;

            $additionalDistance = max(0, $distance - 1);

            $time = $baseTime + ($additionalDistance * $additionalTime);
        }

        return response()->json(['success' => true, 'data' => $orders, 'distance' => $distance, 'calculatedTime' => $time]);
    }


    public function getOrdersWithItemsAndDeliveryUserTotal(Request $request, $id)
    {

        $orderStatus = $request->input('order_status');

        $orders = Order::
            join('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->join('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('delivery_tracking.delivery_user_id', $id);

        if ($orderStatus) {
            $orders = $orders->where('orders.status', $orderStatus);
        }
        $orders = $orders->select(
            'orders.id as order_id',
            'orders.user_id',
            'orders.total_amount',
            'orders.status',
            'orders.payment_method',
            'orders.delivery_status as order_status',
            'orders.payment_status',
            'orders.order_date',
            'delivery_tracking.order_status as delivery_status',
            'delivery_user.name as delivery_person_name',
            'delivery_user.contact as delivery_person_contact',
            'user_addresses.name as user_address_name',
            'user_addresses.contact as user_address_contact',
            'user_addresses.house_address as user_address_house',
            'user_addresses.street_address as user_address_street',
            'user_addresses.landmark as user_address_landmark',
            'user_addresses.city as user_address_city',
            'user_addresses.state as user_address_state',
            'user_addresses.country as user_address_country',
            'user_addresses.pincode as user_address_pincode',
            'user_addresses.latitude as user_latitude',
            'user_addresses.longitude as user_longitude'
        )
            ->orderBy('delivery_tracking.id', 'desc')
            ->get();
        // ->groupBy('order_id');

        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function getCountsDeliveryUserTotal($id)
    {
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $pendingOrdersCount = DeliveryTracking::where('delivery_user_id', $id)
            ->where(function ($query) {
                $query->where('order_status', 'pending')
                    ->orWhere('order_status', 'shipped')
                    ->orWhere('order_status', 'out_for_delivery')
                    ->orWhere('order_status', 'accepted');
            })
            ->count();

        $pendingCash = DeliveryUser::select('total_cash_collected', 'total_cash_deposited')->where('id', $id)->get();

        $deliveredOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->where('order_status', 'delivered')->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();
        $cancelledOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->where('order_status', 'cancelled')->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();
        $totalOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();

        $deliveryUser = DeliveryUser::find($id);
        if (!$deliveryUser) {
            return response()->json(['error' => 'Delivery user not found'], 404);
        }

        // Calculate total incentives paid
        $paidIncentives = DeliveryTracking::join('orders', 'delivery_tracking.order_id', '=', 'orders.id')
            ->where('delivery_tracking.delivery_user_id', $id)
            ->selectRaw('SUM(CASE WHEN orders.incentive_status = "paid" THEN orders.incentive_amount ELSE 0 END) AS total_incentive_paid')
            ->value('total_incentive_paid');

        // Calculate total incentives unpaid
        $unpaidIncentives = DeliveryTracking::join('orders', 'delivery_tracking.order_id', '=', 'orders.id')
            ->where('delivery_tracking.delivery_user_id', $id)
            ->selectRaw('SUM(CASE WHEN orders.incentive_status = "unpaid" THEN orders.incentive_amount ELSE 0 END) AS total_incentive_unpaid')
            ->value('total_incentive_unpaid');


        return response()->json([
            'success' => true,
            'order_counts' => [
                'pending_orders' => $pendingOrdersCount,
                'cancelled_orders' => $cancelledOrdersCount,
                'delivered_orders' => $deliveredOrdersCount,
                'total_orders' => $totalOrdersCount
            ],
            'pending_cash' => [
                'total_cash_collected' => (float) $pendingCash[0]->total_cash_collected,
                'total_cash_deposited' => (float) $pendingCash[0]->total_cash_deposited,
                'total_cash_pending' => (float) $pendingCash[0]->total_cash_pending,
                // 'total_cash_sent_back' => (float) $pendingCash[0]->total_cash_to_send_back
            ],
            'total_incentive_paid' => (int) ($paidIncentives ?? 0),
            'total_incentive_unpaid' => (int) ($unpaidIncentives ?? 0),

        ]);
    }

    public function confirmDelivery(Request $request)
    {
        $order = Order::find($request->order_id);
        // Check if the order is COD
        if ($order->payment_method === 'cash_on_delivery') {
            $deliveryTracking = DeliveryTracking::where('order_id', $order->id)
                ->orderBy('created_at', 'desc')
                ->first();
            $deliveryUserId = $deliveryTracking->delivery_user_id;
            $amountCollected = $order->total_amount;
            $deliveryTracking->order_status = $request->status;
            $deliveryTracking->save();

            $deliveryUser = DeliveryUser::find($deliveryUserId);
            $deliveryUser->total_cash_collected += $amountCollected;
            $deliveryUser->delivery_status = 0;
            $deliveryUser->save();

            $order->status = 'completed';
            $order->delivery_status = $request->status;
            $order->payment_status = 'paid';

            if ($deliveryUser->incentive_type == "fixed") {
                $order->incentive_amount += $deliveryUser->incentive;
                $deliveryUser->total_incentive += $deliveryUser->incentive;
                $deliveryUser->pending_incentive += $deliveryUser->incentive;
            } else if ($deliveryUser->incentive_type == "percentage") {
                $order->incentive_amount += $deliveryUser->incentive;
                $deliveryUser->total_incentive += $deliveryUser->incentive;
                $deliveryUser->pending_incentive += $deliveryUser->incentive;

            }
            $order->save();
        } else {
            $deliveryTracking = DeliveryTracking::where('order_id', $order->id)->orderBy('created_at', 'desc')
                ->first();
            $deliveryUserId = $deliveryTracking->delivery_user_id;
            $deliveryTracking->order_status = $request->status;
            $deliveryTracking->save();

            $deliveryUser = DeliveryUser::find($deliveryUserId);
            $deliveryUser->delivery_status = 0;
            $deliveryUser->save();

            $order->status = 'completed';
            $order->delivery_status = $request->status;
            $order->payment_status = 'paid';

            if ($deliveryUser->incentive_type == "fixed") {
                $order->incentive_amount += $deliveryUser->incentive;
                $deliveryUser->total_incentive += $deliveryUser->incentive;
                $deliveryUser->pending_incentive += $deliveryUser->incentive;

            } else if ($deliveryUser->incentive_type == "percentage") {
                $order->incentive_amount += $deliveryUser->incentive;
                $deliveryUser->total_incentive += $deliveryUser->incentive;
                $deliveryUser->pending_incentive += $deliveryUser->incentive;

            }
            $order->save();
        }


        return response()->json(['success' => true, 'data' => null, 'message' => "Order delivered and cash updated successfully!"]);
    }

    // public function acceptOrRejectOrder(Request $request)
    // {
    //     if ($request->id > 0) {
    //         $deliveryTracking = DeliveryTracking::find($request->id);

    //         if ($deliveryTracking) {
    //             $deliveryTracking->order_status = $request->status;
    //             $deliveryTracking->save();
    //             return response()->json(['status' => true, 'message' => 'Order status updated successfully.']);
    //         } else {
    //             return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
    //         }
    //     } else {
    //         $check = DeliveryTracking::where(['order_id', $request->order_id])->orderBy('id', 'desc');
    //         if ($check->count() == 0) {
    //             $deliveryTracking = new DeliveryTracking();
    //             $deliveryTracking->order_id = $request->order_id;
    //             $deliveryTracking->delivery_user_id = $request->delivery_user_id;
    //             $deliveryTracking->order_status = $request->status;
    //             $deliveryTracking->status = 'assigned';
    //             $deliveryTracking->assigned_at = now();
    //             $deliveryTracking->save();

    //             $deliveryUser = DeliveryUser::where('id', $request->delivery_user_id)->first();
    //             $deliveryUser->current_status = 'engaged';
    //             $deliveryUser->save();

    //             return response()->json(['status' => true, 'message' => 'New delivery tracking created successfully.']);
    //         } else {
    //             return response()->json(['status' => false, 'message' => 'Order accepted by someone else.']);
    //         }
    //     }
    // }

    public function acceptOrRejectOrder(Request $request)
    {
        if ($request->id > 0) {
            $deliveryTracking = DeliveryTracking::find($request->id);

            if ($deliveryTracking) {
                $deliveryTracking->order_status = $request->status;
                $deliveryTracking->save();

                if ($request->status === 'rejected') {
                    $deliveryUser = DeliveryUser::find($deliveryTracking->delivery_user_id);
                    if ($deliveryUser) {
                        if ($request->status == 'rejected') {
                            $deliveryUser->current_status = 'free';
                            $deliveryUser->save();
                        } else {
                            $deliveryUser->current_status = 'engaged';
                            $deliveryUser->save();
                        }
                    }
                }

                return response()->json(['status' => true, 'message' => 'Order status updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
            }
        } else {
            $check = DeliveryTracking::where('order_id', $request->order_id)
                ->orderBy('id', 'desc')
                ->first();

            if (!$check || ($check && $check->order_status === 'rejected')) {
                $deliveryTracking = new DeliveryTracking();
                $deliveryTracking->order_id = $request->order_id;
                $deliveryTracking->delivery_user_id = $request->delivery_user_id;
                $deliveryTracking->order_status = $request->status;
                $deliveryTracking->status = 'assigned';
                $deliveryTracking->assigned_at = now();
                $deliveryTracking->save();

                $deliveryUser = DeliveryUser::find($request->delivery_user_id);
                if ($deliveryUser) {
                    if ($request->status == 'rejected') {
                        $deliveryUser->current_status = 'free';
                        $deliveryUser->save();
                    } else {
                        $deliveryUser->current_status = 'engaged';
                        $deliveryUser->save();
                    }
                }

                return response()->json(['status' => true, 'message' => 'New delivery tracking created successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Order accepted by someone else.']);
            }
        }
    }
    public function deliveredOrderByDeliveryUser($id)
    {
        $deliveredOrder = DeliveryTracking::
            select(
                'delivery_tracking.id as delivery_tracking_id',
                'delivery_tracking.order_id as order_id',
                'delivery_tracking.delivery_user_id as delivery_user_id',
                'delivery_tracking.order_status as order_status',
                'delivery_tracking.assigned_at as assigned_at',
                'users.name as user_name',
                'users.id as user_id',
                'orders.total_amount as order_total_amount'
            )
            ->join('orders', 'delivery_tracking.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('delivery_tracking.order_status', 'delivered')
            ->where('delivery_tracking.delivery_user_id', $id)->get();

        return response()->json(['status' => true, 'message' => 'Delivered Orders.', 'data' => $deliveredOrder]);
    }

    public function verifyOrderOtp(Request $request)
    {
        $orderData = Order::where('id', $request->order_id)->first();

        if ($orderData->otp == $request->otp) {
            return response()->json(['status' => true, 'message' => 'Otp verified successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Incorrect Otp.']);
        }
    }
}