<?php

use App\Http\Controllers\user\NotificationController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'isUser'], 'prefix' => "user", 'as' => 'user.'], function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    //Afficher les info du user
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])
        ->name('notifications.show');


    //Commande
    Route::resource('orders', OrderController::class);
    Route::put('/user/orders/{id}/cancel', [UserController::class, 'cancel'])->name('orders.cancel');
});
