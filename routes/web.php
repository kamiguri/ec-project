<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\StockController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix("buyer")->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('show');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
});

Route::get("/create",[StockController::class,"create"])->name("stock.create");
Route::post("/store",[StockController::class,"store"])->name("stock.store");


require __DIR__ . '/auth.php';
