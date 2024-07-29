<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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

    // category
    Route::get('/add-category', [App\Http\Controllers\CategoryController::class, 'show'])->name('add-category.show');
    Route::post('/add-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('add-category.store');
    Route::get('/category-list', [App\Http\Controllers\CategoryController::class, 'categorylist'])->name('category-list.show');
    Route::get('/edit-category/{id}', [CategoryController::class, 'categoryEdit'])->name('category-edit.edit');
    Route::post('/update-category/{id}', [CategoryController::class, 'categoryUpdate'])->name('update-category.update');


    // product
    Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'show'])->name('add-product.show');
    Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'store'])->name('add-product.store');
    Route::get('/product-list', [App\Http\Controllers\ProductController::class, 'productlist'])->name('product-list.show');
    Route::get('/edit-product/{id}', [ProductController::class, 'productEdit'])->name('product-edit.edit');
    Route::post('/update-product/{id}', [ProductController::class, 'productUpdate'])->name('update-product.update');
    Route::get('/product-delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // order
    Route::get('/order-list', [App\Http\Controllers\OrderController::class, 'getOrders'])->name('order-list.show');
    Route::get('/edit-order/{id}', [OrderController::class, 'orderEdit'])->name('order-edit.edit');

    Route::post('/update-order/{id}', [OrderController::class, 'orderUpdate'])->name('update-order.update');
    Route::get('/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::get("/cancel-order-item/{id}", [OrderController::class, 'cancelOrdersItems'])->name('order-item.cancel');


});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
