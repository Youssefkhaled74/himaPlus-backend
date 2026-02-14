<?php

use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\FavoriteController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\VendorAuthController;
use App\Http\Controllers\Front\VendorDashboardController;
use App\Http\Controllers\Front\VendorProductController;
use App\Http\Controllers\Front\VendorOrderController;
use App\Http\Controllers\Front\VendorRatingsController;
use App\Http\Controllers\Front\VendorNotificationsController;
use App\Http\Controllers\Front\VendorAnalyticsController;
use Illuminate\Support\Facades\Route;

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
// Language Switcher
Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');

Route::group(['middleware' => ['limitReq']], function(){
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
    Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contactUs');
    Route::get('/providers', [HomeController::class, 'providersPage'])->name('providers');
    Route::get('/products', [HomeController::class, 'products'])->name('products');
    Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
    Route::get('/categories/category/products/{id?}', [HomeController::class, 'categoryProducts'])->name('categoryProducts');
    Route::get('/categories/products/{id?}', [HomeController::class, 'product'])->name('product');
    Route::post('contact-us', [HomeController::class, 'storeContactUs'])->name('user/store/contact-us');
    
    Route::get('/user/login', [AuthController::class, 'loginForm'])->name('login');
    Route::get('/user/login', [AuthController::class, 'loginForm'])->name('user/loginForm');
    Route::post('/user/check/login', [AuthController::class, 'login'])->name('user/check/login');
    Route::post('user/register/store', [AuthController::class, 'register'])->name('user/register/store');
    
    Route::get('user/account-check/{id?}', [AuthController::class, 'accountCheckForm'])->name('user/account-check/form');
    Route::post('account-check/{id?}', [AuthController::class, 'accountCheck'])->name('user/account-check');
    Route::get('regenerate-code/{id?}', [AuthController::class, 'regenerateCode'])->name('user/regenerate-code');
    Route::get('check-token', [AuthController::class, 'checkToken']);

    Route::get('send-reset-code', [AuthController::class, 'sendResetCodePasswordForm'])->name('user/send-reset-code/form');
    Route::post('send-reset-code', [AuthController::class, 'sendResetCodePassword'])->name('user/send-reset-code/check');
    Route::get('reset/{id?}', [AuthController::class, 'resetPasswordForm'])->name('user/reset-password/form');
    Route::post('reset/{id?}', [AuthController::class, 'resetPassword'])->name('user/reset-password');
    
    Route::group(['middleware' => ['auth']], function(){

        Route::get('get/providers/{offset?}/{limit?}', [HomeController::class, 'providers'])->name('user/get/providers');
        Route::get('get/categories/{offset?}/{limit?}', [HomeController::class, 'categoriesSearch'])->name('user/get/categories');

        Route::group(['prefix' => 'user'], function(){
            Route::get('/profile', [AuthController::class, 'profile'])->name('user/profile');
            Route::post('/update', [AuthController::class, 'userUpdate'])->name('user/update');
            Route::post('/lang/update', [AuthController::class, 'userLang'])->name('user/lang/update');
            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('user/changePassword');
            Route::get('logout', [AuthController::class, 'logout'])->name('user/logout');
            Route::get('/cart', [AuthController::class, 'cart'])->name('user/cart');
            Route::get('/favorites', [AuthController::class, 'favorites'])->name('user/favorites');
            
            Route::post('/change-mobile-number', [AuthController::class, 'changeMobileNum']);
            Route::post('/guide/album', [AuthController::class, 'guideAlbum']);
            Route::get('delete-account', [AuthController::class, 'deleteAccount']);
            Route::get('/statistics', [AuthController::class, 'statistics']);
            Route::get('/notifications/{offset?}/{limit?}', [AuthController::class, 'notifications']);
            Route::get('/favorites/remove', [AuthController::class, 'removeFromFavorites']);
        });
        
        Route::group(['prefix' => 'orders'], function ($router) {
            Route::post('/', [OrderController::class, 'makeOrder'])->name('user/order/store');
            Route::post('/quotations', [OrderController::class, 'makeQuotation'])->name('user/quotations/store');
            Route::post('/maintenances', [OrderController::class, 'makeMaintenance'])->name('user/maintenances/store');
            Route::get('/get/{page_type}', [OrderController::class, 'myOrders'])->name('user/myorders');
            Route::post('/check/coupon', [OrderController::class, 'checkCoupon'])->name('user/check/coupon');
            Route::get('/order/cancel/{id?}', [OrderController::class, 'cancelOrder'])->name('user/cancel/order');
            Route::get('/order/{id?}/{from?}', [OrderController::class, 'order'])->name('user/get/order');
            Route::post('/order/update/{id?}', [OrderController::class, 'updateOrder'])->name('user/update/order');
            Route::post('/order/change/timeline', [OrderController::class, 'orderTimeline'])->name('user/order-timeline');
            Route::post('/offer/actions', [OrderController::class, 'offersActions'])->name('user/offer/actions');
            Route::get('/get-link/online-payment/{id?}', [OrderController::class, 'onlinePayment'])->name('user/online-payment/actions');
            Route::get('/order/offers/download/{id?}', [OrderController::class, 'offersDownload'])->name('user/order/offers/download');
            Route::post('/order/partial/receive', [OrderController::class, 'orderPartialReceive'])->name('user/order/partial-receive');
            
            Route::post('/offers', [OrderController::class, 'makeOffer'])->name('user/make/offer');
            Route::post('/offers/update/{id?}', [OrderController::class, 'editOffer'])->name('user/update/offer');
            Route::get('/offers/delete/{id?}', [OrderController::class, 'deleteOffer'])->name('user/delete/offer');
        });

        Route::group(['prefix' => 'cart'], function ($router) {
            Route::get('/checkout', [CartController::class, 'checkout'])->name('user/cart/checkout');
            Route::get('/toggle/{id?}', [CartController::class, 'toggleInCart'])->name('user/cart/toggle');
            Route::get('/remove/{id?}', [CartController::class, 'removeFromCart'])->name('user/cart/remove');
            Route::get('/update/quantity/{id?}', [CartController::class, 'updateQuantity'])->name('user/cart/update/quantity');

            Route::get('/add/{id?}', [CartController::class, 'addToCart']);
            Route::get('/remove/all/products', [CartController::class, 'removeAll']);
        });
        
        Route::group(['prefix' => 'favorites'], function ($router) {
            Route::get('/toggle/{id?}', [FavoriteController::class, 'toggleInFavorites'])->name('user/favorites/toggle');
            Route::get('/remove/{id?}', [FavoriteController::class, 'removeFromFavorites']);
            Route::get('/remove/all/products', [FavoriteController::class, 'removeAll']);
        });

        Route::group(['prefix' => 'ratings'], function ($router) {
            Route::post('/', [RatingController::class, 'rating'])->name('user/store/ratings');
        });
    });
    
});

// =====================================================
// VENDOR ROUTES
// =====================================================

// Vendor Public Routes (Auth)
Route::group(['prefix' => 'vendor', 'middleware' => ['limitReq']], function() {
    // Login
    Route::get('/login', [VendorAuthController::class, 'loginForm'])->name('vendor/login');
    Route::post('/check/login', [VendorAuthController::class, 'login'])->name('vendor/check/login');
    
    // Register
    Route::get('/register', [VendorAuthController::class, 'registerForm'])->name('vendor/register/form');
    Route::post('/register', [VendorAuthController::class, 'register'])->name('vendor/register/store');
    
    // Account Verification
    Route::get('/account-check/{id?}', [VendorAuthController::class, 'accountCheckForm'])->name('vendor/account-check/form');
    Route::post('/account-check/{id?}', [VendorAuthController::class, 'accountCheck'])->name('vendor/account-check');
    Route::post('/regenerate-code/{id?}', [VendorAuthController::class, 'regenerateCode'])->name('vendor/regenerate-code');
    
    // Password Reset
    Route::get('/send-reset-code', [VendorAuthController::class, 'sendResetCodePasswordForm'])->name('vendor/send-reset-code/form');
    Route::post('/send-reset-code', [VendorAuthController::class, 'sendResetCodePassword'])->name('vendor/send-reset-code/check');
    Route::get('/reset/{id?}', [VendorAuthController::class, 'resetPasswordForm'])->name('vendor/reset-password/form');
    Route::post('/reset/{id?}', [VendorAuthController::class, 'resetPassword'])->name('vendor/reset-password');
});

// Vendor Protected Routes
Route::group(['prefix' => 'vendor', 'middleware' => ['auth', 'vendorCheck']], function() {
    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'dashboard'])->name('vendor/dashboard');
    
    // Profile
    Route::get('/profile', [VendorAuthController::class, 'profile'])->name('vendor/profile');
    Route::post('/update', [VendorAuthController::class, 'userUpdate'])->name('vendor/update');
    Route::post('/lang/update', [VendorAuthController::class, 'userLang'])->name('vendor/lang/update');
    Route::post('/change-password', [VendorAuthController::class, 'changePassword'])->name('vendor/changePassword');
    Route::get('/logout', [VendorAuthController::class, 'logout'])->name('vendor/logout');
    
    
    // Products
    Route::get('/products', [VendorProductController::class, 'index'])->name('vendor/products');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('vendor/products/create');
    Route::post('/products/store', [VendorProductController::class, 'store'])->name('vendor/products/store');
    Route::get('/products/{id}', [VendorProductController::class, 'show'])->name('vendor/products/show');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('vendor/products/edit');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('vendor/products/update');
    Route::get('/products/{id}/toggle', [VendorProductController::class, 'toggleActivation'])->name('vendor/products/toggle');
    Route::delete('/products/{id}', [VendorProductController::class, 'destroy'])->name('vendor/products/delete');
    
    // Orders
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('vendor/orders');
    Route::get('/orders/{id}', [VendorOrderController::class, 'show'])->name('vendor/orders/show');
    Route::get('/orders/{id}/offer', [VendorOrderController::class, 'offerForm'])->name('vendor/orders/offer-form');
    Route::post('/offers', [VendorOrderController::class, 'makeOffer'])->name('vendor/orders/make-offer');
    
    // My Offers
    Route::get('/my-offers', [VendorOrderController::class, 'myOffers'])->name('vendor/orders/my-offers');
    Route::get('/offers/{id}/edit', [VendorOrderController::class, 'editOffer'])->name('vendor/orders/offer-edit');
    Route::put('/offers/{id}', [VendorOrderController::class, 'updateOffer'])->name('vendor/orders/offer-update');
    Route::delete('/offers/{id}', [VendorOrderController::class, 'deleteOffer'])->name('vendor/orders/offer-delete');
    
    // Ratings & Reviews (Phase 3)
    Route::get('/ratings', [VendorRatingsController::class, 'index'])->name('vendor/ratings');
    
    // Notifications (Phase 3)
    Route::get('/notifications', [VendorNotificationsController::class, 'index'])->name('vendor/notifications');
    Route::post('/notifications/{id}/mark-as-read', [VendorNotificationsController::class, 'markAsRead'])->name('vendor/notifications/mark-as-read');
    Route::delete('/notifications/{id}', [VendorNotificationsController::class, 'delete'])->name('vendor/notifications/delete');
    Route::post('/notifications/mark-all-as-read', [VendorNotificationsController::class, 'markAllAsRead'])->name('vendor/notifications/mark-all-as-read');
    
    // Analytics (Phase 3)
    Route::get('/analytics', [VendorAnalyticsController::class, 'index'])->name('vendor/analytics');
});

