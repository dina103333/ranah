<?php

use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ShopTypeController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/general-setting', [GeneralController::class, 'generalSetting']);
Route::get('/contacts', [GeneralController::class, 'getContacts']);
Route::get('/areas', [AreaController::class, 'getAllAreas']);
Route::get('/cars', [AreaController::class, 'getAllCars']);
Route::get('/shop-types', [ShopTypeController::class, 'getAllShopTypes']);

Route::get('/get-categories', [CategoryController::class, 'getCategories']);
Route::get('/get-subcategories', [CategoryController::class, 'getSubCategory']);

Route::get('/get-companies', [CompanyController::class, 'getCompanies']);

Route::get('/get-products', [ProductController::class, 'getProducts']);
Route::get('/show-product', [ProductController::class, 'showProduct']);
Route::get('/get-search-products', [ProductController::class, 'SearchProducts']);
Route::get('/beast-selling-products', [ProductController::class, 'bestSellingProducts']);
Route::get('/sliders', [SliderController::class, 'getSliders']);

Route::post('/verify-otp-code-reset', [LoginController::class, 'verifyOtpCode']);
Route::post('/reset-password', [LoginController::class, 'restPassword']);


Route::post('/forget-password', [LoginController::class, 'forgetPassword']);

Route::middleware(['auth_api:sanctum'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/verify-otp-code', [LoginController::class, 'verifyOtpCode']);
    Route::post('/resent-otp', [LoginController::class, 'sendTextMessage']);


    Route::get('/get-auth-products', [ProductController::class, 'getProducts']);
    Route::get('/show-auth-product', [ProductController::class, 'showProduct']);
    Route::get('/get-auth-search-products', [ProductController::class, 'SearchProducts']);
    Route::post('/product_comment', [ProductController::class, 'addComment']);
    Route::get('/beast-selling-products-auth', [ProductController::class, 'bestSellingProducts']);


    Route::post('/add-cart-products', [CartController::class, 'addCartProducts']);
    Route::get('/get-cart-products', [CartController::class, 'getCartProducts']);
    Route::post('/remove-product', [CartController::class, 'removeCartProduct']);


    Route::post('/create-order', [OrderController::class, 'createOrder']);
    Route::post('/cancel-order', [OrderController::class, 'cancelOrder']);
    Route::get('/get-orders', [OrderController::class, 'getOrders']);
    Route::get('/order-details', [OrderController::class, 'getOrderProducts']);


    Route::get('/user-info', [UserController::class, 'getUserInfo']);
    Route::post('/update-info', [UserController::class, 'UpdateUser']);
    Route::post('/delete-user', [UserController::class, 'deactiveUser']);


    Route::post('/add-comment', [ComplaintController::class, 'addComplaint']);
});

