<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index () {
        $page_name = 'dashboard/dashboard';
        $current_page = 'dashboard';
        $page_title = 'Dashboard';
        $cash_deposit = User::where('user_type', "Admin")->first();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'cash_deposit'));
    }
}
