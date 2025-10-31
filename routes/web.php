<?php

use App\Events\MyEvent;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('welcome');


Route::prefix('admin')->group(function () {
    Route::put('/orders/{order}/products/{product}', [OrderController::class, 'updateProductStatus']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
});


Route::post('/commande', [HomeController::class, 'create'])->name('commande.create');
Route::get('/commande/produit/{id}', [HomeController::class, 'showForm'])->name('commande.produit');


Route::get('/telecharger-facture/{order}', function (Order $order) {
    $path = "public/factures/facture_{$order->id}.pdf";

    abort_unless(Storage::exists($path), 404);

    return Storage::download($path, "facture_{$order->id}.pdf");
})->name('facture.download')->middleware('signed');

//cartController
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/modifier', [CartController::class, 'modifier'])->name('cart.modifier');
Route::post('/panier/supprimer', [CartController::class, 'supprimer'])->name('cart.supprimer');

Route::post('/panier/ajouter', [CartController::class, 'ajouter'])->name('cart.ajouter');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';

require __DIR__ . '/user.php';
