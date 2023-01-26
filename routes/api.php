<?php

use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ShopTypeController;
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
Route::get('/areas', [AreaController::class, 'getAllAreas']);
Route::get('/shop-types', [ShopTypeController::class, 'getAllShopTypes']);
Route::post('/verify-otp-code', [ShopTypeController::class, 'verifyOtpCode']);
Route::middleware(['auth_api:sanctum'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

