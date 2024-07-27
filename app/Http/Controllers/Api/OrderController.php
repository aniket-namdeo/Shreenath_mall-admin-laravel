<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\order_items;
use App\Models\User_addresses;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'delivery_status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'address_id' => 'required',
            'coupon_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_fee' => 'nullable|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.product_name' => 'required|string',
            'items.*.product_sku' => 'required|string',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);


        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'delivery_status' => $request->delivery_status,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'order_date' => $request->order_date,
                'delivery_date' => $request->delivery_date,
                'address_id' => $request->address_id,
                'coupon_code' => $request->coupon_code,
                'discount_amount' => $request->discount_amount,
                'tax_amount' => $request->tax_amount,
                'shipping_fee' => $request->shipping_fee,
            ]);

            foreach ($request->items as $item) {
                order_items::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'product_sku' => $item['product_sku'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

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
                'order_items.product_name',
                'order_items.product_sku',
                'order_items.quantity',
                'order_items.price',
                'user_addresses.house_address',
                'user_addresses.street_address',
                'user_addresses.landmark',
                'user_addresses.city',
                'user_addresses.state',
                'user_addresses.country',
                'user_addresses.pincode'
            )
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
                    'product_name' => $item->product_name,
                    'product_sku' => $item->product_sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
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
        $checkData = order_items::find($id);
        if ($checkData) {
            $checkData->update([
                'isCancelled' => 1
            ]);
            return response()->json(['message' => 'Order Item cancelled'], 201);
        } else {
            return response()->json(['error' => 'No items with this order id'], 500);
        }
    }
}