<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

Route::middleware('auth')->group(function () {
    Route::resource('reviews', ReviewController::class);
});