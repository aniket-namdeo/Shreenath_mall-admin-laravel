<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractorCashier;

class ContractorCashierController extends Controller
{
    
    public function index(){
        
        $page_name = 'contractor-cashier\list';
        
        $current_page = 'add-category';
        
        $page_title = 'Add Category';
        
        $list = ContractorCashier::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));

    }

}
