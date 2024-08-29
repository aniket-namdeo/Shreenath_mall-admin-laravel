<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\User_addresses;
use App\Models\Cart;
use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{

    public function getDeviceId()
    {
        // $deviceIds = DeliveryUser::pluck('deviceId')->values();
        $deviceIds = DeliveryUser::pluck('deviceId')->filter()->all();
        $title = 'New Order';
        $body = 'You got a new order.';
        // $deviceIds = DeliveryUser::pluck('deviceId')->values();
        // $deviceIds = ['f1rmJhPxRISdv4rczzb2-u:APA91bHehiZ-gwrQOROC3N6HuKQkl3zz3m9kFJW3r-LvBbISAya7ozxnF9OGKOCT_9ZWL9tsdh14EOJa61GTab4h-y-DhY6QYufGxkxDEX9jMNz17FsOWOXqCEKyTx-nKb7F0T5FNq0I',
        // 'eWm_ALF_Sh-jpWG5nRIVd2:APA91bEO_SOV9YnguSUGmq85b3W9Mk_hM4Ka6HyeKJO4W63FyQB-dIPbOn9vA9o_rEbRXqD0Q3dibW_KtyhpwuYkEF48BqftnYTVjvbNCwtXyZcynrcSmT3CvShK_YpwLrhDhHGjFuhd',
        // 'f6a4B_HiSk-zhjGJslzXWq:APA91bFQ3U1EKOiuvFPzg2Mt97N1fpESnyD23A6zbGfIMDZOBw0YlOd5j3rjTflECLj5Q9wN5U42crdSyBwCHgpvxVlCrCQC0JN2Dlgdp4OEHyN4ndhH7ovOyI7TTihJl8J4AnZiZ0f7'
        // ];
        // $deviceIds = ['eWm_ALF_Sh-jpWG5nRIVd2:APA91bEO_SOV9YnguSUGmq85b3W9Mk_hM4Ka6HyeKJO4W63FyQB-dIPbOn9vA9o_rEbRXqD0Q3dibW_KtyhpwuYkEF48BqftnYTVjvbNCwtXyZcynrcSmT3CvShK_YpwLrhDhHGjFuhd'];
        $image = null;

        $response = sendFirebaseNotification($title, $body, $deviceIds, $image);
        return response()->json(['deviceIds' => $deviceIds]);
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

            // $title = 'New Order';
            // $body = 'You got a new order.';
            // $deviceIds = DeliveryUser::pluck('deviceId')->values();
            // $image = null;

            $deviceIds = DeliveryUser::pluck('deviceId')->filter()->all();
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

            // $totalMrp = number_format($order->sum('product_mrp'), 2, '.', '');
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
                'items' => $items,
            ];
        });

        return response()->json(['orders' => $result->values()], 200);
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
                'latitide' => $orderData->latitude,
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
                'items' => $items,
                'delivery_user' => $deliveryUser,
                'user_detail' => $userDetail,
                'deliveryTrackingId' => $orderData->deliveryTrackingId
            ];
        });

        return response()->json(['orders' => $result->values()], 200);
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

    public function getPendingOrdersWithItemsAndDeliveryUser(Request $request, $id)
    {

        $orders = Order::
            leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->leftJoin('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('orders.delivery_status', 'pending')
            // ->where('delivery_tracking.delivery_user_id', $id);
            ->where(function ($query) use ($id) {
                $query->where('delivery_tracking.delivery_user_id', $id)
                    ->orWhereNull('delivery_tracking.delivery_user_id');
            })
            ->where(function ($query) use ($id) {
                // Get the total_cash_collected for the given delivery user
                $totalCashCollected = DeliveryUser::
                    where('id', $id)
                    ->value('total_cash_collected');
                
                // If total_cash_collected is 1000 or more, do not include orders without an assigned delivery user
                if ($totalCashCollected >= 1000) {
                    $query->whereNotNull('delivery_tracking.delivery_user_id');
                }
            });

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
        $orders = Order::
            // join('order_items', 'orders.id', '=', 'order_items.order_id')
            join('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->join('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where('delivery_tracking.id', $deliveryTrackingId);

        $orders = $orders->select(
            'orders.id as order_id',
            'orders.user_id',
            'orders.total_amount',
            'orders.status',
            'orders.payment_method',
            'orders.delivery_status as order_status',
            'orders.payment_status',
            'orders.order_date',
            // 'order_items.id as order_item_id',
            // 'order_items.product_id',
            // 'order_items.quantity',
            // 'order_items.price',
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

        $pendingCash = DeliveryUser::select('total_cash_collected', 'total_cash_to_send_back')->where('id', $id)->get();

        $deliveredOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->where('order_status', 'delivered')->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();
        $cancelledOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->where('order_status', 'cancelled')->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();
        $totalOrdersCount = DeliveryTracking::where('delivery_user_id', $id)->whereBetween('delivery_tracking.assigned_at', [$startOfDay, $endOfDay])->count();

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
                'total_cash_sent_back' => (float) $pendingCash[0]->total_cash_to_send_back
            ]
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
            $order->save();
        }


        return response()->json(['success' => true, 'data' => null, 'message' => "Order delivered and cash updated successfully!"]);
    }

    public function acceptOrRejectOrder(Request $request)
    {
        // $request->validate([
        //     'id' => 'required|integer',
        //     'status' => 'required'
        // ]);

        // $deliveryTracking = DeliveryTracking::where('id', $request->id)->first();

        // if ($deliveryTracking) {
        //     $deliveryTracking->order_status = $request->status;
        //     $deliveryTracking->save();
        //     return response()->json(['status' => true, 'message' => 'Order status updated successfully.']);
        // } else {
        //     return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
        // }

        if ($request->id > 0) {
            $deliveryTracking = DeliveryTracking::find($request->id);

            if ($deliveryTracking) {
                $deliveryTracking->order_status = $request->status;
                $deliveryTracking->save();
                return response()->json(['status' => true, 'message' => 'Order status updated successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
            }
        } else {
            $deliveryTracking = new DeliveryTracking();
            $deliveryTracking->order_id = $request->order_id;
            $deliveryTracking->delivery_user_id = $request->delivery_user_id;
            $deliveryTracking->order_status = $request->status;
            $deliveryTracking->status = 'assigned';
            $deliveryTracking->assigned_at = now();
            $deliveryTracking->save();

            return response()->json(['status' => true, 'message' => 'New delivery tracking created successfully.']);
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
}