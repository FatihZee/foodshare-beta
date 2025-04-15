<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;

Route::resource('donations', DonationController::class);