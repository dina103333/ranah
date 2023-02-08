<?php

use App\Http\Controllers\Api\Driver\LoginController;

use App\Http\Controllers\Api\Driver\OrderController;

use App\Http\Controllers\Api\UserController;
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
Route::post('/login', [LoginController::class, 'login']);

Route::post('/verify-otp-code-reset', [LoginController::class, 'verifyOtpCode']);
Route::post('/reset-password', [LoginController::class, 'restPassword']);
Route::post('/forget-password', [LoginController::class, 'forgetPassword']);

Route::middleware(['auth_api:sanctum'])->group(function () {


    Route::get('/pending-orders', [OrderController::class, 'getPendingOrders']);
    Route::post('/delivered-order', [OrderController::class, 'deliveredOrder']);
    Route::post('/complete-order', [OrderController::class, 'completeOrder']);
    Route::post('/add-return', [OrderController::class, 'addReturn']);
    Route::get('/get-orders', [OrderController::class, 'getAllOrders']);
    Route::get('/order-details', [OrderController::class, 'getOrderProducts']);


    Route::get('/user-info', [UserController::class, 'getUserInfo']);
    Route::post('/update-info', [UserController::class, 'UpdateUser']);
    Route::post('/delete-user', [UserController::class, 'deactiveUser']);

});

