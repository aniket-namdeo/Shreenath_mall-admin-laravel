<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CashDeposit;
use App\Models\DeliveryUser;
use Illuminate\Support\Str;

class SalesController extends Controller
{

    public function listSales(){
        $page_name = 'sales/list';
        $current_page = 'sales';
        $page_title = 'Sales';
    
        $data = CashDeposit::join('delivery_user', 'cash_deposit.delivery_user_id', '=', 'delivery_user.id')
            ->select('cash_deposit.*', 'delivery_user.name as delivery_user_name', 'delivery_user.email as delivery_user_email', 'delivery_user.total_cash_collected as totalCashCollected', 'delivery_user.total_cash_to_send_back as totalDepositAmount')
            ->get();

            return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'data'));
    }
    

}
