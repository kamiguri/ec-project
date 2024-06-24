<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\SellerItemController as SellerItemController;
use App\Http\Controllers\User\ItemController;

Route::get('/dashboard', function () {
    return view('seller.dashboard');
})->middleware(['auth:sellers', 'verified'])->name('dashboard');

// seller.dashboardへのアクセス後、商品管理に遷移できるように変更
Route::middleware(['auth:sellers', 'verified'])->group(function () {
    Route::get('/items/create', [SellerItemController::class, 'create'])->name('items.create');
    Route::post('/items', [SellerItemController::class, 'store'])->name('items.store');
    Route::get('/items', [SellerItemController::class, 'index'])->name('items.index');
    // ...他のseller側の商品管理ルート...
    Route::get('/show/{item_id}', [SellerItemController::class, 'show'])->name('show');
    //item詳細画面
    Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('show');
});

require __DIR__ . '/sellerAuth.php';
