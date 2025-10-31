<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\Admin\NotificationController;

Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => "admin", 'as' => 'admin.'], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'getUser'])->name('profile.user');
    Route::get('/profile/update', [AdminController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'update'])->name('profile.update');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])
    ->name('notifications.show');

    // category

    Route::resource('categories', CategoryController::class);
    // Product
    Route::resource('Produits', ProductController::class);
    //Commande
    Route::resource('orders', OrderController::class);
    //promotion
    Route::resource('promotion', PromotionController::class);

    Route::post('promotions/{promotion}/toggle', [PromotionController::class, 'toggle'])->name('promotion.toggle');
});
