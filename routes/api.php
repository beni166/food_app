<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\regiserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('users/create', [regiserController::class, 'register']);
Route::post('users/login', [regiserController::class, 'loginned']);
Route::get('users/info', [regiserController::class, 'info']);



Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/foods', [ProductController::class, 'index']);
Route::get('/products/category/{id}', [ProductController::class, 'indexByCategory']);
Route::get('/foods/search', [ProductController::class, 'search']);
Route::get('/foods-by-category/{id}', [ProductController::class, 'foodsByCategory']);
Route::get('/promotions', [PromotionController::class, 'index']);



Route::middleware('mobile_auth')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::post('users/logout', [regiserController::class, 'logout']);
        Route::put('users/update', [regiserController::class, 'update']);
        Route::post('create', [OrderController::class, 'saveOrder']);
        Route::get('one/{order}', [OrderController::class, 'getOne']);
        Route::get('/', [OrderController::class, 'getAll']);
        Route::put('update-statut/{order}', [OrderController::class, 'changeStatus']);
    });
});

Route::prefix('admin')->group(function () {
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::put('/orders/{order}/products/{product}', [OrderController::class, 'updateProductStatus']);
});
