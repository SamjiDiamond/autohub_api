<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Front pages
Route::controller(FrontendController::class)->group(function () {
    Route::get('/home', 'index');
    Route::get('/product-details/{slug}', 'productDetails');
    Route::get('/product-options', 'options');
    // Route::get('/reset-password', 'resetPassword');
});

// Auth pages
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('api-login');
    Route::post('/register', 'register')->name('api-register');
    Route::post('/forgot-password', 'forgotPassword')->name('api-forgot-password');
    Route::put('/reset-password', 'resetPassword')->name('api-reset-password');
});

// User Area
Route::controller(VFDController::class)->group(function () {
    Route::post('/login', 'login')->name('api-login');
    Route::post('/register', 'register')->name('api-register');
    Route::post('/forgot-password', 'forgotPassword')->name('api-forgot-password');
    Route::put('/reset-password', 'resetPassword')->name('api-reset-password');
});
