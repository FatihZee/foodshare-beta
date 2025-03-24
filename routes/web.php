<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DonationController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('donations', DonationController::class);

Route::resource('claims', ClaimController::class);

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('reviews', ReviewController::class);
});

Route::get('login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'registerForm'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register']);