<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;

Route::resource('claims', ClaimController::class);
Route::get('/donations/{donation}/claims', [ClaimController::class, 'donationClaims'])->name('donations.claims');
Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');