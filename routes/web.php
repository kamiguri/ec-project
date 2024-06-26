<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\PurchaseController;
use App\Http\Controllers\User\FavoriteController;
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

    //コメントのデータベース登録メソッド
    Route::post('/item/{item_id}/comments', [ItemController::class, 'storeComment'])->name('comments.store');

    //商品のお気に入り機能
    Route::post('/items/{item_id}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
    Route::delete('/items/{item_id}/unfavorite', [ItemController::class, 'unfavorite'])->name('items.unfavorite');
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::get('/search', [ItemController::class, 'search'])->name('search');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{item_id}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{item_id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/{item_id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::get('/purchase-history', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase-history/search', [PurchaseController::class, 'search'])
    ->name('purchase.search');

    //メールの処理
    Route::get('/payment', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
});




require __DIR__ . '/auth.php';
