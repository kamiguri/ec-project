<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('seller.dashboard');
})->middleware(['auth:sellers', 'verified'])->name('dashboard');


require __DIR__.'/sellerAuth.php';
