<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    
    Route::get('register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('donations', DonationController::class);
Route::resource('claims', ClaimController::class);
Route::resource('categories', CategoryController::class);

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('articles', ArticleController::class);

    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/', [WishlistController::class, 'store'])->name('store');
        Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('destroy');
    });

    Route::get('/donations/{donation}/claims', [ClaimController::class, 'donationClaims'])->name('donations.claims');
    Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});