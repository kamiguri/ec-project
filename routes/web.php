<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\PurchaseController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('show');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

    Route::get('/search', [ItemController::class, 'search'])->name('search');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{item_id}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{item_id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/{item_id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::get('/purchase-history', [PurchaseController::class, 'index'])->name('purchase.index');

    //メールの処理
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/complete', [PaymentController::class, 'complete'])->name('payment.complete');
    Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
});

require __DIR__ . '/auth.php';
