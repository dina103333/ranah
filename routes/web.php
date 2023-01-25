<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgetpasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\SupplierController;
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
    'middleware' => ['guest:admin']], function () {
    Route::get('/login', [LoginController::class, 'getLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login-form');

    Route::get('/forget-password', [ForgetpasswordController::class, 'getResetPasswordForm'])->name('forget-password');

    Route::post('/send-otp', [ForgetpasswordController::class, 'sendOtp'])->name('send-otp');
    Route::post('/otp-page', [ForgetpasswordController::class, 'verifyOtpPage'])->name('verify-otp');
    Route::post('/verify-otp', [ForgetpasswordController::class, 'verifyOtpCode'])->name('verify-otp');

    Route::post('/reset-password', [ForgetpasswordController::class, 'NewPasswordPage'])->name('reset-password');
    Route::post('/new-password', [ForgetpasswordController::class, 'resetPassword'])->name('new-password');
});

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['auth:admin']], function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/officials', AdminController::class);
    Route::delete('/multiAdminDelete', [AdminController::class, 'multiAdminDelete'])->name('delete_multiple');
    Route::get('/admins', [AdminController::class, 'getAdmins'])->name('admins');


    Route::resource('/roles', RoleController::class);
    // Route::get('/roles',[RoleController::class,'index'])->name('roles');
    Route::get('/create-role', [RoleController::class, 'create'])->name('create-role');
    Route::post('/store-role', [RoleController::class, 'store'])->name('store-role');
    Route::get('/update-role/{id}', [RoleController::class, 'update'])->name('update-role');
    Route::get('/get-roles', [RoleController::class, 'getRoles'])->name('get-roles');


    Route::resource('/categories', CategoryController::class);
    Route::get('/get-categories', [CategoryController::class, 'getCategories'])->name('get-categories');

    Route::resource('/companies', CompanyController::class);
    Route::get('/get-companies', [CompanyController::class, 'getcompanies'])->name('get-companies');

    Route::post('/products/export/', [ProductController::class, 'export'])->name('products.export');
    Route::resource('/products', ProductController::class);
    Route::get('/get-products', [ProductController::class, 'getProducts'])->name('get-products');
    Route::get('/get-categories/{company_id}', [ProductController::class, 'getCompanyCategories'])->name('get-categories');
    Route::get('/change-quantity', [ProductController::class, 'changeQuantityStatus'])->name('change-quantity');
    Route::get('/change-status', [ProductController::class, 'changeStatus'])->name('change-status');
    Route::get('/update-product-quantity', [ProductController::class, 'updateProductQuantity'])->name('update-product-quantity');

    Route::resource('/products',ProductController::class);
    Route::get('/get-products',[ProductController::class,'getProducts'])->name('get-products');
    Route::get('/get-categories/{company_id}',[ProductController::class,'getCompanyCategories'])->name('get-categories');
    Route::get('/change-quantity',[ProductController::class,'changeQuantityStatus'])->name('change-quantity');
    Route::get('/change-status',[ProductController::class,'changeStatus'])->name('change-status');
    Route::get('/update-product-quantity',[ProductController::class,'updateProductQuantity'])->name('update-product-quantity');

    Route::resource('/stores',StoreController::class);
    Route::get('/get-stores',[StoreController::class,'getStores'])->name('get-stores');
    Route::get('/get-store-products/{id}',[StoreController::class,'getStoreProducts'])->name('get-store-products');
    Route::get('/get-store-products-table/{id}',[StoreController::class,'getStoreProductsTable'])->name('get-store-products-table');
    Route::get('/edit-store-product/{id}/{store_id}',[StoreController::class,'editStoreProduct'])->name('edit-store-product');
    Route::post('/update-store-product/{id}',[StoreController::class,'updateStoreProduct'])->name('update-store-product');


    Route::resource('/receipts',ReceiptController::class);
    Route::get('/get-receipts',[ReceiptController::class,'getReceipts'])->name('get-receipts');
    Route::get('/receive-receipts/{id}',[ReceiptController::class,'receiveReceipt'])->name('receive-receipts');

    Route::post('/drivers/export/', [DriverController::class, 'export'])->name('drivers.export');
    Route::resource('/drivers', DriverController::class);
    Route::delete('/multiDriversDelete', [DriverController::class, 'multiDriversDelete']);
    Route::get('/get-drivers', [DriverController::class, 'getDrivers'])->name('get-drivers');

    Route::post('/sellers/export/', [SellerController::class, 'export'])->name('sellers.export');
    Route::resource('/sellers', SellerController::class);
    Route::delete('/multiSellersDelete', [SellerController::class, 'multiSellersDelete']);
    Route::get('/get-sellers', [SellerController::class, 'getSellers'])->name('get-sellers');


    Route::resource('/suppliers', SupplierController::class);
    Route::post('/suppliers/export/', [SupplierController::class, 'export'])->name('suppliers.export');
    Route::delete('/multiSellersDelete', [SupplierController::class, 'multiSuppliersDelete']);
    Route::get('/get-suppliers', [SupplierController::class, 'getSellers'])->name('get-suppliers');

    Route::resource('/shops', ShopController::class);

});
