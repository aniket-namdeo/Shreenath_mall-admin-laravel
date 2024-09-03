<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_items;
use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getOrders()
    {
        $page_name = 'order/list';
        $current_page = 'order-list';
        $page_title = 'Manage Orders';

        $orderList = Order::select('orders.*', 'users.name as user_name', 'delivery_user.name as delivery_user_name')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
            ->leftJoin('delivery_user', 'delivery_tracking.delivery_user_id', '=', 'delivery_user.id')
            ->where('users.user_type', '!=', 'Admin')
            ->orderBy('orders.id', 'desc')
            ->paginate(20);
        $deliveryUsers = DeliveryUser::where('is_blocked', 0)->where('status', 'verified')->get();

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'orderList', 'deliveryUsers'));
    }


    public function orderEdit($orderId)
    {
        $page_name = "order/edit";
        $page_title = "Manage Order";
        $current_page = "order";
        $details = Order::find($orderId);
        $order = Order::where('orders.id', $orderId)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->select(
                'orders.*',
                'users.name as user_name',
                'users.email as user_email',
                'user_addresses.house_address',
                'user_addresses.street_address',
                'user_addresses.landmark',
                'user_addresses.city',
                'user_addresses.state',
                'user_addresses.country',
                'user_addresses.pincode'
            )
            ->first();

        if (!$order) {
            return redirect()->route('admin.order.list')->with('error', 'Order not found');
        }
        $order->order_date = date('Y-m-d', strtotime($order->order_date));
        $order->delivery_date = date('Y-m-d', strtotime($order->delivery_date));

        $orderItems = Order::where('orders.id', $orderId)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('product', 'order_items.product_id', '=', 'product.id')
            ->select(
                'order_items.id',
                'order_items.product_id',
                'order_items.product_name',
                'order_items.product_sku',
                'order_items.quantity',
                'order_items.price',
                'order_items.isCancelled',
                'product.product_name as product_name',
            )
            ->get();

        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'order', 'orderItems'));
    }

    public function orderUpdate(Request $request, $orderId)
    {
        $validated = $request->validate([
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'delivery_status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'coupon_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_fee' => 'nullable|numeric',
        ]);

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        $order->update([
            'total_amount' => $request->input('total_amount'),
            'status' => $request->input('status'),
            'delivery_status' => $request->input('delivery_status'),
            'payment_method' => $request->input('payment_method'),
            'payment_status' => $request->input('payment_status'),
            // 'delivery_date' => $request->input('delivery_date'),
            'coupon_code' => $request->input('coupon_code'),
            'discount_amount' => $request->input('discount_amount'),
            'tax_amount' => $request->input('tax_amount'),
            'shipping_fee' => $request->input('shipping_fee'),
        ]);

        return redirect()->route('order-list.show')->with('success', 'Order updated successfully');
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
                return redirect()->back()->with('success', 'Order cancelled');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to cancel order and its items');
            }
        } else {
            return redirect()->back()->with('error', 'No order with this id');

        }
    }

    public function cancelOrdersItems($id)
    {
        $data = array('isCancelled' => 1);
        $result = Order_items::where(array('id' => $id))->update($data);
        if ($result > 0) {
            return redirect()->back()->with('success', 'Order Item cancelled');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }


    public function assignOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_user_id' => 'required|exists:delivery_user,id',
        ]);

        DeliveryTracking::where('order_id', $request->order_id)
            ->update(['status' => 'disabled']);

        DeliveryTracking::create([
            'order_id' => $request->order_id,
            'delivery_user_id' => $request->delivery_user_id,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $deliveryUser = DeliveryUser::where('id', $request->delivery_user_id)->first();
        $deliveryUser->current_status = 'free';
        $deliveryUser->save();

        return redirect()->back()->with('success', 'Order assigned successfully!');
    }


    public function checkOrderAssignment(Request $request)
    {
        $deliveryTracking = DeliveryTracking::where('order_id', $request->order_id)->first();

        if ($deliveryTracking) {
            $assignedUserName = DeliveryUser::find($deliveryTracking->delivery_user_id)->name;
            return response()->json(['assigned' => true, 'delivery_user_name' => $assignedUserName]);
        } else {
            return response()->json(['assigned' => false]);
        }
    }


}
