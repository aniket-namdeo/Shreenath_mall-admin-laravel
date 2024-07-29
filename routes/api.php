<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// users
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/change-password', [AuthController::class, 'updatePassword']);

// Route::post('/update-password', [AuthController::class, 'changePassword']);
// Route::post('/update-user/{id}', [AuthController::class, 'updateProfile']);
// Route::get("/getUser/{id}", [AuthController::class,"getUser"]);

Route::post('/user-addresses', [AuthController::class, 'addAddress']);
Route::get('/user-addresses/{id}', [AuthController::class, 'getUserAddress']);
Route::post('user-addresses/{id}', [AuthController::class, 'addressUpdate']);
Route::delete('/user-addresses/{id}', [AuthController::class, 'deleteAddress']);

// category
Route::get('/category', [CategoryController::class, 'getCategory']);

// products
Route::get('/product', [ProductController::class, 'getProduct']);

Route::get('/products', [ProductController::class, 'getProductByCategory'])->name('products.byCategory');

// orders
Route::post('/order', [OrderController::class, 'createOrder'])->name('order.create');

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);

Route::post('/cancel-order/{id}', [OrderController::class, 'cancelOrder']);

Route::post('/cancel-order-item/{id}', [OrderController::class, 'cancelOrdersItems'])->name('order-items.cancel');

// cart
Route::post('/cart', [CartController::class, 'addToCart']);

Route::get('/cart/{id}', [CartController::class, 'getCartItemsByUser']);

Route::post('/cart/{id}', [CartController::class, 'updateCartItem']);

Route::delete('/cart/{id}', [CartController::class, 'deleteCartItem']);