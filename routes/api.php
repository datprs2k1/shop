<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('category', 'index');
    Route::get('category/{id}', 'detail');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product/status', 'getProductStatus');
    Route::get('/product/unit', 'getProductUnit');
    Route::get('product/{id}', 'detail');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('address/city', 'city');
    Route::get('address/district/{city}', 'district');
});

Route::get('order/method', [OrderController::class, 'getMethod']);
Route::get('order/status', [OrderController::class, 'getStatus']);

Route::post('search', [ProductController::class, 'search']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('account', 'getInfo');
        Route::post('account', 'changeInfo');
        Route::post('account/password', 'changePassword');
    });
    Route::resource('cart', CartController::class);
    Route::resource('order', OrderController::class);
    Route::controller(AddressController::class)->group(function () {
        Route::get('address', 'index');
        Route::post('address', 'store');
    });
});
