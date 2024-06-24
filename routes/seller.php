<?php

use App\Http\Controllers\Seller\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\SellerItemController as SellerItemController;

Route::get('/dashboard', function () {
    return view('seller.dashboard');
})->middleware(['auth:sellers', 'verified'])->name('dashboard');

// seller.dashboardへのアクセス後、商品管理に遷移できるように変更
Route::middleware(['auth:sellers', 'verified'])->group(function () {
    Route::get('/items/create', [SellerItemController::class, 'create'])->name('items.create');
    Route::post('/items', [SellerItemController::class, 'store'])->name('items.store');
    Route::get('/items', [SellerItemController::class, 'index'])->name('items.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    // Route::get("item/{item_id}/stock",[SellerItemController::class,"stock_edit"])->name("seller.stock");
    // ...他のseller側の商品管理ルート...




require __DIR__ . '/sellerAuth.php';
