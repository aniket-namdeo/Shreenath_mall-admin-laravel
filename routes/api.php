<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\CashDepositController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DeliveryUserController;
use App\Http\Controllers\Api\OfferSliderController;
use App\Http\Controllers\Api\AssignProductTagController;
use App\Http\Controllers\Api\CustomerSupportController;
use App\Http\Controllers\Api\DeliveryTrackingOrderController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\OrderQueueController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// users
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/change-password', [AuthController::class, 'updatePassword']);

Route::post('/update-password', [AuthController::class, 'changePassword']);
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
Route::get('/categories/{id}', [CategoryController::class, 'getCategoryWithSubcategories']);


// products
Route::get('/product', [ProductController::class, 'getProduct']);

Route::post('/products', [ProductController::class, 'getProductByCategory'])->name('products.byCategory');

Route::get('/products/{id}', [ProductController::class, 'getProductById'])->name('products.byId');

Route::post("searchProduct", [ProductController::class, 'searchProduct']);


Route::get("getBrands/{id}", [ProductController::class, 'getBrandsbyCategory']);

Route::get("getProductTags/{id}", [ProductController::class, 'getProductTagsByCategory']);

Route::get('/getProductsByTagBestSeller', [ProductController::class, 'getProductsByTagBestSeller']);

// orders
Route::post('/order', [OrderController::class, 'createOrder'])->name('order.create');

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);

Route::get('/order/{id}', [OrderController::class, 'getOrderDetail']);

Route::get('/latest-order/{userId}', [OrderController::class, 'getLastOrderDetail']);

Route::post('/save-remark', [OrderController::class, 'saveRemark']);

Route::get('/orderTrack/{id}', [OrderController::class, 'getOrderDetailDeliveryUser']);

Route::post('/order-payment/{id}', [OrderController::class, 'paymentStatusUpdate']);

Route::post('/cancel-order/{id}', [OrderController::class, 'cancelOrder']);

Route::post('/cancel-order-item/{id}', [OrderController::class, 'cancelOrdersItems'])->name('order-items.cancel');

Route::post('/orderRate/{id}', [OrderController::class, 'orderRating']);

Route::get('/delivery-user/{id}/pendingorders', [OrderController::class, 'getPendingOrdersWithItemsAndDeliveryUser']);

Route::get('/delivery-user/{id}/orders', [OrderController::class, 'getOrdersWithItemsAndDeliveryUser']);

Route::get('/delivery-user/{id}/overall-orders', [OrderController::class, 'getOrdersWithItemsAndDeliveryUserTotal']);

Route::get('/delivery-user/{id}/ordercounts', [OrderController::class, 'getCountsDeliveryUserTotal']);

Route::get('/delivery-order/{id}', [OrderController::class, 'getOrdersWithItemsAndDeliveryUserWithId']);

Route::post('/accept-order', [OrderController::class, 'acceptOrRejectOrder']);

Route::post('/confirm-order-delivery', [OrderController::class, 'confirmDelivery']);

Route::get('/getDeviceId', [OrderController::class, 'getDeviceId']);

Route::get('/deliveredOrderByDeliveryUser/{id}', [OrderController::class, 'deliveredOrderByDeliveryUser']);

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

Route::get("/getDeliveryUser/{id}", [DeliveryUserController::class, "getUser"]);

Route::get('/getReferralCode/{id}', [DeliveryUserController::class, 'getQrReferralCode']);

Route::get('/getReferralList/{referrer_id}', [DeliveryUserController::class, 'listReferrals']);


Route::post('/update-delivery-profile/{id}', [DeliveryUserController::class, 'updateProfile']);

Route::post('/scan-qr', [DeliveryUserController::class, 'scanQr']);

Route::get('/incentiveList/{id}', [DeliveryUserController::class, 'incentiveList']);

Route::post('/sendDepositOtp', [CashDepositController::class, 'sendOtp']);

Route::post('/verifyDepositOtp', [CashDepositController::class, 'verifyOtp']);

Route::post('/storeDeposit', [CashDepositController::class, 'storeDeposit']);
// new request for storeDepost
Route::post('/deposit-request', [CashDepositController::class, 'store']);

// get cash deposit
Route::get('/getCashDeposit/{id}', [CashDepositController::class, 'getCashDeposit']);

Route::post('/deposit-confirm', [CashDepositController::class, 'updateCashDeposit']);

// state country 

Route::get('/state/{country_id}', [AuthController::class, 'state']);

Route::get('/city/{name}', [AuthController::class, 'city']);

// offer slider 

Route::get('/offerSlider', [OfferSliderController::class, 'getOfferSlider']);

// assigned tag products

Route::get('/assignedTagProducts/{tagId}', [AssignProductTagController::class, 'getAssignedTagProducts']);

Route::get('/getTagsProduct', [AssignProductTagController::class, 'getTagsProduct']);


// Delivery Tracking Order

Route::post('/createTrackingOrder', [DeliveryTrackingOrderController::class, 'createTrackingOrder']);

Route::post('/updateTrackingOrder', [DeliveryTrackingOrderController::class, 'updateTrackingOrder']);

Route::get('/getOrderTracking/{orderId}', [DeliveryTrackingOrderController::class, 'getOrderTracking']);

// Customer Support
Route::post('/customer-support', [CustomerSupportController::class, 'store']);

// calculate Distance

Route::post('/getDistanceTime', [OrderController::class, 'getDistanceTime']);

Route::post('/verifyOrderOtp', [OrderController::class, 'verifyOrderOtp']);


// Rate Order
Route::post('/ratings/submit', [RatingController::class, 'submitRatings']);

Route::get('/ratings/{order_id}/{user_id}', [RatingController::class, 'getRatings']);


Route::post('/assign-orders', [OrderQueueController::class, 'assignOrdersToDeliveryUsers']);

Route::get('/getMallLocation', [AuthController::class, 'getAdminDetails']);

Route::post('/auto-reject', [OrderQueueController::class, 'autoReject']);