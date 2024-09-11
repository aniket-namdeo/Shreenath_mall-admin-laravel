<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DeliveryUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferSliderController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TermsAndConditionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'login'])->name('login');


Route::get('/register', [AuthController::class, 'register'])->name('register.show');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.store');

Route::get('/login', [AuthController::class, 'login'])->name('login.show');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.user');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.show');
    Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('user.post');

    // users from admin panel
    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'AddUser'])->name('add-user.show');
    Route::post('/add-user', [App\Http\Controllers\UserController::class, 'AddUserPost'])->name('add-user.store');
    Route::get('/users-list', [App\Http\Controllers\UserController::class, 'UserList'])->name('users-list.list');
    Route::get('/users-edit/{id}', [App\Http\Controllers\UserController::class, 'userEdit'])->name('userlist.edit');
    Route::post('/users-update/{id}', [App\Http\Controllers\UserController::class, 'userUpdate'])->name('users-update.update');

    Route::get('/add-delivery-user', [App\Http\Controllers\DeliveryUserController::class, 'AddDeliveryUser'])->name('add-deliveryUser.show');
    Route::post('/add-deliveryUser', [App\Http\Controllers\DeliveryUserController::class, 'AddDeliveryUserPost'])->name('add-deliveryUser.store');
    Route::get('/delivery-user-list', [App\Http\Controllers\DeliveryUserController::class, 'DeliveryUserList'])->name('deliveryUser-list.list');
    Route::get('/delivery-user-edit/{id}', [App\Http\Controllers\DeliveryUserController::class, 'deliveryUserEdit'])->name('delivery-user.edit');
    Route::post('/deliveryUser-update/{id}', [App\Http\Controllers\DeliveryUserController::class, 'DeliveryUserUpdate'])->name('deliveryUser-update.update');
    Route::post('/deliveryUserdoc-update/{id}', [App\Http\Controllers\DeliveryUserController::class, 'DeliveryUserDocupdate'])->name('deliveryUser-doc-update.update');
    // Route::post('/update-basic/{id}', [DeliveryUserBasicController::class, 'update'])->name('deliveryUser.updateBasic');

    // category
    Route::get('/add-category', [App\Http\Controllers\CategoryController::class, 'show'])->name('add-category.show');
    Route::get('/add-subcategory', [App\Http\Controllers\CategoryController::class, 'subCategoryShow'])->name('add-subcategory.show');
    Route::post('/add-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('add-category.store');
    Route::get('/category-list', [App\Http\Controllers\CategoryController::class, 'categorylist'])->name('category-list.show');
    Route::get('/subcategory-list', [App\Http\Controllers\CategoryController::class, 'subcategorylist'])->name('subcategory-list.show');
    Route::get('/edit-category/{id}', [CategoryController::class, 'categoryEdit'])->name('category-edit.edit');
    Route::post('/update-category/{id}', [CategoryController::class, 'categoryUpdate'])->name('update-category.update');

    // product
    Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'show'])->name('add-product.show');
    Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'store'])->name('add-product.store');
    Route::get('/product-list', [App\Http\Controllers\ProductController::class, 'productlist'])->name('product-list.show');
    Route::get('/edit-product/{id}', [ProductController::class, 'productEdit'])->name('product-edit.edit');
    Route::post('/update-product/{id}', [ProductController::class, 'productUpdate'])->name('update-product.update');
    Route::get('/product-delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // bulk upload products
    Route::get('/bulk-upload-product', [ProductController::class, 'bulkAddProduct'])->name('products.bulkAddProduct');

    Route::post('/products/bulk-upload-product', [ProductController::class, 'storeBulk'])->name('products.bulk-upload');
    Route::get('/products/sample-file', [ProductController::class, 'downloadSampleFile'])->name('products.sample-file');

    // order
    Route::get('/order-list', [App\Http\Controllers\OrderController::class, 'getOrders'])->name('order-list.show');
    Route::get('/edit-order/{id}', [OrderController::class, 'orderEdit'])->name('order-edit.edit');

    Route::post('/update-order/{id}', [OrderController::class, 'orderUpdate'])->name('update-order.update');
    Route::get('/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::get("/cancel-order-item/{id}", [OrderController::class, 'cancelOrdersItems'])->name('order-item.cancel');

    // order assigned
    Route::post('/order/assign', [OrderController::class, 'assignOrder'])->name('order.assign');
    Route::get('/admin/check-order-assignment', [OrderController::class, 'checkOrderAssignment'])->name('order.checkAssignment');


    // privacypolicy
    Route::get('/add-privacypolicy', [App\Http\Controllers\PrivacyPolicyController::class, 'show'])->name('privacypolicy.show');
    Route::post('/add-privacypolicy', [App\Http\Controllers\PrivacyPolicyController::class, 'store'])->name('privacypolicy.store');
    Route::get('/privacypolicy-list', [App\Http\Controllers\PrivacyPolicyController::class, 'list'])->name('privacypolicy-list.list');
    Route::get('/edit-privacypolicy/{id}', [App\Http\Controllers\PrivacyPolicyController::class, 'privacypolicyEdit'])->name('privacypolicy.edit');
    Route::post('/privacypolicy-update/{id}', [App\Http\Controllers\PrivacyPolicyController::class, 'privacypolicyUpdate'])->name('update-privacypolicy.update');

     // terms and condition
     Route::get('/add-terms_and_condition', [App\Http\Controllers\TermsAndConditionController::class, 'show'])->name('terms_and_condition.show');
     Route::post('/add-terms_and_condition', [App\Http\Controllers\TermsAndConditionController::class, 'store'])->name('terms_and_condition.store');
     Route::get('/terms_and_condition-list', [App\Http\Controllers\TermsAndConditionController::class, 'list'])->name('terms_and_condition-list.list');
     Route::get('/edit-terms_and_condition/{id}', [App\Http\Controllers\TermsAndConditionController::class, 'terms_and_conditionEdit'])->name('terms_and_condition.edit');
     Route::post('/terms_and_condition-update/{id}', [App\Http\Controllers\TermsAndConditionController::class, 'terms_and_conditionUpdate'])->name('update-terms_and_condition.update');

    // aboutus
    Route::get('/add-aboutus', [App\Http\Controllers\AboutUsController::class, 'show'])->name('aboutus.show');
    Route::post('/add-aboutus', [App\Http\Controllers\AboutUsController::class, 'store'])->name('aboutus.store');
    Route::get('/aboutus-list', [App\Http\Controllers\AboutUsController::class, 'list'])->name('aboutus-list.list');
    Route::get('/edit-aboutus/{id}', [App\Http\Controllers\AboutUsController::class, 'aboutusEdit'])->name('aboutus.edit');
    Route::post('/aboutus-update/{id}', [App\Http\Controllers\AboutUsController::class, 'aboutusUpdate'])->name('update-aboutus.update');

    // coupon
    Route::get('/add-coupon', [App\Http\Controllers\CouponController::class, 'show'])->name('coupon.show');
    Route::post('/add-coupon', [App\Http\Controllers\CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupon-list', [App\Http\Controllers\CouponController::class, 'list'])->name('coupon-list.list');
    Route::get('/edit-coupon/{id}', [App\Http\Controllers\CouponController::class, 'couponEdit'])->name('coupon.edit');
    Route::post('/coupon-update/{id}', [App\Http\Controllers\CouponController::class, 'couponUpdate'])->name('update-coupon.update');


    // brand
    Route::get('/add-brand', [App\Http\Controllers\BrandController::class, 'show'])->name('add-brand.show');
    Route::post('/add-brand', [App\Http\Controllers\BrandController::class, 'store'])->name('add-brand.store');
    Route::get('/brand-list', [App\Http\Controllers\BrandController::class, 'list'])->name('brand-list.list');
    Route::get('/edit-brand/{id}', [App\Http\Controllers\BrandController::class, 'brandEdit'])->name('brand.edit');
    Route::post('/brand-update/{id}', [App\Http\Controllers\BrandController::class, 'brandUpdate'])->name('update-brand.update');

    // offer Slider
    Route::get('/offer-slider', [App\Http\Controllers\OfferSliderController::class, 'show'])->name('add-offer-slider.show');
    Route::post('/offer-slider', [App\Http\Controllers\OfferSliderController::class, 'store'])->name('add-offer-slider.store');
    Route::get('/offer-slider-list', [App\Http\Controllers\OfferSliderController::class, 'list'])->name('offer-slider-list.list');
    Route::get('/edit-offer-slider/{id}', [App\Http\Controllers\OfferSliderController::class, 'offerSliderEdit'])->name('offer-slider.edit');
    Route::post('/offer-slider-update/{id}', [App\Http\Controllers\OfferSliderController::class, 'offerSliderUpdate'])->name('update-offer-slider.update');

    // state city
    Route::get('state/{country_id}', [App\Http\Controllers\UserController::class, 'state']);
    Route::get('city/{state_id}', [App\Http\Controllers\UserController::class, 'city']);

    // Sales
    Route::get('/listSales', [App\Http\Controllers\SalesController::class, 'listSales']);
    Route::get('/deposit-request', [App\Http\Controllers\SalesController::class, 'listRequest'])->name('deposit-request.list');
    Route::get('/deposit-requests/{id}/edit', [App\Http\Controllers\SalesController::class, 'editRequest'])->name('deposit_requests.edit');
    Route::post('/deposit-requests/{id}', [App\Http\Controllers\SalesController::class, 'updateRequest'])->name('deposit_requests.update');

    // tags
    Route::get('/add-tag', [App\Http\Controllers\TagController::class, 'show'])->name('add-tag.show');
    Route::post('/add-tag', [App\Http\Controllers\TagController::class, 'store'])->name('add-tag.store');
    Route::get('/tag-list', [App\Http\Controllers\TagController::class, 'list'])->name('tag-list.list');
    Route::get('/edit-tag/{id}', [App\Http\Controllers\TagController::class, 'tagEdit'])->name('tag.edit');
    Route::post('/tag-update/{id}', [App\Http\Controllers\TagController::class, 'tagUpdate'])->name('update-tag.update');

    Route::get('/productTagAssign-list/{id}', [App\Http\Controllers\TagController::class, 'productTagAssign'])->name('productTagAssign.list');

    Route::post('/productTagAssign', [App\Http\Controllers\TagController::class, 'AssignProductTags'])->name('productTagAssign.store');


    // Incentive

    Route::get('/incentive_list', [App\Http\Controllers\SalesController::class, 'incentive'])->name('incentive.show');
    Route::post('/incentive-pay', [App\Http\Controllers\SalesController::class, 'incentivePay'])->name('incentive.store');

    // Referral list
    Route::get('/referral_list', [App\Http\Controllers\ReferralListController::class, 'referralList'])->name('referralList.show');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
