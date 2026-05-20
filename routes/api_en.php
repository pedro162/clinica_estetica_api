<?php

use App\Http\Controllers\Admin\V1\Category\DeleteCategoryController;
use App\Http\Controllers\Admin\V1\Category\GetAllCategoryController;
use App\Http\Controllers\Admin\V1\Category\GetByIdCategoryController;
use App\Http\Controllers\Admin\V1\Category\StoreCategoryController;
use App\Http\Controllers\Admin\V1\Category\UpdateCategoryController;
use App\Http\Controllers\Admin\V1\Neighborhood\DeleteNeighborhoodController;
use App\Http\Controllers\Admin\V1\Neighborhood\GetAllNeighborhoodController;
use App\Http\Controllers\Admin\V1\Neighborhood\GetByIdNeighborhoodController;
use App\Http\Controllers\Admin\V1\Neighborhood\StoreNeighborhoodController;
use App\Http\Controllers\Admin\V1\Neighborhood\UpdateNeighborhoodController;
use App\Http\Controllers\Admin\V1\Seller\DeleteSellerController;
use App\Http\Controllers\Admin\V1\Seller\GetAllSellerController;
use App\Http\Controllers\Admin\V1\Seller\GetByIdSellerController;
use App\Http\Controllers\Admin\V1\Seller\StoreSellerController;
use App\Http\Controllers\Admin\V1\Seller\UpdateSellerController;
use App\Http\Controllers\Admin\V1\WorkOrder\Actions\AddItemWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\Actions\CancelWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\Actions\ConcludeWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\Actions\FinalizeWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\Actions\RemoveItemWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive\DeleteCancelingMotiveController;
use App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive\GetAllCancelingMotiveController;
use App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive\GetByIdCancelingMotiveController;
use App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive\StoreCancelingMotiveController;
use App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive\UpdateCancelingMotiveController;
use App\Http\Controllers\Admin\V1\WorkOrder\DeleteWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\GetAllWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\GetByIdWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\StoreWorkOrderController;
use App\Http\Controllers\Admin\V1\WorkOrder\UpdateWorkOrderController;
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

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/v1/sellers', ['as' => 'sellers.index', 'uses' => GetAllSellerController::class]);
    Route::get('/v1/sellers/{id}', ['as' => 'sellers.show', 'uses' => GetByIdSellerController::class]);
    Route::post('/v1/sellers', ['as' => 'sellers.store', 'uses' => StoreSellerController::class]);
    Route::put('/v1/sellers/{id}', ['as' => 'sellers.update', 'uses' => UpdateSellerController::class]);
    Route::delete('/v1/sellers/{id}', ['as' => 'sellers.destroy', 'uses' => DeleteSellerController::class]);

    Route::get('/v1/categories', ['as' => 'categories.index', 'uses' => GetAllCategoryController::class]);
    Route::get('/v1/categories/{id}', ['as' => 'categories.show', 'uses' => GetByIdCategoryController::class]);
    Route::post('/v1/categories', ['as' => 'categories.store', 'uses' => StoreCategoryController::class]);
    Route::put('/v1/categories/{id}', ['as' => 'categories.update', 'uses' => UpdateCategoryController::class]);
    Route::delete('/v1/categories/{id}', ['as' => 'categories.destroy', 'uses' => DeleteCategoryController::class]);

    Route::get('/v1/neighborhoods', ['as' => 'neighborhoods.index', 'uses' => GetAllNeighborhoodController::class]);
    Route::get('/v1/neighborhoods/{id}', ['as' => 'neighborhoods.show', 'uses' => GetByIdNeighborhoodController::class]);
    Route::post('/v1/neighborhoods', ['as' => 'neighborhoods.store', 'uses' => StoreNeighborhoodController::class]);
    Route::put('/v1/neighborhoods/{id}', ['as' => 'neighborhoods.update', 'uses' => UpdateNeighborhoodController::class]);
    Route::delete('/v1/neighborhoods/{id}', ['as' => 'neighborhoods.destroy', 'uses' => DeleteNeighborhoodController::class]);

    Route::get('/v1/work-orders', ['as' => 'work-orders.index', 'uses' => GetAllWorkOrderController::class]);
    Route::post('/v1/work-orders', ['as' => 'work-orders.search', 'uses' => GetAllWorkOrderController::class]);
    Route::get('/v1/work-orders/{id}', ['as' => 'work-orders.show', 'uses' => GetByIdWorkOrderController::class]);
    Route::post('/v1/work-orders', ['as' => 'work-orders.store', 'uses' => StoreWorkOrderController::class]);
    Route::put('/v1/work-orders/{id}', ['as' => 'work-orders.update', 'uses' => UpdateWorkOrderController::class]);
    Route::delete('/v1/work-orders/{id}', ['as' => 'work-orders.destroy', 'uses' => DeleteWorkOrderController::class]);

    Route::get('/v1/work-order-canceling-motives', ['as' => 'work-order-canceling-motives.index', 'uses' => GetAllCancelingMotiveController::class]);
    Route::post('/v1/work-order-canceling-motives', ['as' => 'work-order-canceling-motives.search', 'uses' => GetAllCancelingMotiveController::class]);
    Route::get('/v1/work-order-canceling-motives/{id}', ['as' => 'work-order-canceling-motives.show', 'uses' => GetByIdCancelingMotiveController::class]);
    Route::post('/v1/work-order-canceling-motives', ['as' => 'work-order-canceling-motives.store', 'uses' => StoreCancelingMotiveController::class]);
    Route::put('/v1/work-order-canceling-motives/{id}', ['as' => 'work-order-canceling-motives.update', 'uses' => UpdateCancelingMotiveController::class]);
    Route::delete('/v1/work-order-canceling-motives/{id}', ['as' => 'work-order-canceling-motives.destroy', 'uses' => DeleteCancelingMotiveController::class]);

    Route::post('/v1/work-orders/{id}/conclude', ['as' => 'work-orders.conclude', 'uses' => ConcludeWorkOrderController::class]);
    Route::post('/v1/work-orders/{id}/cancel', ['as' => 'work-orders.cancel', 'uses' => CancelWorkOrderController::class]);
    Route::post('/v1/work-orders/{id}/finalize', ['as' => 'work-orders.finalize', 'uses' => FinalizeWorkOrderController::class]);
    Route::post('/v1/work-orders/{id}/add-item', ['as' => 'work-orders.add-item', 'uses' => AddItemWorkOrderController::class]);
    Route::delete('/v1/work-orders/items/{id}', ['as' => 'work-orders.remove-item', 'uses' => RemoveItemWorkOrderController::class]);
});
