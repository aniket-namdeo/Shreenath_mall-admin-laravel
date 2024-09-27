<?php

namespace App\Http\Controllers\cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CashierOrders;
use App\Models\Order_items;
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
    
    public function pickedupList()
    {
        $page_name = 'orders/pickedup-list';
        $current_page = 'pickedup-list';
        $page_title = 'Manage Orders';

        $cashier_id = session('user_id');

        $orderList = CashierOrders::select('cashier_orders.*','orders.total_amount','orders.payment_status','orders.payment_method','orders.order_date','orders.payment_status')->leftJoin('orders','orders.id','cashier_orders.order_id')->where(array('cashier_id'=>$cashier_id))->orderBy('id', 'desc')->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'orderList'));
    }


    public function show($id)
    {
        $page_name = 'orders/details';
        $current_page = 'orders-list';
        $page_title = 'Manage Orders';

        $order_details = Order::select('orders.*','user_addresses.name','user_addresses.contact','user_addresses.address_type','user_addresses.house_address','user_addresses.street_address','user_addresses.landmark','user_addresses.city','user_addresses.state','user_addresses.pincode')->leftJoin('user_addresses','user_addresses.id','orders.address_id')->where(array('orders.id'=>$id))->get();

        $order_items = Order_items::select('order_items.*','product.product_name as product_name','product.image_url1 as product_image','product.sku as product_sku','product.product_code as product_code')->leftJoin('product','product.id','order_items.product_id')->where(array('order_id'=>$id))->get();
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'order_details', 'order_items'));
    }

}
