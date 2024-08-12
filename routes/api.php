<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DeliveryUserController;

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
Route::post('/update-user/{id}', [AuthController::class, 'updateProfile']);
Route::get("/getUser/{id}", [AuthController::class, "getUser"]);

Route::post('/user-addresses', [AuthController::class, 'addAddress']);
Route::get('/user-addresses/{id}', [AuthController::class, 'getUserAddress']);


Route::get('/user-address/{id}', [AuthController::class, 'getParticularAddress']);

Route::post('user-addresses/{id}', [AuthController::class, 'addressUpdate']);
Route::delete('/user-addresses/{id}', [AuthController::class, 'deleteAddress']);

// category
Route::get('/category', [CategoryController::class, 'getCategory']);
Route::get('/sub-category', [CategoryController::class, 'getSubCategory']);

// products
Route::get('/product', [ProductController::class, 'getProduct']);

Route::post('/products', [ProductController::class, 'getProductByCategory'])->name('products.byCategory');

Route::get('/products/{id}', [ProductController::class, 'getProductById'])->name('products.byId');

Route::post("searchProduct", [ProductController::class, 'searchProduct']);


Route::get("getBrands/{id}", [ProductController::class, 'getBrandsbyCategory']);

Route::get("getProductTags/{id}", [ProductController::class, 'getProductTagsByCategory']);

// orders
Route::post('/order', [OrderController::class, 'createOrder'])->name('order.create');

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);

Route::get('/order/{id}', [OrderController::class, 'getOrderDetail']);

Route::post('/order-payment/{id}', [OrderController::class, 'paymentStatusUpdate']);

Route::post('/cancel-order/{id}', [OrderController::class, 'cancelOrder']);

Route::post('/cancel-order-item/{id}', [OrderController::class, 'cancelOrdersItems'])->name('order-items.cancel');

Route::post('/orderRate/{id}', [OrderController::class, 'orderRating']);

Route::get('/delivery-user/{id}/orders', [OrderController::class, 'getOrdersWithItemsAndDeliveryUser']);
Route::get('/delivery-user/{id}/overall-orders', [OrderController::class, 'getOrdersWithItemsAndDeliveryUserTotal']);

Route::get('/delivery-user/{id}/ordercounts', [OrderController::class, 'getCountsDeliveryUserTotal']);

Route::post('/confirm-order-delivery', [OrderController::class, 'confirmDelivery']);

// cart
Route::post('/cart', [CartController::class, 'addToCart']);

Route::get('/cart/{id}', [CartController::class, 'getCartItemsByUser']);

Route::post('/cart/{id}', [CartController::class, 'updateCartItem']);

Route::delete('/cart/{id}', [CartController::class, 'deleteCartItem']);

// aboutus

Route::get('/aboutus', [AboutUsController::class, 'getAboutUs']);

// privacy policy

Route::get('/privacypolicy', [PrivacyPolicyController::class, 'getPrivacyPolicy']);

// coupon

Route::get('/coupon', [CouponController::class, 'getCoupon']);
Route::post('/applyCoupon', [CouponController::class, 'applyCoupon']);


// deliverUser

Route::post('/delivery-login', [DeliveryUserController::class, 'Deliverylogin']);

Route::post('/update-delivery-profile/{id}', [DeliveryUserController::class, 'updateProfile']);