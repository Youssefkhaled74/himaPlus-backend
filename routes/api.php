<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FavorateController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymobController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['api', 'limitReq']], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('regenerate-code', [AuthController::class, 'regenerateCode']);
        Route::post('mobile-check', [AuthController::class, 'mobileCheck']);
        Route::get('check-token', [AuthController::class, 'checkToken']);

        Route::post('send-reset-code', [AuthController::class, 'sendResetCodePassword']);
        Route::post('verify-reset-code', [AuthController::class, 'verifyResetCodePassword']);
        Route::post('reset', [AuthController::class, 'resetPassword']);
    });

    Route::group(['middleware' => 'userActivation'], function ($router) {

        Route::group(['prefix' => 'auth'], function ($router) {
            Route::get('/', [AuthController::class, 'me']);
            Route::get('refresh', [AuthController::class, 'refresh']);
            Route::post('change-password', [AuthController::class, 'changePassword']);
            Route::post('/change-mobile-number', [AuthController::class, 'changeMobileNum']);
            Route::post('/update', [AuthController::class, 'userUpdate']);
            Route::post('/guide/album', [AuthController::class, 'guideAlbum']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('delete-account', [AuthController::class, 'deleteAccount']);
            Route::get('/statistics', [AuthController::class, 'statistics']);
            Route::get('/cart', [AuthController::class, 'cart']);
            Route::get('/notifications/{offset?}/{limit?}', [AuthController::class, 'notifications']);
            Route::get('/favorites/{offset?}/{limit?}', [AuthController::class, 'favorites']);
            Route::get('/favorites/remove', [AuthController::class, 'removeFromFavorites']);
        });
        
        Route::group(['prefix' => 'cart'], function ($router) {
            Route::get('/toggle/{id?}', [CartController::class, 'toggleInCart']);
            Route::get('/add/{id?}', [CartController::class, 'addToCart']);
            Route::get('/remove/{id?}', [CartController::class, 'removeFromCart']);
            Route::get('/remove/all/products', [CartController::class, 'removeAll']);
            Route::get('/update/quantity/{id?}', [CartController::class, 'updateQuantity']);
        });
        
        Route::group(['prefix' => 'favorites'], function ($router) {
            Route::get('/toggle/{id?}', [FavoriteController::class, 'toggleInFavorites']);
            Route::get('/remove/{id?}', [FavoriteController::class, 'removeFromFavorites']);
            Route::get('/remove/all/products', [FavoriteController::class, 'removeAll']);
        });

        Route::group(['prefix' => 'products'], function ($router) {
            Route::post('/store', [ProductController::class, 'store']);
            Route::post('/update/{id?}', [ProductController::class, 'update']);
            Route::get('/activate/{id?}', [ProductController::class, 'activate']);
        });

        Route::group(['prefix' => 'orders'], function ($router) {
            Route::get('/order/{id?}', [OrderController::class, 'order']);
            Route::post('/order/update/{id?}', [OrderController::class, 'updateOrder']);
            Route::post('/', [OrderController::class, 'makeOrder']);
            Route::post('/quotations', [OrderController::class, 'makeQuotation']);
            Route::post('/maintenances', [OrderController::class, 'makeMaintenance']);
            Route::post('/order/change/timeline', [OrderController::class, 'orderTimeline']);
            Route::post('/order/partial/receive', [OrderController::class, 'orderPartialReceive']);
            Route::post('/offer/actions', [OrderController::class, 'offersActions']);
            Route::post('/offers', [OrderController::class, 'makeOffer']);
            Route::post('/offers/update/{id?}', [OrderController::class, 'editOffer']);
            Route::get('/offers/delete/{id?}', [OrderController::class, 'deleteOffer']);
            Route::get('/get/{offset?}/{limit?}', [OrderController::class, 'myOrders']);
            Route::get('/get/random/{offset?}/{limit?}', [OrderController::class, 'randomOrders']);
            Route::get('/get/provider/orders/{offset?}/{limit?}', [OrderController::class, 'providerOrders']);
            Route::post('/check/coupon', [OrderController::class, 'checkCoupon']);
            Route::get('/order/cancel/{id?}', [OrderController::class, 'cancelOrder']);
            Route::get('/get-link/online-payment/{id?}', [OrderController::class, 'onlinePayment']);
        });
        
        Route::group(['prefix' => 'ratings'], function ($router) {
            Route::post('/', [RatingController::class, 'rating']);
        });

        Route::group(['prefix' => 'chat'], function ($router) {
            Route::get('/conversations', [ChatController::class, 'getConversations']);
            Route::get('/conversation', [ChatController::class, 'getConversation']);
            Route::get('/conversation/{id?}/{offset?}/{limit?}', [ChatController::class, 'getMessages']);
            Route::post('/messages/send', [ChatController::class, 'sendMessage']);
            Route::get('/messages/mark-as-read/{id?}', [ChatController::class, 'markAsRead']);
            Route::get('/messages/delete/{id?}', [ChatController::class, 'deleteMessage']);
            Route::get('/unread-count/{id?}', [ChatController::class, 'getUnreadCount']);
            Route::post('/conversations/{id}/toggle-block', [ChatController::class, 'toggleBlockConversation']);
        });

    });

    Route::group(['prefix' => 'products'], function ($router) {
        Route::get('/details/{id?}', [ProductController::class, 'details']);
        Route::get('/{offset?}/{limit?}', [ProductController::class, 'products']);
    });

    Route::get('/pay/callback', [PaymobController::class, 'callback']);
    Route::get('/pay/webhook', [PaymobController::class, 'webhook']);

    Route::get('home', [HomeController::class, 'home']);
    Route::get('info', [HomeController::class, 'info']);
    Route::post('test', [HomeController::class, 'test']);
    Route::get('countries', [HomeController::class, 'countries']);
    Route::post('contact-us', [HomeController::class, 'contactUs']);
    Route::get('get/ratings/{offset?}/{limit?}', [HomeController::class, 'ratings']);
    Route::get('get/providers/{offset?}/{limit?}', [HomeController::class, 'providers']);
    Route::get('categories/{offset?}/{limit?}', [HomeController::class, 'categories']);
});