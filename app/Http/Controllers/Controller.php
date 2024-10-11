<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function index(){

        $page_name = "home/index";
        
        $page_title = "home";
        
        $current_page = "home";

        return view('frontend/pages/main', compact('page_name','page_title','current_page'));
    }
}
