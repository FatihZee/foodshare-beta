<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
});