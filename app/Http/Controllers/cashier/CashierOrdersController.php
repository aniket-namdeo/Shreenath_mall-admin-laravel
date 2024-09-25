<?php

namespace App\Http\Controllers\cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CashierOrders;
use App\Models\DeliveryTracking;

class CashierOrdersController extends Controller
{
    public function index()
    {
        $page_name = 'orders/list';
        $current_page = 'orders-list';
        $page_title = 'Manage Orders';

        $orderList = Order::where(array('delivery_status'=>'pending','pickup_otp_status'=>0))->orderBy('id', 'asc')->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'orderList'));
    }

    public function pickedup(Request $request){

        $cashier_id = session('user_id');

        $delivery_user_id = DeliveryTracking::where(array('order_id'=>$request->order_id,'order_status'=>'accepted'))->first()->delivery_user_id;

        $data = array(
            'cashier_id'=>$cashier_id,
            'delivery_user_id'=>$delivery_user_id,
            'order_id'=>$request->order_id,
            'pickup_status'=>'pickedup',
        );

        $result = CashierOrders::create($data);
        
        Order::where(array('id'=>$request->order_id))->update(array('delivery_status'=>'shipped'));
        
        if($result->id > 0){
            return true;
        }else{
            return false;
        }

    }

}
