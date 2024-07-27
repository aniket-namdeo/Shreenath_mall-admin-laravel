<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
        $page_name = 'dashboard/dashboard';
        $current_page = 'dashboard';
        $page_title = 'Dashboard';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }
}
