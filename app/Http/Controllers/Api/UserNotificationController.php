<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class UserNotificationController extends Controller
{
  public function send_notification(Request $request){

    $title = "Welcome To Shree Nath Mall";

    if($request->input('title') && $request->input('title') != ""){
        $title = $request->input('title');
    }

    $body = "Hello User Welcome To Shree Nath Mall";

    if($request->input('body') && $request->input('body') != ""){
        $body = $request->input('body');
    }

    if($request->input('user_id') != null && $request->input('user_id') > 0){

        $userData = User::where(array('id'=>$request->input('user_id'),'is_blocked'=>0))->select('id','name','deviceId')->first();

        $deviceIds = [$userData->deviceId];
    
        $title = 'Hello '.$userData->name;
    
    }else{
    
        $deviceIds = User::where(array('is_blocked'=>0))->pluck('deviceId')->filter()->all();

        $deviceIds = $deviceIds;

    }

    if($request->input('order_id') != null && $request->input('order_id') > 0){
    
        $orderDetails = Order::where(array('id'=>$request->input('order_id'),'user_id'=>$request->input('user_id')))->select('id','delivery_status')->first();

        $deviceIds = [$userData->deviceId];
        
        $body = 'You order has been '.$orderDetails->delivery_status.'.';
    
    }
    
    $data = ['screen' => 'order-details'];
    
    $image = null;

    $response = sendUserNotification($title, $body, $deviceIds, $image, $data);

    return response()->json(['deviceIds' => $deviceIds, 'response' => $response]);
  }
}
