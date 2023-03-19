<?php

use App\Http\Controllers\Api\Driver\DriverController;
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
    Route::get('/order-details', [OrderController::class, 'orderDetails']);
    Route::get('/custodies', [OrderController::class, 'getCustodies']);
    Route::get('/custodies-details', [OrderController::class, 'getCustodyProducts']);
    Route::post('/drop-custodies', [OrderController::class, 'deliverCustody']);
    Route::get('/transfers-products', [OrderController::class, 'getTransferOrders']);
    Route::post('/received-transfer', [OrderController::class, 'receivedTransfer']);
    Route::post('/receive-transfer-from-store', [OrderController::class, 'receiveTransferFromStore']);


    Route::get('/driver-info', [DriverController::class, 'driverInfo']);
    Route::post('/update-info', [DriverController::class, 'UpdateDriver']);
    Route::post('/delete-driver', [DriverController::class, 'deactivateDriver']);

});

