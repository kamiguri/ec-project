<?php

use App\Http\Controllers\Seller\ProfileController;
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
    Route::get("/item/{item_id}/edit",[SellerItemController::class,"edit"])->name("edit");
    Route::post("/item/{item_id}/edit",[SellerItemController::class,"update"])->name("update");
    // ...他のseller側の商品管理ルート...
    Route::get('/show/{item_id}', [SellerItemController::class, 'show'])->name('show');
    Route::get("/item/{item_id}/stock",[SellerItemController::class,"stock_edit"])->name("stock");
    Route::post("/item/{item_id}/stock",[SellerItemController::class,"stock_update"])->name("stock");
    //item詳細画面
    Route::get('/item/{item_id}', [SellerItemController::class, 'show'])->name('show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/analysis', [SellerItemController::class, 'analysis'])->name('analysis');

});

    // ...他のseller側の商品管理ルート...




require __DIR__ . '/sellerAuth.php';
