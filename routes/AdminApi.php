<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SupplierController;
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

Route::get('category/export', [CategoryController::class, 'export']);
Route::get('supplier/export', [SupplierController::class, 'export']);
Route::get('product/export', [ProductController::class, 'export']);
Route::get('inventory/export', [InventoryController::class, 'export']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/upload', [ImageController::class, 'store']);
    Route::get('/media/{id}', [ImageController::class, 'getImages']);

    Route::controller(CategoryController::class)->group(function () {
        Route::delete('/category/trash/{id}', 'deleteFromTrash');
        Route::put('/category/trash/restore/{id}', 'restoreFromTrash');
        Route::get('/category/trash', 'listTrash');
    });
    Route::resource('/category', CategoryController::class);

    Route::controller(SupplierController::class)->group(function () {
        Route::delete('/supplier/trash/{id}', 'deleteFromTrash');
        Route::put('/supplier/trash/restore/{id}', 'restoreFromTrash');
        Route::get('/supplier/trash', 'listTrash');
    });
    Route::resource('/supplier', SupplierController::class);

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/status', 'getProductStatus');
        Route::get('/product/unit', 'getProductUnit');
        Route::delete('/product/trash/{id}', 'deleteFromTrash');
        Route::put('/product/trash/restore/{id}', 'restoreFromTrash');
        Route::get('/product/trash', 'listTrash');
    });
    Route::resource('/product', ProductController::class);

    Route::controller(OrderController::class)->group(function () {
        Route::post('/order/approve/{id}', 'approve');
        Route::post('/order/cancel/{id}', 'cancel');
        Route::get('/order', 'index');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/report/month', 'doanhthutrong30ngay');
        Route::get('/report/year', 'doanhthutrong12thang');
        Route::get('/report/product', 'sanpham');
    });

    Route::controller(InventoryController::class)->group(function () {
        Route::get('/inventory/status', 'getStatus');
        Route::get('/inventory/logstatus', 'getLogStatus');
        Route::get('/inventory', 'index');
        Route::post('/inventory', 'store');
        Route::get('/inventory/{id}', 'show');
    });
});
