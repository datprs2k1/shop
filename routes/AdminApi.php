<?php

use App\Http\Controllers\Admin\CategoryController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::delete('/category/trash/{id}', 'deleteFromTrash');
        Route::put('/category/trash/restore/{id}', 'restoreFromTrash');
        Route::get('/category/trash', 'listTrash');
    });
    Route::resource('/category', CategoryController::class);
});
