<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgetpasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DiscountProductController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
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
    Route::get('/get-company-categories/{company_id}', [ProductController::class, 'getCompanyCategories'])->name('get-company-categories');
    Route::get('/change-quantity', [ProductController::class, 'changeQuantityStatus'])->name('change-quantity');
    Route::get('/change-status', [ProductController::class, 'changeStatus'])->name('change-status');
    Route::get('/update-product-quantity', [ProductController::class, 'updateProductQuantity'])->name('update-product-quantity');
    Route::get('/export-template', [ProductController::class, 'exportTemplate'])->name('export-template');
    Route::post('/save-imported-products', [ProductController::class, 'storePulckProducts'])->name('save-imported-products');
    Route::get('/create-imported-products', [ProductController::class, 'createImported'])->name('create-imported-products');


    Route::resource('/stores',StoreController::class);
    Route::get('/get-stores',[StoreController::class,'getStores'])->name('get-stores');
    Route::get('/get-store-products/{id}',[StoreController::class,'getStoreProducts'])->name('get-store-products');
    Route::get('/get-store-products-table/{id}',[StoreController::class,'getStoreProductsTable'])->name('get-store-products-table');
    Route::get('/edit-store-product/{id}/{store_id}',[StoreController::class,'editStoreProduct'])->name('edit-store-product');
    Route::post('/update-store-product',[StoreController::class,'updateStoreProduct'])->name('update-store-product');


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
    Route::get('/generate-qr/{seller_id}', [SellerController::class, 'generateQrCode'])->name('generate-qr');


    Route::resource('/suppliers', SupplierController::class);
    Route::post('/suppliers/export/', [SupplierController::class, 'export'])->name('suppliers.export');
    Route::delete('/multiSellersDelete', [SupplierController::class, 'multiSuppliersDelete']);
    Route::get('/get-suppliers', [SupplierController::class, 'getSellers'])->name('get-suppliers');

    Route::resource('/shops', ShopController::class);


    Route::resource('/areas', AreaController::class);
    Route::get('/get-areas', [AreaController::class, 'getAreas'])->name('get-areas');
    Route::delete('/multiAreasDelete', [AreaController::class, 'multiAreasDelete']);


    Route::resource('/shops', ShopController::class);
    Route::get('/get-shops', [ShopController::class, 'getShops'])->name('get-shops');
    Route::delete('/multiShopsDelete', [ShopController::class, 'multiShopsDelete']);


    Route::resource('/users', UserController::class);
    Route::get('/get-users', [UserController::class, 'getUsers'])->name('get-users');
    Route::get('/users-change-status', [UserController::class, 'changeStatus'])->name('users-change-status');
    Route::delete('/multiUsersDelete', [UserController::class, 'multiUsersDelete']);
    Route::post('/delete-points', [UserController::class, 'deletePoints']);

    Route::resource('/sliders', SliderController::class);
    Route::get('/get-sliders', [SliderController::class, 'getSliders'])->name('get-sliders');
    Route::delete('/multiSlidersDelete', [SliderController::class, 'multiSlidersDelete']);

    Route::get('/create-transfers/{store_id}', [TransferController::class, 'createTransferProduct'])->name('create-transfers');
    Route::get('/transfers/{store_id}', [TransferController::class, 'getStoreTransfers'])->name('transfers');
    Route::get('/get-transfers/{store_id}', [TransferController::class, 'getTransfers'])->name('get-transfers');
    Route::post('/save-transfers', [TransferController::class, 'saveTransferProduct'])->name('save-transfers');
    Route::post('/change-transfers', [TransferController::class, 'changeTransferStatus'])->name('change-transfers');
    Route::get('/transfer-products', [TransferController::class, 'getTransferProducts'])->name('transfer-products');

    Route::get('/edit-setting', [SettingController::class, 'edit'])->name('edit-setting');
    Route::post('/update-setting', [SettingController::class, 'update'])->name('update-setting');


    Route::resource('/orders', OrderController::class);
    Route::get('/get-orders', [OrderController::class, 'getOrders'])->name('get-orders');
    Route::delete('/multiOrdersDelete', [OrderController::class, 'multiOrdersDelete']);
    Route::post('/assign-driver', [OrderController::class, 'assignDriver'])->name('assign-driver');
    Route::post('/change-status-order', [OrderController::class, 'changeStatus'])->name('change-status-order');
    Route::post('/confirm-order', [OrderController::class, 'confirmOrder'])->name('confirm-order');
    Route::get('/print-bill/{order_id}', [OrderController::class, 'printBill'])->name('print-bill');
    Route::get('/store-users/{store_id}', [OrderController::class, 'getStorUsers'])->name('store-users');
    Route::get('/product-details/{product_id}', [OrderController::class, 'getProductDetails'])->name('product-details');
    Route::post('/deliver-order', [OrderController::class, 'deliveredOrder'])->name('deliver-order');
    Route::post('/direct-discount', [OrderController::class, 'addDirectDiscount'])->name('direct-discount');


    Route::resource('/notifications', NotificationController::class);
    Route::get('/get-notifications', [NotificationController::class, 'getNotifications'])->name('get-notifications');
    Route::post('/resend-notification', [NotificationController::class, 'resendNotification'])->name('resend-notification');


    Route::resource('/sms', SmsController::class);
    Route::get('/get-sms', [SmsController::class, 'getSms'])->name('get-sms');
    Route::post('/resend-sms', [SmsController::class, 'resendSms'])->name('resend-sms');


    Route::resource('/discounts', DiscountController::class);
    Route::get('/get-discounts', [DiscountController::class, 'getDiscounts'])->name('get-discounts');
    Route::post('/active-discounts', [DiscountController::class, 'convertToDirectOrder'])->name('active-discounts');


    Route::resource('/discountproducts', DiscountProductController::class);
    Route::get('/get-productdiscounts', [DiscountProductController::class, 'getProductDiscounts'])->name('get-productdiscounts');
    Route::get('/get-discount-store-products/{store_id}', [DiscountProductController::class, 'getStoreProducts'])->name('get-discount-store-products');
    Route::post('/convert-discounts', [DiscountProductController::class, 'convertToDirect'])->name('convert-discounts');
    Route::delete('/multiDiscountsDelete', [DiscountProductController::class, 'multiDiscountsDelete']);


    Route::resource('/points', PointController::class);
    Route::get('/get-points', [PointController::class, 'getPoints'])->name('get-points');


    Route::resource('/promos', PromoCodeController::class);
    Route::get('/get-promos', [PromoCodeController::class, 'getPromos'])->name('get-promos');
    Route::delete('/multiPromoDelete', [PromoCodeController::class, 'multiPromoDelete'])->name('multiPromoDelete');


    Route::get('/user-wallet/{user_id}', [WalletController::class, 'DisplayUserWallet'])->name('user-wallet');
    Route::get('/get-user-wallet/{wallet_id}', [WalletController::class, 'getUserWallet'])->name('get-user-wallet');
    Route::get('/edit-wallet-value/{wallet_id}', [WalletController::class, 'edit'])->name('edit-wallet-value');
    Route::put('/update-wallet-value/{wallet_id}', [WalletController::class, 'update'])->name('update-wallet-value');

});
