<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;

Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/', [WishlistController::class, 'store'])->name('store');
    Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('destroy');
});