<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\JWTMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Authentication Routes */
Route::group([ 'prefix' => '/v1/auth' ], function ($router) {
    Route::post('/forgot-password/otp', [AuthController::class, 'initiate_forgot_password_otp']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/check-email-exists', [AuthController::class, 'checkEmailExists']);
    Route::group([ 'middleware' =>['jwt.verify']], function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});
/* Authentication Routes End */

Route::group(['prefix' => '/v1'], function ($router) {
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::get('/email/forgot-password/{id}/{hash}', [AuthController::class, 'resetPassword'])->name('forgotpassword');
    Route::get('/mobile/verify/{otp}/{pin_id}', [AuthController::class, 'initiate_otp_validation'])->name('verification.verify_otp');
    Route::get('/email/check/{email}', [AuthController::class, 'checkEmailExists'])->name('verification.check_email');

    Route::middleware([JWTMiddleware::class])->group(function () {
        Route::group(['prefix' => '/stores'], function ($router) {
            Route::get('/list', [StoresController::class, 'getStores']);
            Route::get('/products', [StoresController::class, 'getStoreProducts']);
            Route::get('/product-share', [StoresController::class, 'getProductShares']);
        });

        Route::group(['prefix' => '/customer'], function ($router) {
            Route::get('/details', [CustomerController::class, 'getCustomerDetails']);
            Route::get('/cart', [CustomerController::class, 'getCustomerCart']);
            Route::post('/create-cart', [CustomerController::class, 'createCustomerCart']);
            Route::get('/order', [CustomerController::class, 'getCustomerOrder']);
            Route::post('/create-order', [CustomerController::class, 'createCustomerOrder']);
            Route::post('/initialize-paystack-payment', [CustomerController::class, 'initializePaystackPayment']);
            Route::post('/update-paystack-initialization', [CustomerController::class, 'updatePaystackInitialization']);
            Route::post('/create-complaint', [CustomerController::class, 'createCustomerComplaint']);

        });

    });

});


