<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/change-password', [AuthController::class, 'updatePassword']);

// Route::post('/update-password', [AuthController::class, 'changePassword']);

// Route::post('/update-user/{id}', [AuthController::class, 'updateProfile']);
// Route::get("/getUser/{id}", [AuthController::class,"getUser"]);


Route::get('/category', [CategoryController::class, 'getCategory']);

Route::get('/product', [ProductController::class, 'getProduct']);

Route::get('/products', [ProductController::class, 'getProductByCategory'])->name('products.byCategory');


Route::post('/order', [OrderController::class, 'createOrder'])->name('order.create');

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);

Route::post('/cancel-order/{id}',[OrderController::class, 'cancelOrder']);

Route::post('/cancel-order-item/{id}', [OrderController::class, 'cancelOrdersItems'])->name('order-items.cancel');
