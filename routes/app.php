<?php

use App\Http\Controllers\Api\App\AdController;
use App\Http\Controllers\Api\App\AuthenticationController;
use App\Http\Controllers\Api\App\StoreController;
use App\Http\Controllers\Api\App\SwapController;
use App\Http\Controllers\Api\App\UserController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AuthController;
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

Route::prefix("app")->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/buyer/register', [AuthenticationController::class, 'buyerRegister']);
    Route::post('/affiliate/register', [AuthenticationController::class, 'affiliateRegister']);
    Route::post('/forgot-password', [AuthenticationController::class, 'login']);
    Route::put('/reset-password', [AuthenticationController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::prefix('ad')->group(function () {
            Route::post('create', [AdController::class, 'create']);
            Route::get('list', [AdController::class, 'list']);
            Route::get('list/state', [AdController::class, 'stateList']);
            Route::get('list/maker', [AdController::class, 'makerList']);
            Route::get('list/condition', [AdController::class, 'conditionList']);
            Route::get('list/transmission', [AdController::class, 'transmissionList']);
            Route::get('list/model', [AdController::class, 'modelList']);
            Route::get('list/trim', [AdController::class, 'trimList']);
            Route::get('list/category', [AdController::class, 'categoryList']);
            Route::get('list/colour', [AdController::class, 'colourList']);
        });

        Route::prefix('swap')->group(function () {
            Route::post('create', [SwapController::class, 'create']);
            Route::get('list', [SwapController::class, 'list']);
            Route::get('list/sales_type', [SwapController::class, 'saleList']);
        });

        Route::prefix('store')->group(function () {
            Route::get('overview', [StoreController::class, 'overview']);
            Route::get('onsale', [StoreController::class, 'onSale']);
            Route::get('unposted', [StoreController::class, 'unposted']);
            Route::get('sold', [StoreController::class, 'sold']);
        });

        Route::apiResource('watchlist', \App\Http\Controllers\Api\App\WatchListController::class);

        Route::get('profile', [UserController::class, 'profile']);
        Route::post('profile', [UserController::class, 'updateProfile']);
        Route::post('update-avatar', [UserController::class, 'updateAvatar']);
        Route::post('change-password', [UserController::class, 'changePassword']);

    });

});

