<?php

namespace App\Http\Controllers\cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryUser;
use App\Models\CashierCashCollect;

class CashCollectController extends Controller
{
    public function index()
    {
        $page_name = 'cash-collect/list';
        $current_page = 'cash-collect';
        $page_title = 'Manage Cash Collected';

        $orderList = CashierCashCollect::select('cashier_cash_collect.*','delivery_user.name','delivery_user.contact','delivery_user.email')->where(array('cashier_id'=>session('user_id')))->leftJoin('delivery_user','delivery_user.id','cashier_cash_collect.delivery_user_id')->orderBy('id', 'desc')->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'orderList'));
    }
    
    public function create()
    {
        $page_name = 'cash-collect/create';
        $current_page = 'cash-collect-add';
        $page_title = 'Manage Cash Collect';

        $delivery_user = DeliveryUser::where(array('user_type'=>'delivery_user'))->orderBy('name', 'desc')->get();
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'delivery_user'));
    }
    
    public function store(Request $request)
    {
        
        $cashier_id = session('user_id');

        $data = array('cashier_id'=>$cashier_id,'delivery_user_id'=>$request->delivery_user_id,'collected_amount'=>$request->collected_amount,'collected_status'=>'collected');
        
        $result = CashierCashCollect::create($data);
        
        if($result->id > 0){
            return redirect()->back()->with('success', 'Cash collected Successfully');
        }else{
            return redirect()->back()->with('error', 'Something Went Wrong');
        }

    }
}
