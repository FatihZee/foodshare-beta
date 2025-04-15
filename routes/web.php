<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/modules/auth.php';
require __DIR__.'/modules/donation.php';
require __DIR__.'/modules/claim.php';
require __DIR__.'/modules/category.php';
require __DIR__.'/modules/user.php';
require __DIR__.'/modules/review.php';
require __DIR__.'/modules/article.php';
require __DIR__.'/modules/wishlist.php';
require __DIR__.'/modules/notification.php';

// Route untuk halaman home
Route::get('/', function () {
    return view('home');
})->name('home');