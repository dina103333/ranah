<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgetpasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['guest:admin']],function () {
        Route::get('/login', [LoginController::class,'getLoginForm'])->name('login');
        Route::post('/login', [LoginController::class,'login'])->name('login-form');

        Route::get('/forget-password',[ForgetpasswordController::class,'getResetPasswordForm'])->name('forget-password');

        Route::post('/send-otp',[ForgetpasswordController::class,'sendOtp'])->name('send-otp');
        Route::post('/otp-page',[ForgetpasswordController::class,'verifyOtpPage'])->name('verify-otp');
        Route::post('/verify-otp',[ForgetpasswordController::class,'verifyOtpCode'])->name('verify-otp');

        Route::post('/reset-password',[ForgetpasswordController::class,'NewPasswordPage'])->name('reset-password');
        Route::post('/new-password',[ForgetpasswordController::class,'resetPassword'])->name('new-password');
});

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['auth:admin']],function () {

        Route::get('/logout', [LoginController::class,'logout'])->name('logout');

        Route::get('/',[DashboardController::class,'index'])->name('dashboard');

        Route::resource('/officials',AdminController::class);
        Route::get('/admins',[AdminController::class,'getAdmins'])->name('admins');


        Route::resource('/roles',RoleController::class);
        // Route::get('/roles',[RoleController::class,'index'])->name('roles');
        Route::get('/create-role',[RoleController::class,'create'])->name('create-role');
        Route::post('/store-role',[RoleController::class,'store'])->name('store-role');
        Route::get('/update-role/{id}',[RoleController::class,'update'])->name('update-role');
        Route::get('/get-roles',[RoleController::class,'getRoles'])->name('get-roles');


        Route::resource('/categories',CategoryController::class);
        Route::get('/get-categories',[CategoryController::class,'getCategories'])->name('get-categories');

        Route::resource('/companies',CompanyController::class);
        Route::get('/get-companies',[CompanyController::class,'getcompanies'])->name('get-companies');


        Route::resource('/products',ProductController::class);
        Route::get('/get-products',[ProductController::class,'getProducts'])->name('get-products');
        Route::get('/get-categories/{company_id}',[ProductController::class,'getCompanyCategories'])->name('get-categories');
        Route::get('/change-quantity',[ProductController::class,'changeQuantityStatus'])->name('change-quantity');
        Route::get('/change-status',[ProductController::class,'changeStatus'])->name('change-status');
        Route::get('/update-product-quantity',[ProductController::class,'updateProductQuantity'])->name('update-product-quantity');
});
